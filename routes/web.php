<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Amber's Roots
|--------------------------------------------------------------------------
*/

if (!function_exists('getRivaajProducts')) {
function getRivaajProducts(bool $onlyActive = true) {
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
            $query = \App\Models\Product::query();
            if ($onlyActive) {
                $query->where('is_active', true)->orderBy('display_order', 'asc')->orderBy('id', 'asc');
            } else {
                $query->orderBy('display_order', 'asc')->orderBy('id', 'asc');
            }
            return $query->get()->keyBy('slug')->toArray();
        }
    } catch (\Throwable $e) {
        // Fallback if DB issues
    }

    return [];
}
}

// Home Page - Dynamic Storefront
Route::get('/', function () {
    $activeProducts = \App\Models\Product::active()->get();
    $featuredProduct = \App\Models\Product::active()->where('is_featured', true)->first()
        ?? $activeProducts->first()
        ?? \App\Models\Product::first();
    $approvedReviews = \App\Models\Review::approved()->latest()->take(12)->get();
    $totalApprovedReviews = \App\Models\Review::where('status', 'approved')->count();
    $averageRating = round((float)(\App\Models\Review::where('status', 'approved')->avg('rating') ?: 4.9), 1);

    // Keep $products array compatibility
    $products = $activeProducts->keyBy('slug')->toArray();

    return view('welcome', compact('products', 'activeProducts', 'featuredProduct', 'approvedReviews', 'totalApprovedReviews', 'averageRating'));
})->name('home');

// Products Listing Page - Dynamic Active Products
Route::get('/products', function () {
    $activeProducts = \App\Models\Product::active()->get();
    $products = $activeProducts->keyBy('slug')->toArray();
    return view('products', compact('products', 'activeProducts'));
})->name('products');

// Product Detail Full Page
Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\Product::where('slug', $slug)->first();
    
    // Alias compatibility fallback
    if (!$product) {
        if ($slug === 'ambers-roots-hair-oil') {
            $product = \App\Models\Product::where('slug', 'rivaaj-mahal-hair-oil')->first();
        } elseif ($slug === 'rivaaj-mahal-hair-oil') {
            $product = \App\Models\Product::where('slug', 'ambers-roots-hair-oil')->first();
        }
    }

    if (!$product) {
        abort(404);
    }

    // If product is inactive and visitor is not admin, abort 404
    if (!$product->is_active && !auth()->check()) {
        abort(404);
    }

    $activeProducts = \App\Models\Product::active()->where('id', '!=', $product->id)->take(4)->get();
    $relatedProducts = $activeProducts->keyBy('slug')->toArray();
    $approvedReviews = $product->approvedReviews()->take(10)->get();

    return view('product-detail', compact('product', 'relatedProducts', 'activeProducts', 'approvedReviews'));
})->name('product.show');

// Full Cart Page
Route::get('/cart', function () {
    $activeProducts = \App\Models\Product::active()->get();
    $products = $activeProducts->keyBy('slug')->toArray();
    return view('cart', compact('products', 'activeProducts'));
})->name('cart');

// Daraz-Style Multi-Step Checkout Page
Route::get('/checkout', function () {
    $activeProducts = \App\Models\Product::active()->get();
    $products = $activeProducts->keyBy('slug')->toArray();
    return view('checkout', compact('products', 'activeProducts'));
})->name('checkout');

