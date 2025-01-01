<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
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

Route::post('/changeRole/{id}', [UserController::class, 'changeRole']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function(){

    //routes for every role:

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [UserController::class, 'updateProfile']);
    Route::post('/language',[UserController::class,'changeLocale']);
    //store:
    Route::get('/stores', [StoreController::class, 'index']);
    Route::get('/stores/{store}', [StoreController::class, 'show']);
    //product:
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('products/latest', [ProductController::class, 'getLatestProducts']);
    Route::get('products/most-ordered', [ProductController::class, 'getMostOrderedProducts']);
    //favorite:
    Route::get('/favorite', [FavoriteController::class, 'index']);
    Route::get('/favorite/{id}', [FavoriteController::class, 'show']);
    Route::post('/favorite', [FavoriteController::class, 'store']);
    Route::put('/favorite/{id}', [FavoriteController::class, 'update']);
    Route::delete('/favorite/{id}', [FavoriteController::class, 'destroy']);
    //cart:
    Route::get('/cart', [CartController::class, 'index']);
    Route::get('/cart/{id}', [CartController::class, 'show']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
    Route::get('/add-to-order',[CartController::class,'add_cart_To_order']);
    //order:
    Route::get('/order', [OrderController::class, 'index']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::put('/order/{id}', [OrderController::class, 'update']);
    Route::get('/cancel-order/{id}', [OrderController::class,'cancelOrder']);


    //routes for the admin:
    Route::middleware(['role:admin'])->group(function(){
        //user:
        Route::get('/users',[UserController::class,'index']);
        //store:
        Route::post('/stores', [StoreController::class, 'store']);
        Route::put('/stores/{store}', [StoreController::class, 'update']);
        Route::delete('/stores/{store}', [StoreController::class, 'destroy']);
        //product:
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        //images for products:
        Route::prefix('products/{productId}/images')->group(function () {
            Route::post('/', [ImageController::class, 'store']);
            Route::get('/', [ImageController::class, 'index']);
            Route::delete('/{imageId}',[ImageController::class,'delete']);
            Route::get('/{imageId}',[ImageController::class,'show']);
        });
        //order:
        Route::delete('/order/{id}', [OrderController::class, 'destroy']);





    });

    //routes for the driver:
    Route::middleware(['role:driver'])->group(function(){

    });



});



