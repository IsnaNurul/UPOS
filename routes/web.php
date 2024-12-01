<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ManageProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDiscountController;
use App\Http\Controllers\PaymentGateawayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDiscountController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\ServiceChargeController;;

use App\Http\Controllers\TaxController;
use App\Http\Controllers\TransactionDiscountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherDiscountController;
use App\Models\Restock;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::get('/auth-register', function () {
    return view('pages.auth.register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', [DashboardController::class, 'index'])->name('home');
    Route::post('/dashboard/store/profile', [DashboardController::class, 'storeProfile'])->name('dashboard.store.profile');
    Route::post('/dashboard/store/tax', [DashboardController::class, 'storeTax'])->name('dashboard.store.tax');
    Route::post('/dashboard/store/payment', [DashboardController::class, 'storePayment'])->name('dashboard.store.payment');
    Route::post('/dashboard/store/service-fee', [DashboardController::class, 'storeServiceFee'])->name('dashboard.store.service-fee');
    Route::get('/dashboard/daily-sales', [DashboardController::class, 'index']);

    Route::resource('user', UserController::class);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::post('products/updateStock', [ProductController::class, 'updateStock'])->name('products.updateStock');
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);

    Route::get('/campaign/toggle-status/{id}', [\App\Http\Controllers\CampaignController::class, 'toggleStatus'])->name('campaign.toggleStatus');
    Route::resource('campaign', \App\Http\Controllers\CampaignController::class);

    Route::resource('manage-product', \App\Http\Controllers\ManageProductController::class);
    Route::get('manage-product/request/{id}', [ManageProductController::class, 'requestStock'])->name('manage-product.request');
    Route::resource('restock', RestockController::class);
    Route::post('restock/request/{id}', [RestockController::class, 'restock'])->name('restock.request');
    Route::get('restock/complete/{restockId}', [RestockController::class, 'complete'])->name('restock.complete');
    //Kasir
    Route::resource('kasir', KasirController::class);

    //Member
    Route::resource('member', MemberController::class);

    // Discounts
    Route::resource('discount-member', MemberDiscountController::class);
    Route::get('/discount-member/{id}/set-default', [MemberDiscountController::class, 'setDefault'])->name('discount-member.setDefault');

    Route::resource('transaction-discount', TransactionDiscountController::class);
    Route::get('/transaction-discount/toggle-status/{id}', [TransactionDiscountController::class, 'toggleStatus'])->name('transaction-discount.toggleStatus');
    Route::resource('voucher-discount', VoucherDiscountController::class);
    Route::get('/voucher-discount/toggle-status/{id}', [VoucherDiscountController::class, 'toggleStatus'])->name('voucher-discount.toggleStatus');

    //Payment Gateaway
    Route::resource('payment-gateaway', PaymentGateawayController::class);
    Route::get('/payment-gateaway/toggle-status/{id}', [PaymentGateawayController::class, 'toggleStatus'])->name('payment-gateaway.toggleStatus');

    //Discount Product
    Route::resource('discount-product', ProductDiscountController::class);

    //Settings
    Route::resource('setting-tax', TaxController::class);
    Route::resource('setting-receipt', ReceiptController::class);
    Route::resource('service-charge', ServiceChargeController::class);
    Route::resource('setting-user-management', AccountController::class);

    // Integrations
    Route::resource('integration-api', TaxController::class);
    Route::resource('server-key', TaxController::class);

    //account
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::put('/account/{user}', [AccountController::class, 'update'])->name('account.update');

    //branch
    Route::resource('branch', BranchController::class);
});
