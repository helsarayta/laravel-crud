<?php

use App\Http\Controllers\api\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products', [ProductController::class,'index']);
Route::post('product/add', [ProductController::class,'addProduct']);
Route::get('product/{id}', [ProductController::class,'findById']);
Route::put('product/edit/{id}', [ProductController::class,'update']);
Route::delete('product/delete/{id}', [ProductController::class,'deleteById']);

Route::post('create', [ProductController::class,'createProduct']);