<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PesertaController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\BookController;
// use App\Http\Controllers\PostController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
// use App\Http\Controllers\UserController;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('book', [BookController::class, 'book']);

Route::get('bookall', [BookController::class, 'bookAuth'])->middleware('jwt.verify');
Route::get('user', [UserController::class, 'getAuthenticatedUser'])->middleware('jwt.verify');

Route::middleware('jwt.verify')->group(function () {
    Route::get('tag', [TagController::class, 'index']);
    Route::get('posts/{category}', [PostController::class, 'index']);
    Route::get('get-pelatihan', [PesertaController::class, 'getAll']);
    Route::get('product', [ProductController::class, 'index']);
    Route::get('posts/{category}/{id}', [PostController::class, 'show']);
    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::get('product-category', [ProductCategoryController::class, 'index']);

    Route::get('tag', [TagController::class, 'index']);
    Route::get('tag/{id}', [TagController::class, 'show']);
    Route::post('tag', [TagController::class, 'store']);
    Route::put('tag/{id}', [TagController::class, 'update']);
    Route::delete('tag/{id}', [TagController::class, 'destroy']);

    Route::post('logout', [UserController::class, 'logout']);



    Route::get('profile', [UserController::class, 'getAuthenticatedUser']);
    Route::put('profile', [UserController::class, 'updateProfile']);
});

Route::middleware(['auth.jwt:user'])->group(function () {

    Route::get('myorder', [OrderController::class, 'getOrderByUserId']);
    Route::post('myorder', [OrderController::class, 'createOrder']);
    Route::post('myorder/{id}', [OrderController::class, 'updateOrder']);
    Route::delete('myorder/{id}', [OrderController::class, 'deleteOrder']);
    Route::post('myorder/{id}/upload-bukti', [OrderController::class, 'uploadBukti']);
    Route::get('cart', [OrderController::class, 'getCart']);
    Route::post('cart', [OrderController::class, 'addToCart']);

    // PESERTA
    Route::get('pelatihan', [PesertaController::class, 'getPelatihan']);
    Route::post('peserta/{id}', [PesertaController::class, 'store']);
    Route::get('get-pelatihan-login', [PesertaController::class, 'getPelatihanByLogin']);
    Route::get('get-detail-pelatihan/{id}', [PesertaController::class, 'getDetailPelatihanByLogin']);
    Route::post('update-pelatihan/{id}', [PesertaController::class, 'updatePelatihanByLogin']);
    Route::delete('delete-pelatihan/{id}', [PesertaController::class, 'deletePelatihanByLogin']);

    // Umkm
    Route::get('umkm', [UserController::class, 'getUmkm']);
    Route::get('umkm/{id}', [UserController::class, 'getUmkmById']);

    // Category
    Route::get('product-category', [ProductCategoryController::class, 'index']);

    // product
    // Route::get('product', [ProductController::class, 'index']);
    Route::get('product/{id}', [ProductController::class, 'show']);
    Route::get('product/category/{id}', [ProductController::class, 'showByCategory']);
    Route::get('product-popular', [ProductController::class, 'getProductPopuler']);
});

Route::middleware(['auth.jwt:admin'])->group(function () {
    Route::get('db-user', [UserController::class, 'dbUser']);
    Route::get('users', [UserController::class, 'getAllUser']);
    Route::get('users/{id}', [UserController::class, 'getUserById']);
    Route::post('verif-user', [UserController::class, 'changeVerif']);

    Route::get('get-pelatihan', [PesertaController::class, 'getAll']);
    Route::get('db-posts', [PostController::class, 'dbPost']);
    Route::post('posts/{category}', [PostController::class, 'store']);
    Route::post('posts/{category}/{id}', [PostController::class, 'update']);
    Route::delete('posts/{category}/{id}', [PostController::class, 'destroy']);


    Route::get('dbproduct', [ProductController::class, 'dbProduct']);
    Route::post('product', [ProductController::class, 'store']);
    Route::put('product/{id}', [ProductController::class, 'update']);
    Route::delete('product/{id}', [ProductController::class, 'destroy']);

    Route::get('product-category/{id}', [ProductCategoryController::class, 'show']);
    Route::post('product-category', [ProductCategoryController::class, 'store']);
    Route::put('product-category/{id}', [ProductCategoryController::class, 'update']);
    Route::delete('product-category/{id}', [ProductCategoryController::class, 'destroy']);

    Route::get('order', [OrderController::class, 'getAllOrder']);
    Route::post('order/{id}', [OrderController::class, 'verifyOrder']);


    Route::get('peserta', [PesertaController::class, 'getAll']);
    Route::get('peserta/{id}', [PesertaController::class, 'getById']);
    Route::delete('peserta/{id}', [PesertaController::class, 'delete']);
    Route::put('peserta/{id}', [PesertaController::class, 'update']);
});

Route::middleware(['jwt.verify'])->group(function () {

    Route::post('verif-kyc', [UserController::class, 'verifKYC']);
});

Route::middleware(['auth.jwt:umkm'])->group(function () {


    Route::prefix('umkm')->group(function () {
        # code...
        Route::get('product', [ProductController::class, 'getByUser']);
        Route::get('product/{id}', [ProductController::class, 'showByUser']);
        Route::post('product', [ProductController::class, 'store']);
        Route::put('product/{id}', [ProductController::class, 'updateByUser']);
        Route::delete('product/{id}', [ProductController::class, 'destroyByUser']);
    });
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
