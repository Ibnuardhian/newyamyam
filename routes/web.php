<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\auth\RegisterController as AuthRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\SuccessController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductUserController;
use App\Http\Controllers\ShippingController; // Add this line

// ...existing code...

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories');
Route::get('/categories/{id}', [CategoryController::class, 'detail'])
    ->name('categories-detail');

Route::get('/details/{id}', [DetailController::class, 'index'])
    ->name('detail');
Route::post('/details/{id}', [DetailController::class, 'add'])
    ->name('detail-add');

Route::get('/success', [CartController::class, 'success'])
    ->name('success');
Route::post('/checkout/callback', [CheckoutController::class, 'callback'])
    ->name('midtrans-callback');
Route::get('/register/success', [AuthRegisterController::class, 'success'])
    ->name('register-success');
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/products/search', [ProductUserController::class, 'search'])->name('products.search');

Route::post('/calculate-shipping', [ShippingController::class, 'calculate'])->name('calculate-shipping');

Route::post('/cart/apply-discount', [App\Http\Controllers\CartController::class, 'applyDiscount'])->name('cart.applyDiscount');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart-add');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart-update');

    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])
        ->name('dashboard-transaction');
    Route::get('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])
        ->name('dashboard-transaction-details');
    Route::get('/dashboard/transactions/?keyword={code}', [DashboardTransactionController::class, 'details'])
        ->name('dashboard-transaction-search');
    Route::post('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'update'])
        ->name('dashboard-transaction-update');
    Route::get('/dashboard/account', [DashboardSettingController::class, 'account'])
        ->name('dashboard-settings-account');
    Route::post('/dashboard/update/{redirect}', [DashboardSettingController::class, 'update'])
        ->name('dashboard-settings-redirect');
});

Route::prefix('admin')
    // ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
        Route::resource('category', AdminCategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::resource('product-gallery', ProductGalleryController::class);
        Route::resource('transaction', TransactionController::class);
        Route::resource('discount', DiscountController::class);
    });

Auth::routes();
