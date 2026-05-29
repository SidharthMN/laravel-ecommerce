<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $products = Product::with(['images', 'reviews' => function ($query) {
                $query->where('is_approved', true)->with('user')->latest();
            }])
            ->withAvg(['reviews' => fn ($query) => $query->where('is_approved', true)], 'rating')
            ->withCount(['reviews' => fn ($query) => $query->where('is_approved', true)])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('category', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $wishlistProductIds = $request->user()
            ->wishlists()
            ->pluck('product_id')
            ->all();

        return view('products.index', compact('products', 'search', 'wishlistProductIds'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function show(Request $request, Product $product)
    {
        $product->load([
            'images',
            'reviews' => function ($query) {
                $query->where('is_approved', true)->with('user')->latest();
            },
        ])->loadAvg(['reviews' => fn ($query) => $query->where('is_approved', true)], 'rating')
            ->loadCount(['reviews' => fn ($query) => $query->where('is_approved', true)]);

        $isWishlisted = $request->user()
            ->wishlists()
            ->where('product_id', $product->id)
            ->exists();

        return view('products.show', compact('product', 'isWishlisted'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);
        $currentQuantity = $cart[$id]['quantity'] ?? 0;

        if ($currentQuantity + 1 > $product->stock) {
            return redirect('/cart')->with('error', $this->stockExceededMessage($product, $currentQuantity + 1));
        }

        if(isset($cart[$id])) {
         $cart[$id]['quantity']++;
        } else {
        $cart[$id] = [
            "name" => $product->name,
            "price" => $product->price,
            "image" => $product->image,
            "stock" => $product->stock,
            "quantity" => 1
        ];
    }

    session()->put('cart', $cart);

    return redirect('/cart');
    }

    public function cart()
    {
        return view('cart');
    }

    public function removeCart($id)
{
    $cart = session()->get('cart');

    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect('/cart');
}

public function increaseQuantity($id)
{
    $cart = session()->get('cart');
    $product = Product::findOrFail($id);

    if(isset($cart[$id])) {
        if ($cart[$id]['quantity'] + 1 > $product->stock) {
            return redirect('/cart')->with('error', $this->stockExceededMessage($product, $cart[$id]['quantity'] + 1));
        }

        $cart[$id]['quantity']++;
        session()->put('cart', $cart);
    }

    return redirect('/cart');
}

    public function decreaseQuantity($id)
    {
    $cart = session()->get('cart');

    if(isset($cart[$id])) {

        if($cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        } else {
            unset($cart[$id]);
        }

            session()->put('cart', $cart);
        }

        return redirect('/cart');
    }

    public function store(Request $request)
{
    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

    $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'category' => $request->category,
        'price' => $request->price,
        'stock' => $request->stock,
        'image' => $imagePath,
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $product->images()->create([
                'image' => $image->store('products', 'public'),
            ]);
        }
    }

    return redirect('/products');
    
}
public function checkout()
{
    return view('checkout');
}

public function placeOrder(Request $request)
{
    $cart = session()->get('cart');

    if(!$cart) {
        return redirect('/cart');
    }

    // Validate customer and payment fields (we do NOT persist raw card data)
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'address' => ['required', 'string', 'max:1024'],
        'city' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:50'],
        'card_number' => ['required', 'digits_between:13,19'],
        'card_expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
        'card_cvc' => ['required', 'digits_between:3,4'],
    ]);

    // For PCI compliance, do not store full card data. If you need to persist
    // a payment method, integrate a gateway and store a token instead.
    $total = 0;

    foreach($cart as $id => $item) {
        $product = Product::find($id);

        if (!$product) {
            return redirect('/cart')->with('error', 'Order cannot be placed because one product is no longer available.');
        }

        if ($item['quantity'] > $product->stock) {
            return redirect('/cart')->with('error', $this->stockExceededMessage($product, $item['quantity']));
        }

        $total += $item['price'] * $item['quantity'];
    }

    DB::transaction(function () use ($request, $cart, $total, $data) {
        Order::create([
            'user_id' => $request->user()->id,
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
            'shipping_address' => $data['address'],
            'shipping_city' => $data['city'],
            'customer_phone' => $data['phone'],
            'total_price' => $total,
            'products' => $cart,
            'status' => 'Pending',
        ]);

        foreach ($cart as $id => $item) {
            Product::whereKey($id)->decrement('stock', $item['quantity']);
        }
    });

    session()->forget('cart');

    return redirect('/products')
        ->with('success', 'Order placed successfully!');
}

private function stockExceededMessage(Product $product, int $requestedQuantity): string
{
    return "Order cannot be placed. The stock you asked for {$product->name} is {$requestedQuantity}, but we only have {$product->stock} available.";
}
}
