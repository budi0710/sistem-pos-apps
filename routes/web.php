<?php

use App\Http\Controllers\AbsenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangJadiController;
use App\Http\Controllers\H_poc_Controller;
use App\Http\Controllers\RlsSupplierController;
use App\Http\Controllers\H_posController;
use App\Http\Controllers\H_BeliController;
use App\Http\Controllers\H_stbjController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\JenisBrjController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\UnitkerjaContoller;
use App\Http\Controllers\H_btbgController;
use App\Http\Controllers\T_btbgController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SettingMiddleware;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Middleware\UserMiddleware;
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
    $session = $request->session()->get('user_id');
    return $session ? redirect('home') : view('login');
});

Route::post('/user-login',[UserController::class, 'login']);
Route::post('/save-setting',[SettingController::class, 'save']);
Route::post('/upload-foto-company',[SettingController::class, 'upload']);
Route::get('HomeController', [HomeController::class, 'index'])->name('HomeController.index');

Route::get('/admin-logout',function(Request $request){
    $request->session()->forget('user_id');
    return redirect('/login');
});

Route::middleware([UserMiddleware::class])->group(function () {
    //Masukkan kesini routenya yg btuh auth session
    Route::get('/setting',function(){
    $data = Setting::where('id',1)->first();

    Route::get('/absensi', function () {
        return view('absen');
    });

    return view('setting',$data);
    });

    Route::get('/home', function () {
        return view('layouts.home');
    });

    Route::get('/dasboard', function () {
        return view('layouts.dasboard');
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

    Route::get('/fg', function () {
    return view('fg.index');
    }); 
    
    Route::get('/satuan', function () {
    return view('satuan.index');
    });

    Route::get('/jenis', function () {
    return view('jenis.index');
    });

    Route::get('/jenis-brj', function () {
        return view('jenis-brj.index');
    });

    Route::get('/supplier', function () {
        return view('supplier.index');
    });

    Route::get('/customer', function () {
        return view('customer.index');
    });

    Route::get('/unitkerja', function () {
        return view('hris/unitkerja');
    });

    Route::get('/jabatan', function () {
        return view('hris/jabatan');
    });

    Route::get('/wip', function () {
        return view('bdp.index');
    });


    Route::get('/brk', function () {
        return view('brk.index');
    });

    Route::get('/po_customer', function () {
        return view('po_customer.index');
    });

    Route::get('/Kirim', function () {
        return view('Kirim.index');
    });


    Route::get('/unitkerja', function () {
        return view('hris/unitkerja');
    });

    Route::get('/jabatan', function () {
        return view('hris/jabatan');
    });

    Route::get('/karyawan', function () {
        return view('hris/karyawan');
    });

    Route::get('/absensi', function () {
        return view('hris/absen');
    });

    Route::get('/permintaan', function () {
        return view('Pengeluaran_brg/permintaan');
    });

    Route::get('/pengeluaran', function () {
        return view('Pengeluaran_brg/pengeluaran');
    });

    Route::get('/penerimaan_fg', function () {
        return view('penerimaan_fg.index');
    });

    Route::get('/po_supplier', function () {
        return view('po_supplier.index');
    });

    Route::get('/rls-supplier', function () {
        return view('po_supplier/rls-brg-sup');
    });

    
    Route::get('/add-posupplier',function(){
            return view('po_supplier/add_posupplier');
    });

    Route::get('/beli-supplier', function () {
        return view('beli.index');
    });

    Route::get('/add-beli',function(){
        return view('beli/add-beli');
    });
    
    Route::get('/add-pocustomer',function(){
        return view('po_customer/add_pocustomer');
    });

    Route::get('/add_kirim',function(){
            return view('Kirim/add_kirim');
    });

    Route::get('/add-permintaan', function () {
        return view('Pengeluaran_brg/add-permintaan');
    });

    Route::get('/add-stbj',function(){
            return view('penerimaan_fg/add-stbj');
    });
});

Route::middleware([SettingMiddleware::class])->group(function () {
    // this is for route that can access by setting middleware
});

Route::get('/admin-logout',function(Request $request){
    $request->session()->forget('user_id');
    $request->session()->forget('user_role');
    return redirect('/');
});


Route::post('/load-brg',[BarangController::class, 'load']);
Route::post('/load-data-brg',[BarangController::class, 'loadData']);
Route::post('/save-brg',[BarangController::class, 'save']);
Route::post('/delete-brg',[BarangController::class, 'delete']);
Route::post('/update-brg',[BarangController::class, 'update']);
Route::post('/search-brg',[BarangController::class, 'search']);

Route::post('/load-brj',[BarangJadiController::class, 'load']);
Route::post('/load-data-brj',[BarangJadiController::class, 'loadData']);
Route::post('/save-brj',[BarangJadiController::class, 'save']);
Route::post('/delete-brj',[BarangJadiController::class, 'delete']);
Route::post('/update-brj',[BarangJadiController::class, 'update']);
Route::post('/search-brj',[BarangJadiController::class, 'search']);

Route::post('/load-satuan',[SatuanController::class, 'load']);
Route::post('/load-data-satuan',[SatuanController::class, 'loadData']);
Route::post('/save-satuan',[SatuanController::class, 'save']);
Route::post('/delete-satuan',[SatuanController::class, 'delete']);
Route::post('/update-satuan',[SatuanController::class, 'update']);
Route::post('/search-satuan',[SatuanController::class, 'search']);
Route::post('/generate-id-satuan',[SatuanController::class, 'generateId_Satuan']);

Route::post('/load-jenis',[JenisController::class, 'load']);
Route::post('/load-data-jenis',[JenisController::class, 'loadData']);
Route::post('/save-jenis',[JenisController::class, 'save']);
Route::post('/delete-jenis',[JenisController::class, 'delete']);
Route::post('/update-jenis',[JenisController::class, 'update']);
Route::post('/search-jenis',[JenisController::class, 'search']);
Route::post('/generate-id-jenis',[JenisController::class, 'generateId_Jenis']);

Route::post('/load-jenis-brj',[JenisBrjController::class, 'load']);
Route::post('/load-data-jenis-brj',[JenisBrjController::class, 'loadData']);
Route::post('/save-jenis-brj',[JenisBrjController::class, 'save']);
Route::post('/delete-jenis-brj',[JenisBrjController::class, 'delete']);
Route::post('/update-jenis-brj',[JenisBrjController::class, 'update']);
Route::post('/search-jenis-brj',[JenisBrjController::class, 'search']);
Route::post('/generate-id-jenis-brj',[JenisBrjController::class, 'generateId_JenisBRJ']);

Route::post('/load-sup',[SupplierController::class, 'load']);
Route::post('/load-data-sup',[SupplierController::class, 'loadData']);
Route::post('/save-sup',[SupplierController::class, 'save']);
Route::post('/delete-sup',[SupplierController::class, 'delete']);
Route::post('/update-sup',[SupplierController::class, 'update']);
Route::post('/search-sup',[SupplierController::class, 'search']);
Route::post('/generate-id-supplier',[SupplierController::class, 'generateId_Supplier']);

Route::post('/load-cus',[CustomerController::class, 'load']);
Route::post('/load-data-cus',[CustomerController::class, 'loadData']);
Route::post('/save-cus',[CustomerController::class, 'save']);
Route::post('/delete-cus',[CustomerController::class, 'delete']);
Route::post('/update-cus',[CustomerController::class, 'update']);
Route::post('/search-cus',[CustomerController::class, 'search']);
Route::post('/generate-id-customer',[CustomerController::class, 'generateId_Customer']);

Route::get('/md5',function(){
    return md5('123456');
});

Route::post('/delete-poc-customer',[H_poc_Controller::class, 'delete']);
Route::post('/save-poc-customer',[H_poc_Controller::class, 'save']);
Route::post('/proses-pocustomer',[H_poc_Controller::class, 'saveData']);
Route::post('/generate-id-hpoc',[H_poc_Controller::class,'generateNo']);
Route::post('/generate-kode-spk',[H_poc_Controller::class,'generateKodeSpK']);
Route::post('/load-hpo-customer',[H_poc_Controller::class, 'load']);
Route::post('/load-detail-pocustomer',[H_poc_Controller::class, 'loadWhere']);
//Inventory Barang

Route::post('/load-hbtbg',[H_btbgController::class, 'load']);
Route::post('/delete-hbtbg',[H_btbgController::class, 'delete']);
Route::post('/save-hbtbg',[H_btbgController::class, 'save']);
Route::post('/generate-id-hbtbg',[H_btbgController::class,'generateNo']);
Route::post('/generate-kode-sbtbg',[H_btbgController::class,'generateKodeSbtbg']);
Route::post('/save-hbtbg',[H_btbgController::class,'saveData']);
Route::post('/proses-hbtbg',[H_btbgController::class,'saveData']);
Route::post('/load-detail-permintaan',[T_btbgController::class, 'loadWhere']);

Route::post('/delete-h-stbj',[H_stbjController::class, 'delete']);
Route::post('/generate-id-hstbj',[H_stbjController::class,'generateNo']);
Route::post('/proses-simpan',[H_stbjController::class,'saveData']);
Route::post('/generate-kode-spk',[H_stbjController::class,'generateKodeSpK']);
Route::post('/load-h-stbj',[H_stbjController::class, 'load']);
Route::post('/load-detail-stbj',[H_stbjController::class, 'loadWhere']);

Route::post('/load-rls-sup',[RlsSupplierController::class, 'load']);
Route::post('/load-data-rls-sup',[RlsSupplierController::class, 'loadData']);
Route::post('/save-rls-sup',[RlsSupplierController::class, 'save']);
Route::post('/delete-rls-sup',[RlsSupplierController::class, 'delete']);
Route::post('/update-rls-sup',[RlsSupplierController::class, 'update']);
Route::post('/search-rls-sup',[RlsSupplierController::class, 'search']);
Route::post('/generate-id-rls-sup',[RlsSupplierController::class, 'generateId_RBS']);

Route::post('/delete-hpos-supplier',[H_posController::class, 'delete']);
Route::post('/generate-id-hpos',[H_posController::class,'generateNo']);
Route::post('/proses-posupplier',[H_posController::class,'saveData']);
Route::post('/generate-kode-spk',[H_posController::class,'generateKodeSpK']);
Route::post('/load-detail-posupplier',[H_posController::class, 'loadWhere']);
Route::post('/load-hpo-supplier',[H_posController::class, 'load']);
Route::post('/load-fno-supplier',[H_posController::class, 'loadWhereFnoPOS']);

Route::post('/delete-hbeli-supplier',[H_BeliController::class, 'delete']);
Route::post('/generate-id-hbeli',[H_BeliController::class,'generateNo']);
Route::post('/proses-belisupplier',[H_BeliController::class,'saveData']);
Route::post('/load-detail-belisupplier',[H_BeliController::class, 'loadWhere']);
Route::post('/load-hbeli-supplier',[H_BeliController::class, 'load']);

//HRIS
Route::post('/load-unitkerja',[UnitkerjaContoller::class, 'load']);
Route::post('/load-data-unitkerja',[UnitkerjaContoller::class, 'loadData']);
Route::post('/save-unitkerja',[UnitkerjaContoller::class, 'save']);
Route::post('/delete-unitkerja',[UnitkerjaContoller::class, 'delete']);
Route::post('/update-unitkerja',[UnitkerjaContoller::class, 'update']);
Route::post('/search-unitkerja',[UnitkerjaContoller::class, 'search']);

Route::post('/generate-id-unitkerja',[UnitkerjaContoller::class, 'generateId_Unitkerja']);

Route::post('/load-jabatan',[JabatanController::class, 'load']);
Route::post('/load-data-jabatan',[JabatanController::class, 'loadData']);
Route::post('/save-jabatan',[JabatanController::class, 'save']);
Route::post('/delete-jabatan',[JabatanController::class, 'delete']);
Route::post('/update-jabatan',[JabatanController::class, 'update']);
Route::post('/search-jabatan',[JabatanController::class, 'search']);
Route::post('/generate-id-jabatan',[JabatanController::class, 'generateId_Jabatan']);

Route::post('/load-karyawan',[KaryawanController::class, 'load']);
Route::post('/load-data-karyawan',[KaryawanController::class, 'loadData']);
Route::post('/load-data-statusnikah',[KaryawanController::class, 'loadDataStatus']);
Route::post('/save-karyawan',[KaryawanController::class, 'save']);
Route::post('/delete-karyawan',[KaryawanController::class, 'delete']);
Route::post('/update-karyawan',[KaryawanController::class, 'update']);
Route::post('/search-karyawan',[KaryawanController::class, 'search']);

Route::post('/upload-absen-masuk',[AbsenController::class, 'uploadAbsenMasuk']);
Route::post('/upload-absen-pulang',[AbsenController::class, 'uploadAbsenPulang']);
Route::post('/get-setting',[SettingController::class, 'getData']);
