<?php

use App\Http\Controllers\CnController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KasbonController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\PenjualanMasterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifController;
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

Route::get('/', fn () => redirect()->route('login'));

Route::get('/dashboard', fn () => view('dashboard'));


// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['middleware'=>'auth'],function(){
    Route::resource('dashboard', HomeController::class);

    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('user', UserController::class);

    Route::get('/karyawan/data', [KaryawanController::class, 'data'])->name('karyawan.data');
    Route::get('/karyawan/group', [KaryawanController::class, 'group'])->name('karyawan.group');
    Route::resource('karyawan', KaryawanController::class);

    Route::get('/getkota', [PenjualanController::class, 'getkota'])->name('marketing.getkota');
    Route::get('/getkecamatan', [PenjualanController::class, 'getkecamatan'])->name('marketing.getkecamatan');
    Route::get('/getkelurahan', [PenjualanController::class, 'getkelurahan'])->name('marketing.getkelurahan');
    
    Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
    Route::get('/penjualan/detail/{id}', [PenjualanController::class, 'detail'])->name('penjualan.detail');
    Route::post('/penjualan/detail/hapus/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.hapus');
    Route::resource('penjualan', PenjualanController::class);

    Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
    Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
    Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
    Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
    Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

    Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
    Route::get('/transaksi/loadform/{total}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
    Route::resource('/transaksi', PenjualanDetailController::class)->except('create', 'show', 'edit');

    Route::get('/verif/data', [VerifController::class, 'data'])->name('verif.data');
    Route::get('/verif/detail/{id}', [VerifController::class, 'detail'])->name('verif.detail');
    Route::put('/verif/delivery', [VerifController::class, 'delivery'])->name('verif.delivery');
    Route::resource('verif', VerifController::class);

    Route::get('/delivery/data', [DeliveryController::class, 'data'])->name('delivery.data');
    Route::get('/delivery/detail/{id}', [DeliveryController::class, 'detail'])->name('delivery.detail');
    Route::resource('delivery', DeliveryController::class);

    Route::get('/kasbon/data', [KasbonController::class, 'data'])->name('kasbon.data');
    Route::resource('kasbon', KasbonController::class);

    Route::get('/penjualan_master/data', [PenjualanMasterController::class, 'data'])->name('penjualan_master.data');
    Route::get('/penjualan_master/{id}', [PenjualanMasterController::class, 'detail'])->name('penjualan_master.detail');
    Route::resource('penjualan_master', PenjualanMasterController::class);

    Route::post('/setting/{id}', [SettingController::class, 'update'])->name('setting.update');
    Route::resource('setting', SettingController::class)->except('update');

    Route::get('/gaji/data', [GajiController::class, 'data'])->name('gaji.data');
    Route::get('/gaji/detail/{id}', [GajiController::class, 'detail'])->name('gaji.detail');
    Route::get('/gaji/prosess', [GajiController::class, 'prosess'])->name('gaji.prosess');
    Route::resource('gaji', GajiController::class);

    Route::get('importExportView', [CnController::class, 'importExportView']);
    Route::get('export', [CnController::class, 'export'])->name('cnexport');
    Route::post('import', [CnController::class, 'import'])->name('cnimport');

});