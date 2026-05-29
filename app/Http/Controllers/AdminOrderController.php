<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    private array $statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];

    public function dashboard(Request $request): View
    {
        $this->authorizeAdmin($request);

        // Only include non-cancelled orders in revenue calculations
        $monthlyRevenue = Order::where('status', '!=', 'Cancelled')
            ->latest()
            ->get()
            ->groupBy(fn (Order $order) => $order->created_at->format('Y-m'))
            ->map(fn ($orders, $month) => (object) [
                'month' => $month,
                'revenue' => $orders->sum('total_price'),
            ])
            ->sortBy('month')
            ->take(6)
            ->values();

        return view('admin.dashboard', [
            'orders' => Order::with('user')->latest()->take(6)->get(),
            'products' => Product::latest()->take(6)->get(),
            'users' => User::latest()->take(6)->get(),
            'categories' => Category::latest()->get(),
            'banners' => Banner::latest()->get(),
            'coupons' => Coupon::latest()->get(),
            'reviews' => Review::with(['user', 'product'])->latest()->take(8)->get(),
            'lowStockProducts' => Product::where('stock', '<=', 5)->orderBy('stock')->take(8)->get(),
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'totalUsers' => User::count(),
            // Exclude cancelled orders so admin cancellations don't reduce reported revenue
            'revenue' => Order::where('status', '!=', 'Cancelled')->sum('total_price'),
            'pendingOrders' => Order::where('status', 'Pending')->count(),
            'monthlyRevenue' => $monthlyRevenue,
            'topProducts' => $this->topProducts(),
            'statuses' => $this->statuses,
        ]);
    }

    public function index(Request $request): View
    {
        $this->authorizeAdmin($request);

        return view('admin.orders', [
            'orders' => Order::with('user')->latest()->get(),
            'statuses' => $this->statuses,
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', $this->statuses)],
        ]);

        $order->update($data);

        return back()->with('success', 'Order status updated.');
    }

    public function destroy(Request $request, Order $order): RedirectResponse
    {
        $this->authorizeAdmin($request);
        $order->delete();

        return back()->with('success', 'Order deleted.');
    }

    public function products(Request $request): View
    {
        $this->authorizeAdmin($request);

        return view('admin.products', [
            'products' => Product::with('images')->latest()->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image'],
            'images.*' => ['nullable', 'image'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->images()->create(['image' => $image->store('products', 'public')]);
            }
        }

        return back()->with('success', 'Product added.');
    }

    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        if ($request->hasFile('image')) {
            $product->update(['image' => $request->file('image')->store('products', 'public')]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->images()->create(['image' => $image->store('products', 'public')]);
            }
        }

        return back()->with('success', 'Product updated.');
    }

    public function deleteProduct(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeAdmin($request);
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    public function users(Request $request): View
    {
        $this->authorizeAdmin($request);

        return view('admin.users', [
            'users' => User::latest()->get(),
        ]);
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $user->update([
            'is_admin' => $request->boolean('is_admin'),
            'is_banned' => $request->boolean('is_banned'),
        ]);

        return back()->with('success', 'User updated.');
    }

    public function deleteUser(Request $request, User $user): RedirectResponse
    {
        $this->authorizeAdmin($request);
        abort_if($request->user()->is($user), 422, 'You cannot delete your own account.');

        $user->delete();

        return back()->with('success', 'User removed.');
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $this->authorizeAdmin($request);

        Category::create($request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ]));

        return back()->with('success', 'Category added.');
    }

    public function deleteCategory(Request $request, Category $category): RedirectResponse
    {
        $this->authorizeAdmin($request);
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }

    public function storeBanner(Request $request): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($data);

        return back()->with('success', 'Banner added.');
    }

    public function deleteBanner(Request $request, Banner $banner): RedirectResponse
    {
        $this->authorizeAdmin($request);
        $banner->delete();

        return back()->with('success', 'Banner deleted.');
    }

    public function storeCoupon(Request $request): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'discount_percent' => ['required', 'integer', 'min:1', 'max:90'],
        ]);

        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active', true);

        Coupon::create($data);

        return back()->with('success', 'Coupon added.');
    }

    public function deleteCoupon(Request $request, Coupon $coupon): RedirectResponse
    {
        $this->authorizeAdmin($request);
        $coupon->delete();

        return back()->with('success', 'Coupon deleted.');
    }

    public function updateReview(Request $request, Review $review): RedirectResponse
    {
        $this->authorizeAdmin($request);

        $review->update(['is_approved' => $request->boolean('is_approved')]);

        return back()->with('success', 'Review updated.');
    }

    public function deleteReview(Request $request, Review $review): RedirectResponse
    {
        $this->authorizeAdmin($request);
        $review->delete();

        return back()->with('success', 'Review deleted.');
    }

    private function topProducts(): array
    {
        $totals = [];

        // Only consider products from non-cancelled orders
        Order::where('status', '!=', 'Cancelled')->get()->each(function (Order $order) use (&$totals) {
            foreach ($order->products ?? [] as $item) {
                $name = $item['name'] ?? 'Product';
                $totals[$name] = ($totals[$name] ?? 0) + ($item['quantity'] ?? 1);
            }
        });

        arsort($totals);

        return array_slice($totals, 0, 5, true);
    }

    private function authorizeAdmin(Request $request): void
    {
        abort_unless($request->user()->is_admin, 403);
    }
}
