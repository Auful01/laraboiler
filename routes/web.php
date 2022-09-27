<?php

// use App\Http\Controllers\UserController;

use App\Http\Controllers\Master\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::post('/lagi', [UserController::class, 'login']);

Route::get('authenticate', function () {
    return view('auth.login');
});



Route::post('/auth', [UserController::class, 'login']);
Route::post('/signout', [UserController::class, 'logout']);

Route::group(['middleware' => ['web']], function () {
    // your routes
    Route::get('/', function () {
        return view('layout.app')->render();
    })->middleware('auth.web:admin');

    Route::get('/dashboard', function () {
        $data =  view('pages.dashboard')->render();
        return response()->json($data, 200);
    })->middleware('auth.web:admin');

    Route::get('/post/1', function () {
        $data = view('pages.posts.posts')->render();
        return response()->json($data, 200);
    })->middleware('auth.web:admin');

    Route::get('/post/2', function () {
        $data = view('pages.posts.pelatihan')->render();
        return response()->json($data, 200);
    })->middleware('auth.web:admin');

    Route::get('/product', function () {
        $data = view('pages.product.product')->render();
        return response()->json($data, 200);
    })->middleware('auth.web:admin');

    Route::get('/user', function () {
        $data = view('pages.user.user')->render();
        return response()->json($data, 200);
    })->middleware('auth.web:admin');

    Route::get('/order', function () {
        $data = view('pages.order.order')->render();
        return response()->json($data, 200);
    })->middleware('auth.web:admin');
});
