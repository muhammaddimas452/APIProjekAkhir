<?php
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    JumlahPendudukController,
    kegiatanController,
    artikelController,
    ArtikelInformasiController,
    ArtikelPotensiSDAController,
    UmkmController,
    LayananMasyarakatController,
    BeritaController,
    PemerintahDesaController,
    UserController,
    JabatanController,
    InfoWilayahController,
    KegiatanRutinController,
    SettingInfoController,
    FotoberandaController,
    TextberandaController
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

Route::get('/user', [UserController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::put('/password/forgot-password', [ForgotPasswordController::class, 'sendResetLinkResponse'])->name('passwords.sent');
Route::put('/password/reset', [ResetPasswordController::class, 'sendResetResponse'])->name('passwords.reset');

Route::get('/jumlah-penduduk', [JumlahPendudukController::class, 'index']);
Route::get('/jumlah-penduduk/{id}', [JumlahPendudukController::class, 'show']);
Route::get('/jumlah-penduduk/edit/{id}', [JumlahPendudukController::class, 'edit']);
Route::put('/jumlah-penduduk/update/{id}', [JumlahPendudukController::class, 'update']);
Route::delete('/jumlah-penduduk/delete/{id}', [JumlahPendudukController::class, 'destroy']);

Route::get('/kegiatan', [kegiatanController::class, 'index']);
Route::get('/kegiatan-done/paginate', [kegiatanController::class, 'kegiatanDone']);
Route::get('/kegiatan-not/paginate', [kegiatanController::class, 'kegiatanNot']);
Route::get('/totalKegiatanDone', [kegiatanController::class, 'totalDataDone']);
Route::get('/totalKegiatanNot', [kegiatanController::class, 'totalDataNot']);
Route::get('/kegiatan/paginate', [kegiatanController::class, 'paginate']);
Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);
Route::post('/kegiatan/add', [kegiatanController::class, 'store']);
Route::get('/kegiatan/edit/{id}', [kegiatanController::class, 'edit']);
Route::put('/kegiatan/update/{id}', [kegiatanController::class, 'update']);
Route::delete('/kegiatan/delete/{id}', [kegiatanController::class, 'destroy']);

Route::get('/artikel', [artikelController::class, 'index']);
Route::get('/search/{key}', [artikelController::class, 'search']);
Route::get('/artikel/mostview', [artikelController::class, 'mostView']);
Route::get('/artikel/acak', [artikelController::class, 'acak']);
Route::get('/artikel/paginate/{perpage}', [artikelController::class, 'paginate']);
Route::get('/artikel/newest', [artikelController::class, 'newest']);
Route::get('/totalArtikel', [artikelController::class, 'totalData']);
Route::get('/artikel/{id}', [artikelController::class, 'show']);
Route::post('/artikel/add', [artikelController::class, 'store']);
Route::get('/artikel/edit/{id}', [artikelController::class, 'edit']);
Route::put('/artikel/update/{id}', [artikelController::class, 'update']);
Route::delete('/artikel/delete/{id}', [artikelController::class, 'destroy']);

Route::get('/artikel-potensi', [ArtikelPotensiSDAController::class, 'index']);
Route::get('/artikel-potensi/{id}', [ArtikelPotensiSDAController::class, 'show']);
Route::post('/artikel-potensi/add', [ArtikelPotensiSDAController::class, 'store']);
Route::get('/artikel-potensi/edit/{id}', [ArtikelPotensiSDAController::class, 'edit']);
Route::put('/artikel-potensi/update/{id}', [ArtikelPotensiSDAController::class, 'update']);
Route::delete('/artikel-potensi/delete/{id}', [ArtikelPotensiSDAController::class, 'destroy']);

Route::get('/data-umkm', [UmkmController::class, 'index']);
Route::get('/data-umkm/{id}', [UmkmController::class, 'show']);
Route::post('/data-umkm/add', [UmkmController::class, 'store']);
Route::get('/data-umkm/edit/{id}', [UmkmController::class, 'edit']);
Route::put('/data-umkm/update/{id}', [UmkmController::class, 'update']);
Route::delete('/data-umkm/delete/{id}', [UmkmController::class, 'destroy']);

Route::get('/layanan', [LayananMasyarakatController::class, 'index']);
Route::get('/layanan/{id}', [LayananMasyarakatController::class, 'show']);
Route::post('/layanan/add', [LayananMasyarakatController::class, 'store']);
Route::get('/layanan/edit/{id}', [LayananMasyarakatController::class, 'edit']);
Route::put('/layanan/update/{id}', [LayananMasyarakatController::class, 'update']);
Route::delete('/layanan/delete/{id}', [LayananMasyarakatController::class, 'destroy']);

Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/mostview', [BeritaController::class, 'mostView']);
Route::get('/berita/{id}', [BeritaController::class, 'show']);
Route::post('/berita/add', [BeritaController::class, 'store']);
Route::get('/berita/edit/{id}', [BeritaController::class, 'edit']);
Route::put('/berita/update/{id}', [BeritaController::class, 'update']);
Route::delete('/berita/delete/{id}', [BeritaController::class, 'destroy']);

Route::get('/pemerintahdesa', [PemerintahDesaController::class, 'index']);
Route::get('/pemerintahdesa/{id}', [PemerintahDesaController::class, 'show']);
Route::post('/pemerintahdesa/add', [PemerintahDesaController::class, 'store']);
Route::get('/pemerintahdesa/edit/{id}', [PemerintahDesaController::class, 'edit']);
Route::put('/pemerintahdesa/update/{id}', [PemerintahDesaController::class, 'update']);
Route::delete('/pemerintahdesa/delete/{id}', [PemerintahDesaController::class, 'destroy']);

Route::get('/jabatan', [JabatanController::class, 'index']);
Route::get('/jabatan/{id}', [JabatanController::class, 'show']);
Route::post('/jabatan/add', [JabatanController::class, 'store']);
Route::get('/jabatan/edit/{id}', [JabatanController::class, 'edit']);
Route::put('/jabatan/update/{id}', [JabatanController::class, 'update']);
Route::delete('/jabatan/delete/{id}', [JabatanController::class, 'destroy']);

Route::get('/infowilayah', [InfoWilayahController::class, 'index']);
Route::get('/infowilayah/{id}', [InfoWilayahController::class, 'show']);
Route::post('/infowilayah/add', [InfoWilayahController::class, 'store']);
Route::get('/infowilayah/edit/{id}', [InfoWilayahController::class, 'edit']);
Route::put('/infowilayah/update/{id}', [InfoWilayahController::class, 'update']);
Route::delete('/infowilayah/delete/{id}', [InfoWilayahController::class, 'destroy']);

Route::get('/kegiatan-rutin', [KegiatanRutinController::class, 'index']);
Route::get('/kegiatan-rutin/{id}', [KegiatanRutinController::class, 'show']);
Route::post('/kegiatan-rutin/add', [KegiatanRutinController::class, 'store']);
Route::get('/kegiatan-rutin/edit/{id}', [KegiatanRutinController::class, 'edit']);
Route::put('/kegiatan-rutin/update/{id}', [KegiatanRutinController::class, 'update']);
Route::delete('/kegiatan-rutin/delete/{id}', [KegiatanRutinController::class, 'destroy']);

Route::get('/info', [SettingInfoController::class, 'index']);
Route::get('/info/edit/{id}', [SettingInfoController::class, 'edit']);
Route::put('/info/update/{id}', [SettingInfoController::class, 'update']);

Route::get('/foto-beranda', [FotoberandaController::class, 'index']);
Route::post('/foto-beranda/add', [FotoberandaController::class, 'store']);
Route::get('/foto-beranda/{id}', [FotoberandaController::class, 'show']);
Route::put('/foto-beranda/delete/{id}', [FotoberandaController::class, 'destroy']);

Route::get('/text-beranda', [TextberandaController::class, 'index']);
Route::get('/text-beranda/edit/{id}', [TextberandaController::class, 'edit']);
Route::put('/text-beranda/update/{id}', [TextberandaController::class, 'update']);
