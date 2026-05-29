<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'trendingProducts' => Product::latest()->take(6)->get(),
        ]);
    })->name('dashboard');

    Route::redirect('/user', '/profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::post('/cart/add/{id}', [ProductController::class, 'addToCart']);
    Route::get('/cart', [ProductController::class, 'cart']);
    Route::post('/cart/remove/{id}', [ProductController::class, 'removeCart']);
    Route::post('/cart/increase/{id}', [ProductController::class, 'increaseQuantity']);
    Route::post('/cart/decrease/{id}', [ProductController::class, 'decreaseQuantity']);

    Route::get('/checkout', [ProductController::class, 'checkout']);
    Route::post('/place-order', [ProductController::class, 'placeOrder']);

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/{product}/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/admin', [AdminOrderController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::patch('/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/admin/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/admin/products', [AdminOrderController::class, 'products'])->name('admin.products');
    Route::post('/admin/products', [AdminOrderController::class, 'storeProduct'])->name('admin.products.store');
    Route::patch('/admin/products/{product}', [AdminOrderController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminOrderController::class, 'deleteProduct'])->name('admin.products.destroy');
    Route::get('/admin/users', [AdminOrderController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}', [AdminOrderController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminOrderController::class, 'deleteUser'])->name('admin.users.destroy');
    Route::post('/admin/categories', [AdminOrderController::class, 'storeCategory'])->name('admin.categories.store');
    Route::delete('/admin/categories/{category}', [AdminOrderController::class, 'deleteCategory'])->name('admin.categories.destroy');
    Route::post('/admin/banners', [AdminOrderController::class, 'storeBanner'])->name('admin.banners.store');
    Route::delete('/admin/banners/{banner}', [AdminOrderController::class, 'deleteBanner'])->name('admin.banners.destroy');
    Route::post('/admin/coupons', [AdminOrderController::class, 'storeCoupon'])->name('admin.coupons.store');
    Route::delete('/admin/coupons/{coupon}', [AdminOrderController::class, 'deleteCoupon'])->name('admin.coupons.destroy');
    Route::patch('/admin/reviews/{review}', [AdminOrderController::class, 'updateReview'])->name('admin.reviews.update');
    Route::delete('/admin/reviews/{review}', [AdminOrderController::class, 'deleteReview'])->name('admin.reviews.destroy');
});
