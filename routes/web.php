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
Route::get('/logout', [authController::class, 'logout']);

Route::get('/dashboard', [dashboard::class, 'index'])->middleware('auth');

//Orders
Route::get('/orders',[Orders::class,'orders'])->middleware('auth');
Route::get('/orders/getkodemodel',[Orders::class,'getkodemodel'])->middleware('auth');
Route::get('/orders/getdataharga',[Orders::class,'getdataharga'])->middleware('auth');
Route::post('/orders/post_orders',[Orders::class,'post_orders'])->middleware('auth');


//Potongan Bahan
Route::get('/potonganbahan',[PotonganbahanController::class,'potonganbahan'])->middleware('auth');
Route::get('/historypotonganbahan',[PotonganbahanController::class,'historypotonganbahan'])->middleware('auth');
Route::get('/potonganbahan/getkodemodel',[PotonganbahanController::class,'getkodemodel'])->middleware('auth');
Route::post('/potonganbahan/post_potonganbahan',[PotonganbahanController::class,'post_potonganbahan'])->middleware('auth');
Route::get('/potonganbahan/{kode_potonganbahan}',[PotonganbahanController::class,'detail_potonganbahan'])->middleware('auth');
Route::get('/historypotonganbahan/{kode_potonganbahan}',[PotonganbahanController::class,'historydetail_potonganbahan'])->middleware('auth');
Route::post('/potonganbahan/post_potonganbahandetail',[PotonganbahanController::class,'post_potonganbahandetail'])->middleware('auth');
Route::post('/potonganbahan/qrcode_print',[PotonganbahanController::class,'qrcode_print'])->middleware('auth');
Route::post('/potonganbahan/delete_detaildata',[PotonganbahanController::class,'delete_detaildata'])->middleware('auth');
Route::post('/potonganbahan/edit_detaildata',[PotonganbahanController::class,'edit_detaildata'])->middleware('auth');
Route::get('/potonganbahan/close/{kode_potonganbahan}',[PotonganbahanController::class,'close_potonganbahan'])->middleware('auth');
Route::get('/potonganbahan/print/{kode_potonganbahan}',[PotonganbahanController::class,'print_potonganbahan'])->middleware('auth');

//Potongan Bahan Detail
Route::any('/potonganbahandetail/inputprocess',[PotonganBahanDetailController::class,'inputprocess'])->middleware('auth');
Route::get('/potonganbahandetail/inputclose',[PotonganBahanDetailController::class,'inputclose'])->middleware('auth');
Route::get('/potonganbahandetail/getkode_potonganbahan_detail',[PotonganBahanDetailController::class,'getkode_potonganbahan_detail'])->middleware('auth');



//Customer
Route::get('/customer',[CustomerController::class,'customer'])->middleware('auth');
Route::post('/customer/post_customer',[CustomerController::class,'post_customer'])->middleware('auth');
Route::get('customer/lihat-detail-data',[CustomerController::class,'lihat_detail_data'])->middleware('auth');
Route::post('/customer/update_customer',[CustomerController::class,'change_customer'])->middleware('auth');

//Model_pola
Route::get('/Model_pola',[ModelpolaController::class,'index'])->middleware('auth');
Route::post('/Model_pola/post_modelpola',[ModelpolaController::class,'post_modelpola'])->middleware('auth');
Route::get('Model_pola/lihat-detail-data',[ModelpolaController::class,'lihat_detail_data'])->middleware('auth');
Route::post('/Model_pola/update_model',[ModelpolaController::class,'change_model'])->middleware('auth');


//Karyawan
Route::get('/karyawan',[KaryawanController::class,'index'])->middleware('auth');
Route::post('/karyawan/post_karyawan',[KaryawanController::class,'post_karyawan'])->middleware('auth');
Route::get('/karyawan/lihat-detail-data',[KaryawanController::class,'lihat_detail_data'])->middleware('auth');
Route::post('/karyawan/update_karyawan',[KaryawanController::class,'change_karyawan'])->middleware('auth');
