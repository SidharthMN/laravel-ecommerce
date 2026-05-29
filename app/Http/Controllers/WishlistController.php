<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $wishlistItems = $request->user()
            ->wishlists()
            ->with(['product.reviews'])
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Product saved to wishlist.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $request->user()
            ->wishlists()
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Product removed from wishlist.');
    }

    public function moveToCart(Request $request, Product $product): RedirectResponse
    {
        $cart = session()->get('cart', []);
        $currentQuantity = $cart[$product->id]['quantity'] ?? 0;

        if ($currentQuantity + 1 > $product->stock) {
            return redirect('/cart')->with('error', "Order cannot be placed. The stock you asked for {$product->name} is " . ($currentQuantity + 1) . ", but we only have {$product->stock} available.");
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'stock' => $product->stock,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        $request->user()
            ->wishlists()
            ->where('product_id', $product->id)
            ->delete();

        return redirect('/cart')->with('success', 'Wishlist item moved to cart.');
    }
}
