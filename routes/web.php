<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.landingpage');
});

use App\Http\Controllers\AuthController;
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/ubah-sandi', [AuthController::class, 'changePassword'])->name('ubah.sandi');

use App\Http\Controllers\BerandaController;
Route::get('/beranda', [BerandaController::class, 'index'])
    ->name('beranda')
    ->middleware('auth');

use App\Http\Controllers\KelolaPenggunaController;
Route::middleware(['auth', 'role:p4m'])->group(function () {
    Route::get('/kelola_pengguna', [KelolaPenggunaController::class, 'index'])
        ->name('kelola_pengguna');
    Route::post('/kelola_pengguna/store', [KelolaPenggunaController::class, 'store'])
        ->name('kelola_pengguna.store');
    Route::post('/kelola_pengguna/update/{id}', [KelolaPenggunaController::class, 'update'])
        ->name('kelola_pengguna.update');
    Route::delete('/kelola_pengguna/delete/{id}', [KelolaPenggunaController::class, 'destroy'])
        ->name('kelola_pengguna.destroy');
});

use App\Http\Controllers\KelolaRegisController;
Route::middleware(['role:p4m'])->group(function () {
    Route::get('/kelola_regis', [KelolaRegisController::class, 'index'])->name('kelola_regis');
    Route::post('/kelola_regis/import/unitkerja', [KelolaRegisController::class, 'importUnitKerja'])->name('formregis.import.unitkerja');
    Route::post('/kelola_regis/import/proses', [KelolaRegisController::class, 'importProses'])->name('formregis.import.proses');
    Route::post('/kelola_regis/import/kategori', [KelolaRegisController::class, 'importKategori'])->name('formregis.import.kategori');
    Route::post('/kelola_regis/import/jenis', [KelolaRegisController::class, 'importJenis'])->name('formregis.import.jenis');
    Route::post('/kelola_regis/import/iku', [KelolaRegisController::class, 'importIku'])->name('formregis.import.iku');
});

Route::post('/save-collapse', function (\Illuminate\Http\Request $request) {
    session(['collapse_open' => $request->open]);
    return response()->json(['status' => 'ok']);
});
// CRUD Unit Kerja
Route::post('/unitkerja/store', [KelolaRegisController::class, 'store'])->name('unitkerja.store');
Route::post('/unitkerja/update/{id}', [KelolaRegisController::class, 'update'])->name('unitkerja.update');
Route::delete('/unitkerja/delete/{id}', [KelolaRegisController::class, 'destroy'])->name('unitkerja.destroy');
Route::delete('/unitkerja/delete-selected', [KelolaRegisController::class, 'deleteSelected'])->name('unitkerja.deleteSelected');
Route::delete('/unitkerja/delete-selected', [KelolaRegisController::class, 'deleteSelected'])->name('unitkerja.delete-selected');

// CRUD Proses/Aktivitas
Route::post('/proses/store', [KelolaRegisController::class, 'storeProses'])->name('proses.store');
Route::post('/proses/update/{id}', [KelolaRegisController::class, 'updateProses'])->name('proses.update');
Route::delete('/proses/delete/{id}', [KelolaRegisController::class, 'destroyProses'])->name('proses.destroy');
Route::delete('/proses/delete-selected', [KelolaRegisController::class, 'deleteSelectedProses'])->name('proses.delete-selected');

//EXPORT Proses/Aktivitas
//EXPORT PROSES UNIT KERJA
Route::get('/proses/export', [KelolaRegisController::class, 'exportTemplate'])
    ->name('proses.export');

// CRUD Kategori Risiko
Route::post('/kategori/store', [KelolaRegisController::class, 'storeKategori'])->name('kategori.store');
Route::post('/kategori/update/{id}', [KelolaRegisController::class, 'updateKategori'])->name('kategori.update');
Route::delete('/kategori/delete/{id}', [KelolaRegisController::class, 'destroyKategori'])->name('kategori.destroy');
Route::delete('/kategori/delete-selected', [KelolaRegisController::class, 'deleteSelectedKategori'])->name('kategori.delete-selected');

// CRUD Jenis Risiko
Route::post('/jenis/store', [KelolaRegisController::class, 'storeJenis'])->name('jenis.store');
Route::post('/jenis/update/{id}', [KelolaRegisController::class, 'updateJenis'])->name('jenis.update');
Route::delete('/jenis/delete/{id}', [KelolaRegisController::class, 'destroyJenis'])->name('jenis.destroy');
Route::delete('/jenis/delete-selected', [KelolaRegisController::class, 'deleteSelectedJenis'])->name('jenis.delete-selected');

