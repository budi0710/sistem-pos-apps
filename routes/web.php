<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangJadiController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\JenisBrjController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

//REGISTER
Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('register/action', [RegisterController::class, 'actionregister'])->name('actionregister');
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::get('layouts.home', function () {
            return view('layouts.home');
        });
        
        Route::get('HomeController', [HomeController::class, 'index'])->name('HomeController.index');

        Route::get('/home', function () {
            return view('layouts.home');
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

        Route::get('/customer', function () {
            return view('customer.index');
        });

        Route::get('/brk', function () {
            return view('brk.index');
        });

 