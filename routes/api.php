<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    CategoryController,
    ProductController,
    CartController,
    OrderController,
    PaymentController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group.
|
*/

// ----------------- USER AUTH APIs -----------------
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes requiring Sanctum authentication
Route::middleware('auth:sanctum')->group(function () {

    // User info & logout
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // ----------------- CATEGORY APIs -----------------
    Route::get('categories', [CategoryController::class, 'index']); // public for authenticated users

    // Admin-only category routes
    Route::middleware('role:admin')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{id}', [CategoryController::class, 'update']);
        Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
    });

    // ----------------- PRODUCT APIs -----------------
    Route::get('products', [ProductController::class, 'index']); // supports filters: category, price, search
    Route::get('products/{id}', [ProductController::class, 'show']);

    // Admin-only product routes
    Route::middleware('role:admin')->group(function () {
        Route::post('products', [ProductController::class, 'store']);
        Route::put('products/{id}', [ProductController::class, 'update']);
        Route::delete('products/{id}', [ProductController::class, 'destroy']);
    });

    // ----------------- CART APIs -----------------
    Route::middleware('role:customer')->group(function () {
        Route::get('cart', [CartController::class, 'index']);
        Route::post('cart', [CartController::class, 'store']);
        Route::put('cart/{id}', [CartController::class, 'update']);
        Route::delete('cart/{id}', [CartController::class, 'destroy']);

        // ----------------- ORDER APIs -----------------
        Route::post('orders', [OrderController::class, 'store'])
            ->middleware('check.stock'); // Prevent checkout if stock insufficient
        Route::get('orders', [OrderController::class, 'index']);

        // Admin-only order status update
        Route::put('orders/{id}/status', [OrderController::class, 'updateStatus'])
            ->middleware('role:admin');

        // ----------------- PAYMENT APIs -----------------
        Route::post('orders/{id}/payment', [PaymentController::class, 'store']);
        Route::get('payments/{id}', [PaymentController::class, 'show']);
    });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
