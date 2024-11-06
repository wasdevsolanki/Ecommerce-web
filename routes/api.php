<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\APIController;

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

Route::group(['middleware' => 'api'], function () {

    Route::group(['prefix' => 'update'],function (){
        Route::put('stock', [APIController::class, 'UpdateStock']);
        Route::put('order', [APIController::class, 'UpdateOrder']);
    });

        Route::put('/orderstatus-change', [OrderController::class, 'orderStatusChangeApi']);



    Route::get('product', [APIController::class, 'getProductList']);
    Route::get('stock', [APIController::class, 'getStock']);
    Route::get('order', [APIController::class, 'getOrder']);
    Route::get('stock-api', [APIController::class, 'EditStockAPI']);
});
