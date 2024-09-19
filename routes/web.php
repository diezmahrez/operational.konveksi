<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ModelpolaController;
use App\Http\Controllers\Orders;
use App\Http\Controllers\PotonganbahanController;
use App\Http\Controllers\PotonganBahanDetailController;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/login', function () {
    return view('login/login');
})->name('login');

Route::post('/auth', [authController::class, 'check_auth']);

Route::middleware('auth')->group(function () {
    Route::get('/logout', [authController::class, 'logout']);

    Route::get('/dashboard', [dashboard::class, 'index']);

    Route::controller(Orders::class)->group(function () {
        //Orders
        Route::get('/orders', 'orders');
        Route::get('/orders/getkodemodel',  'getkodemodel');
        Route::get('/orders/getdataharga',  'getdataharga');
        Route::post('/orders/post_orders',  'post_orders');
    });

    Route::controller(PotonganbahanController::class)->group(function(){
        //Potongan Bahan
        Route::get('/potonganbahan',  'potonganbahan');
        Route::any('/historypotonganbahan',  'historypotonganbahan');
        Route::get('/potonganbahan/getkodemodel',  'getkodemodel');
        Route::post('/potonganbahan/post_potonganbahan',  'post_potonganbahan');
        Route::get('/potonganbahan/{kode_potonganbahan}',  'detail_potonganbahan');
        Route::get('/historypotonganbahan/{kode_potonganbahan}',  'historydetail_potonganbahan');
        Route::post('/potonganbahan/post_potonganbahandetail',  'post_potonganbahandetail');
        Route::post('/potonganbahan/qrcode_print',  'qrcode_print');
        Route::post('/potonganbahan/delete_detaildata',  'delete_detaildata');
        Route::post('/potonganbahan/edit_detaildata',  'edit_detaildata');
        Route::get('/potonganbahan/close/{kode_potonganbahan}',  'close_potonganbahan');
        Route::get('/potonganbahan/print/{kode_potonganbahan}',  'print_potonganbahan');
        
    });

    Route::controller(PotonganBahanDetailController::class)->group(function(){
        //Potongan Bahan Detail
        Route::any('/potonganbahandetail/inputprocess',  'inputprocess');
        Route::any('/potonganbahandetail/inputclose',  'inputclose');
        Route::get('/potonganbahandetail/getkode_potonganbahan_detail',  'getkode_potonganbahan_detail');
    });

    Route::controller(CustomerController::class)->group(function(){
        //Customer
        Route::get('/customer',  'customer');
        Route::post('/customer/post_customer',  'post_customer');
        Route::get('customer/lihat-detail-data',  'lihat_detail_data');
        Route::post('/customer/update_customer',  'change_customer');
    });

    Route::controller(ModelpolaController::class)->group(function(){
        //Model_pola
        Route::get('/Model_pola',  'index');
        Route::post('/Model_pola/post_modelpola',  'post_modelpola');
        Route::get('Model_pola/lihat-detail-data',  'lihat_detail_data');
        Route::post('/Model_pola/update_model',  'change_model');
    });

    Route::controller(KaryawanController::class)->group(function(){
        //Karyawan
        Route::get('/karyawan',  'index');
        Route::post('/karyawan/post_karyawan',  'post_karyawan');
        Route::get('/karyawan/lihat-detail-data',  'lihat_detail_data');
        Route::post('/karyawan/update_karyawan',  'change_karyawan');
    });
});
