<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Branch\OrderController as BranchOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\PriceChangeRequestController as AdminPriceChangeRequestController;
use App\Http\Controllers\Branch\PriceChangeRequestController as BranchPriceChangeRequestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return view('dashboard'); // public dashboard page
    }

    $user = Auth::user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->isBranch()) {
        return redirect()->route('branch.dashboard');
    }

    return redirect()->route('customer.dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Admin ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Management routes
        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('branches', BranchController::class)->except(['show']);

        // Price change requests
        Route::get('price-requests', [AdminPriceChangeRequestController::class, 'index'])->name('price-requests.index');
        Route::get('price-requests/history', [AdminPriceChangeRequestController::class, 'history'])->name('price-requests.history');
        Route::post('price-requests/{priceChangeRequest}/approve', [AdminPriceChangeRequestController::class, 'approve'])->name('price-requests.approve');
        Route::post('price-requests/{priceChangeRequest}/reject', [AdminPriceChangeRequestController::class, 'reject'])->name('price-requests.reject');
        Route::post('price-requests/{priceChangeRequest}/revert', [AdminPriceChangeRequestController::class, 'revert'])->name('price-requests.revert');
        Route::post('price-requests/{priceChangeRequest}/modify-price', [AdminPriceChangeRequestController::class, 'modifyPrice'])->name('price-requests.modifyPrice');

        Route::resource('blogs', AdminBlogController::class)->except(['show']);

        // Order management routes
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('/orders/{order}/approve-cancellation', [AdminOrderController::class, 'approveCancellation'])->name('orders.approveCancellation');
        Route::post('/orders/{order}/reject-cancellation', [AdminOrderController::class, 'rejectCancellation'])->name('orders.rejectCancellation');

        //Admin Contact thingy
        Route::get('/contact', [AdminContactController::class, 'index'])->name('contact');
        Route::delete('/contact/{contactSubmission}', [AdminContactController::class, 'destroy'])->name('contact.destroy');
    });


// ─── Branch ────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:branch'])
    ->prefix('branch')
    ->name('branch.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('branch.dashboard');
        })->name('dashboard');

        // Price change requests
        Route::get('price-requests', [BranchPriceChangeRequestController::class, 'index'])->name('price-requests.index');
        Route::get('price-requests/create', [BranchPriceChangeRequestController::class, 'create'])->name('price-requests.create');
        Route::post('price-requests', [BranchPriceChangeRequestController::class, 'store'])->name('price-requests.store');
        Route::get('/orders', [BranchOrderController::class, 'index'])->name('orders');
        Route::patch('/orders/{order}/status', [BranchOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('/orders/{order}/approve-cancellation', [BranchOrderController::class, 'approveCancellation'])->name('orders.approveCancellation');
        Route::post('/orders/{order}/reject-cancellation', [BranchOrderController::class, 'rejectCancellation'])->name('orders.rejectCancellation');
    });

// ─── Customer ──────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders');
        Route::post('/orders/{order}/cancel', [CustomerOrderController::class, 'requestCancellation'])->name('orders.cancel');

        });
Route::post('/checkout/select-address', [CheckoutController::class, 'selectAddress'])
    ->middleware(['auth', 'role:customer'])
    ->name('checkout.selectAddress');
require __DIR__.'/auth.php';


//blog
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

//products and cart
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'updateQuantity']);

//contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Static pages
Route::view('/clients', 'pages.clients')->name('clients');
Route::view('/about', 'pages.about')->name('about');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/sitemap', 'pages.sitemap')->name('sitemap');
Route::view('/gallery', 'pages.gallery')->name('gallery');
Route::view('/videos', 'pages.videos')->name('videos');
