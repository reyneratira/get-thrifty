<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;

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

//authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//public
Route::get('/barangs', [BarangController::class, 'index']);
Route::get('/barangs/{id}', [BarangController::class, 'show']);
Route::get('/order', [OrderController::class, 'index']);
Route::get('/order/{id}', [OrderController::class, 'show']);

//protected
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/tambah-order', [OrderController::class, 'store']);
    Route::middleware('handle')->group(function(){
        Route::post('/tambah-barang', [BarangController::class, 'store']);
        Route::put('/update-barang/{id}', [BarangController::class, 'update']);
        Route::put('/update-order/{id}', [OrderController::class, 'update']);
        Route::put('/update-transaksi/{id}', [TransactionController::class, 'update']);
        Route::delete('/hapus-order/{id}', [OrderController::class, 'destroy']);
        Route::delete('/hapus-barang/{id}', [BarangController::class, 'destroy']);
    });
});