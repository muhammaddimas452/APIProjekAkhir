<?php
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    JumlahPendudukController,
    kegiatanController,
    artikelController
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('password/forgot-password', [ForgotPasswordController::class, 'sendResetLinkResponse'])->name('passwords.sent');
Route::post('password/reset', [ResetPasswordController::class, 'sendResetResponse'])->name('passwords.reset');

Route::get('/jumlah-penduduk', [JumlahPendudukController::class, 'index']);
Route::get('/jumlah-penduduk/{id}', [JumlahPendudukController::class, 'show']);
Route::post('/jumlah-penduduk/add', [JumlahPendudukController::class, 'store']);
Route::post('/jumlah-penduduk/edit/{id}', [JumlahPendudukController::class, 'update']);
Route::get('/jumlah-penduduk/delete/{id}', [JumlahPendudukController::class, 'destroy']);

Route::get('/kegiatan', [kegiatanController::class, 'index']);
Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);
Route::post('/kegiatan/add', [kegiatanController::class, 'store']);
Route::post('/kegiatan/edit/{id}', [kegiatanController::class, 'update']);
Route::get('/kegiatan/delete/{id}', [kegiatanController::class, 'destroy']);

Route::get('/artikel', [artikelController::class, 'index']);
Route::get('/artikel/{id}', [artikelController::class, 'show']);
Route::post('/artikel/add', [artikelController::class, 'store']);
Route::post('/artikel/edit/{id}', [artikelController::class, 'update']);
Route::get('/artikel/delete/{id}', [artikelController::class, 'destroy']);