// Public Customer Order Placement (Saves in DB first, then generates WhatsApp link)
Route::post('/orders/place', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.place');

// Public Customer Order Tracking (Redirects to Home)
Route::get('/track-order', function () {
    return redirect()->route('home');
})->name('orders.track');

// Coupon Code Validation
Route::post('/api/coupon/validate', [\App\Http\Controllers\OrderController::class, 'validateCoupon'])->name('coupon.validate');

// Customer Reviews Submission
Route::post('/reviews/submit', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.submit');

// About Us Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Page & Client Form Submission
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Impersonation Routes
|--------------------------------------------------------------------------
*/
Route::post('/impersonate/leave', [\App\Http\Controllers\ImpersonationController::class, 'leave'])->name('impersonate.leave');

/*
|--------------------------------------------------------------------------
| Admin Portal Routes (Restricted to Admin Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/employees', [\App\Http\Controllers\AdminDashboardController::class, 'employees'])->name('employees');
    Route::post('/employees', [\App\Http\Controllers\AdminDashboardController::class, 'storeEmployee'])->name('employees.store');
    Route::post('/employees/{id}/kick', [\App\Http\Controllers\AdminDashboardController::class, 'kickEmployee'])->name('employees.kick');
    Route::delete('/employees/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'deleteEmployee'])->name('employees.delete');
    
    // Impersonate / Shadow view into employee dashboard
    Route::post('/impersonate/{id}', [\App\Http\Controllers\ImpersonationController::class, 'enter'])->name('impersonate.enter');
    
    Route::get('/orders', [\App\Http\Controllers\AdminDashboardController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/update', [\App\Http\Controllers\AdminDashboardController::class, 'updateOrderStatus'])->name('orders.update');
    // Products Management
    Route::get('/inventory', [\App\Http\Controllers\AdminDashboardController::class, 'inventory'])->name('inventory');
    Route::get('/products', [\App\Http\Controllers\AdminDashboardController::class, 'inventory'])->name('products');
    Route::post('/products', [\App\Http\Controllers\AdminDashboardController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'updateProduct'])->name('products.update');
    Route::post('/products/{id}/toggle-status', [\App\Http\Controllers\AdminDashboardController::class, 'toggleProductStatus'])->name('products.toggle-status');
    Route::post('/products/{id}/toggle-discount', [\App\Http\Controllers\AdminDashboardController::class, 'toggleDiscount'])->name('products.toggle-discount');
    Route::delete('/products/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'deleteProduct'])->name('products.delete');

    // Discount Management
    Route::get('/discounts', [\App\Http\Controllers\AdminDashboardController::class, 'discounts'])->name('discounts');
    Route::post('/discounts/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'updateProductDiscount'])->name('discounts.update');
    Route::post('/coupons', [\App\Http\Controllers\AdminDashboardController::class, 'storeCoupon'])->name('coupons.store');
    Route::delete('/coupons/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'deleteCoupon'])->name('coupons.delete');

    // Customers Directory
    Route::get('/customers', [\App\Http\Controllers\AdminDashboardController::class, 'customers'])->name('customers');
    
    // Customer Reviews Moderation
    Route::get('/reviews', [\App\Http\Controllers\AdminDashboardController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/{id}/status', [\App\Http\Controllers\AdminDashboardController::class, 'updateReviewStatus'])->name('reviews.update');
    Route::delete('/reviews/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'deleteReview'])->name('reviews.delete');

    // Customer Inquiries & Support Tickets
    Route::get('/tickets', [\App\Http\Controllers\AdminDashboardController::class, 'tickets'])->name('tickets');
    Route::post('/tickets/{id}/update', [\App\Http\Controllers\AdminDashboardController::class, 'updateTicket'])->name('tickets.update');
    Route::delete('/tickets/{id}', [\App\Http\Controllers\AdminDashboardController::class, 'deleteTicket'])->name('tickets.delete');

    // WhatsApp Settings
    Route::get('/settings/whatsapp', [\App\Http\Controllers\AdminDashboardController::class, 'whatsappSettings'])->name('settings.whatsapp');
    Route::post('/settings/whatsapp', [\App\Http\Controllers\AdminDashboardController::class, 'updateWhatsappSettings'])->name('settings.whatsapp.update');

    // Website General Settings
    Route::get('/settings/website', [\App\Http\Controllers\AdminDashboardController::class, 'websiteSettings'])->name('settings.website');
    Route::post('/settings/website', [\App\Http\Controllers\AdminDashboardController::class, 'updateWebsiteSettings'])->name('settings.website.update');

    Route::get('/logs', [\App\Http\Controllers\AdminDashboardController::class, 'activityLogs'])->name('logs');
});

/*
|--------------------------------------------------------------------------
| Employee Portal Routes (Restricted to Employee Role or Admin Impersonator)
|--------------------------------------------------------------------------
*/
Route::middleware(['employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [\App\Http\Controllers\EmployeeDashboardController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/update', [\App\Http\Controllers\EmployeeDashboardController::class, 'updateOrderStatus'])->name('orders.update');
    Route::get('/tickets', [\App\Http\Controllers\EmployeeDashboardController::class, 'tickets'])->name('tickets');
    Route::post('/tickets/{id}/update', [\App\Http\Controllers\EmployeeDashboardController::class, 'updateTicket'])->name('tickets.update');
    Route::get('/inventory', [\App\Http\Controllers\EmployeeDashboardController::class, 'inventory'])->name('inventory');
    Route::post('/products', [\App\Http\Controllers\EmployeeDashboardController::class, 'storeProduct'])->name('products.store');
});


