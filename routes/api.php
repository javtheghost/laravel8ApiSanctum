<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProviderController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::resource('products', ProductController::class);
    Route::resource('providers', ProviderController::class);
    Route::resource('categories', CategoryController::class);

    Route::get('productsbycategoryandprovider', [ProductController::class, 'ProductByCategory']);
    Route::get('productsall', [ProductController::class, 'all']);

    Route::get('auth/logout', [AuthController::class, 'logout']);
});
