<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangJadiController;
use App\Http\Controllers\H_poc_Controller;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\JenisBrjController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SettingMiddleware;
use App\Models\Setting;
use Illuminate\Http\Request;
//REGISTER
// Route::get('register', [RegisterController::class, 'register'])->name('register');
// Route::post('register/action', [RegisterController::class, 'actionregister'])->name('actionregister');
// Route::get('/', [LoginController::class, 'login'])->name('login');
// Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
// Route::get('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

// Route::get('/register',function(Request $request){
//    return view('register');
// });
Route::get('/',function(Request $request){
   return redirect('login');
});

Route::get('/login',function(Request $request){
    $session = $request->session()->get('user');
   return $session ? redirect('home') : view('login');
});

Route::post('/user-login',[UserController::class, 'login']);

Route::post('/save-setting',[SettingController::class, 'save']);

Route::post('/upload-foto-company',[SettingController::class, 'upload']);


Route::get('HomeController', [HomeController::class, 'index'])->name('HomeController.index');

Route::get('/home', function () {
    return view('layouts.home');
});


Route::middleware([SettingMiddleware::class])->group(function () {
    // this is for route that can access by setting middleware
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/galery', function () {
    return view('galery');
});

Route::get('/wip', function () {
    return view('bdp.index');
});

        
Route::get('/jenis-brj', function () {
    return view('jenis-brj.index');
});

Route::get('/brg', function () {
    return view('brg.index');
});

Route::post('/load-brg',[BarangController::class, 'load']);
Route::post('/load-data-brg',[BarangController::class, 'loadData']);
Route::post('/save-brg',[BarangController::class, 'save']);
Route::post('/delete-brg',[BarangController::class, 'delete']);
Route::post('/update-brg',[BarangController::class, 'update']);
Route::post('/search-brg',[BarangController::class, 'search']);

Route::get('/fg', function () {
    return view('fg.index');
});

Route::post('/load-brj',[BarangJadiController::class, 'load']);
Route::post('/load-data-brj',[BarangJadiController::class, 'loadData']);
Route::post('/save-brj',[BarangJadiController::class, 'save']);
Route::post('/delete-brj',[BarangJadiController::class, 'delete']);
Route::post('/update-brj',[BarangJadiController::class, 'update']);
Route::post('/search-brj',[BarangJadiController::class, 'search']);

Route::get('/satuan', function () {
    return view('satuan.index');
});

Route::post('/load-satuan',[SatuanController::class, 'load']);
Route::post('/load-data-satuan',[SatuanController::class, 'loadData']);
Route::post('/save-satuan',[SatuanController::class, 'save']);
Route::post('/delete-satuan',[SatuanController::class, 'delete']);
Route::post('/update-satuan',[SatuanController::class, 'update']);
Route::post('/search-satuan',[SatuanController::class, 'search']);

Route::get('/jenis', function () {
    return view('jenis.index');
});

Route::post('/load-jenis',[JenisController::class, 'load']);
Route::post('/load-data-jenis',[JenisController::class, 'loadData']);
Route::post('/save-jenis',[JenisController::class, 'save']);
Route::post('/delete-jenis',[JenisController::class, 'delete']);
Route::post('/update-jenis',[JenisController::class, 'update']);
Route::post('/search-jenis',[JenisController::class, 'search']);

Route::get('/jenis-brj', function () {
    return view('jenis-brj.index');
});

Route::post('/load-jenis-brj',[JenisBrjController::class, 'load']);
Route::post('/load-data-jenis-brj',[JenisBrjController::class, 'loadData']);
Route::post('/save-jenis-brj',[JenisBrjController::class, 'save']);
Route::post('/delete-jenis-brj',[JenisBrjController::class, 'delete']);
Route::post('/update-jenis-brj',[JenisBrjController::class, 'update']);
Route::post('/search-jenis-brj',[JenisBrjController::class, 'search']);

Route::get('/supplier', function () {
    return view('supplier.index');
});

Route::post('/load-sup',[SupplierController::class, 'load']);
Route::post('/load-data-sup',[SupplierController::class, 'loadData']);
Route::post('/save-sup',[CustomerController::class, 'save']);
Route::post('/delete-sup',[SupplierController::class, 'delete']);
Route::post('/update-sup',[SupplierController::class, 'update']);
Route::post('/search-sup',[SupplierController::class, 'search']);

Route::get('/customer', function () {
    return view('customer.index');
});

Route::post('/load-cus',[CustomerController::class, 'load']);
Route::post('/load-data-cus',[CustomerController::class, 'loadData']);
Route::post('/save-cus',[CustomerController::class, 'save']);
Route::post('/delete-cus',[CustomerController::class, 'delete']);
Route::post('/update-cus',[CustomerController::class, 'update']);
Route::post('/search-cus',[CustomerController::class, 'search']);

Route::get('/brk', function () {
    return view('brk.index');
});


Route::get('/setting',function(){
    $data = Setting::where('id',1)->first();

    return view('setting',$data);
});


Route::get('/admin-logout',function(Request $request){
    $request->session()->forget('user');
    return redirect('/');
});


Route::get('/md5',function(){
    return md5('123456');
});

Route::get('/po-customer', function () {
    return view('po_customer.index');
});

Route::get('/add-pocustomer',function(){
        return view('po_customer/add_pocustomer');
});

Route::post('/delete-poc-customer',[H_poc_Controller::class, 'delete']);
Route::post('/save-poc-customer',[H_poc_Controller::class, 'save']);
Route::post('/generate-id-poc-customer',[H_poc_Controller::class,'generateNo']);
Route::post('/generate-kode-spk',[H_poc_Controller::class,'generateKodeSpK']);
Route::post('/save-poc-customer',[H_poc_Controller::class,'saveData']);