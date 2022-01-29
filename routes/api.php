<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    NewPasswordController,
    JumlahPendudukController
};
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

Route::post('/login', [AuthController::class,'login']);   
Route::post('/forgot-password', [NewPasswordController::class,'forgotpassword']);

Route::get('/jumlah-penduduk', [JumlahPendudukController::class,'index']);
Route::get('/jumlah-penduduk/{id}', [JumlahPendudukController::class,'show']);
Route::post('/jumlah-penduduk/add', [JumlahPendudukController::class,'store']);
Route::post('/jumlah-penduduk/edit/{id}', [JumlahPendudukController::class,'update']);
Route::get('/jumlah-penduduk/delete/{id}', [JumlahPendudukController::class,'destroy']);