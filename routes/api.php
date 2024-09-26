<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', action: [AuthController::class, 'login']);
    Route::get('/me', action: [AuthController::class, 'me']);
    Route::post('/logout', action: [AuthController::class, 'logout']);
    Route::post('/refresh', action: [AuthController::class, 'refresh']);
    Route::post('/register', action: [AuthController::class, 'register']);
});

Route::get('products', [ApiController::class, 'productIndex']);
Route::group(['middleware' => 'auth:api'], function () {

    Route::post('product', action: [ApiController::class, 'productStore']);

    Route::get('/carts', [ApiController::class, 'cartIndex']);
    Route::post('/cart', [ApiController::class, 'cartStore']);
    Route::get('order', action: [ApiController::class, 'orderIndex']);

    Route::post('/cartChoose', [ApiController::class, 'cartChoose']);

});

Route::post('order', action: [ApiController::class, 'orderStore']);