// CRUD IKU Terkait
Route::post('/iku/store', [KelolaRegisController::class, 'storeIku'])->name('iku.store');
Route::post('/iku/update/{id}', [KelolaRegisController::class, 'updateIku'])->name('iku.update');
Route::delete('/iku/delete/{id}', [KelolaRegisController::class, 'destroyIku'])->name('iku.destroy');
Route::delete('/iku/delete-selected', [KelolaRegisController::class, 'deleteSelectedIku'])->name('iku.delete-selected');

use App\Http\Controllers\KelolaBerandaController;
Route::middleware(['role:p4m'])->group(function () {
    Route::get('/kelola_beranda', [KelolaBerandaController::class, 'index'])->name('kelola_beranda');
    Route::post('/kelola_beranda/save-colors', [KelolaBerandaController::class, 'saveColors'])->name('kelola_beranda.save_colors');
    Route::post('/kelola_beranda/store', [KelolaBerandaController::class, 'storeKonten'])->name('kelola_beranda.store');
    Route::put('/kelola-beranda/{id}', [KelolaBerandaController::class, 'update'])->name('kelola-beranda.update');
    Route::delete('/kelola-beranda/{id}', [KelolaBerandaController::class, 'destroy'])->name('kelola-beranda.destroy');
});

use App\Http\Controllers\ArsipRisikoController;
Route::get('/arsip_risiko', [ArsipRisikoController::class, 'index'])->name('arsip_risiko');
Route::get('/arsip_risiko/export', [ArsipRisikoController::class, 'export'])->name('arsip_risiko.export');

use App\Http\Controllers\RegistrasiController;
Route::middleware(['role:p4m,kepala_unit'])->group(function () {
    Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi.index');
    Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi.store');
    Route::put('/registrasi/{id}', [RegistrasiController::class, 'update'])->name('registrasi.update');
    Route::delete('/registrasi/{id}', [RegistrasiController::class, 'destroy'])->name('registrasi.destroy');
    Route::post('/registrasi/import', [RegistrasiController::class, 'import'])->name('registrasi.import');
});

//IMPORT REGISTRASI
Route::get('/registrasi/export', [RegistrasiController::class, 'export'])
    ->name('registrasi.export');

use App\Http\Controllers\MitigasiController;
Route::get('/mitigasi', [MitigasiController::class, 'index'])->name('mitigasi.index');
Route::post('/mitigasi', [MitigasiController::class, 'store'])->name('mitigasi.store');
Route::put('/mitigasi/{id}', [MitigasiController::class, 'update'])->name('mitigasi.update');
Route::delete('/mitigasi/{id}', [MitigasiController::class, 'destroy'])->name('mitigasi.destroy');

use App\Http\Controllers\VerifikasiRisikoController;
Route::middleware(['role:p4m,auditor'])->group(function () {
    Route::get('/verifikasi_risiko', [VerifikasiRisikoController::class, 'index'])->name('verifikasi_risiko');
    Route::put('/verifikasi-risiko/{id}', [VerifikasiRisikoController::class, 'updateStatus'])->name('verifikasi_risiko.update');
});

use App\Http\Controllers\PenilaianController;
Route::middleware(['role:p4m,auditor'])->group(function () {
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian');
    Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::put('/penilaian/update', [PenilaianController::class, 'update'])->name('penilaian.update');
    Route::delete('/penilaian/{id}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');
});

use App\Http\Controllers\EvaluasiController;
Route::post('/evaluasi', [EvaluasiController::class, 'store'])->name('evaluasi.store');
Route::put('/evaluasi/{id}', [EvaluasiController::class, 'update'])->name('evaluasi.update');
Route::delete('/evaluasi/{id}', [EvaluasiController::class, 'destroy'])->name('evaluasi.destroy');

use App\Http\Controllers\PemetaanAuditorController;

Route::middleware(['auth', 'role:p4m'])->group(function () {
    Route::get('/pemetaan_auditor', 
        [PemetaanAuditorController::class, 'index'])->name('pemetaan_auditor');
    Route::post('/pemetaan_auditor/store', 
        [PemetaanAuditorController::class, 'store'])->name('pemetaan_auditor.store');
    Route::delete('/pemetaan_auditor/delete_all/{auditor_id}',
    [PemetaanAuditorController::class, 'deleteAll'])->name('pemetaan_auditor.delete_all');
});

use App\Http\Controllers\KelolaArsipController;
Route::get('/kelola_arsip', [KelolaArsipController::class, 'index'])->name('kelola_arsip');
Route::delete('/kelola_arsip/{id}', [KelolaArsipController::class, 'destroy'])->name('kelola_arsip.destroy');
