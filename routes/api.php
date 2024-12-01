<?php

use App\Http\Controllers\Api\ProductBranchController;
use App\Models\ProductBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// post login
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('login-kasir', [\App\Http\Controllers\Api\AuthController::class, 'loginKasir']);

// post logout
Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('logout-kasir', [\App\Http\Controllers\Api\AuthController::class, 'logoutKasir'])->middleware('auth:sanctum');

// api resource product
Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');

//api product branch
Route::get('product-branch/{id}', [ProductBranchController::class, 'index'])->middleware('auth:sanctum');

// api resource order
Route::apiResource('orders', \App\Http\Controllers\Api\OrderController::class)->middleware('auth:sanctum');

Route::apiResource('members', \App\Http\Controllers\Api\MemberController::class)->middleware('auth:sanctum');

// get categories
Route::get('list-categories', [\App\Http\Controllers\Api\CategoryController::class, 'index'])->middleware('auth:sanctum');

// get campaigns
Route::get('campaign', [\App\Http\Controllers\Api\CampaignController::class, 'index'])->middleware('auth:sanctum');

//get discount
Route::get('discount/transaction', [\App\Http\Controllers\Api\DiscountController::class, 'getDiscountTransaction'])->middleware('auth:sanctum');
Route::get('discount/voucher', [\App\Http\Controllers\Api\DiscountController::class, 'getDiscountVoucher'])->middleware('auth:sanctum');

//get tax
Route::get('tax', [\App\Http\Controllers\API\TaxController::class, 'index'])->middleware('auth:sanctum');

// get service charge
Route::get('service-charge', [\App\Http\Controllers\API\ServiceChargeController::class, 'index'])->middleware('auth:sanctum');

//get profile
Route::get('profile', [\App\Http\Controllers\API\ProfileController::class, 'index'])->middleware('auth:sanctum');

// api resource report
Route::get('/reports/summary', [App\Http\Controllers\Api\ReportController::class, 'summary'])->middleware('auth:sanctum');
Route::get('/reports/product-sales', [App\Http\Controllers\Api\ReportController::class, 'productSales'])->middleware('auth:sanctum');
Route::get('/reports/close-cashier', [App\Http\Controllers\Api\ReportController::class, 'closeCashier'])->middleware('auth:sanctum');
