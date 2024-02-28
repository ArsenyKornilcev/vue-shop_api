<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/auth', [UserController::class, 'authenticate']);

Route::post('/reg', [UserController::class, 'register']);

Route::get('/products', [ProductController::class, 'all']);

Route::group(['middleware' => 'admin'], function() {
    // routes that should be accessible only by admins
    Route::delete('/product-delete', [ProductController::class, 'delete']);
    Route::post('/product-create', [ProductController::class, 'create']);
    Route::post('/product-update', [ProductController::class, 'update']);
});