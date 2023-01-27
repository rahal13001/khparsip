<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
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
//dashboard
Route::get('/', function () {
    return view('admin.dashboard');
})->name('home')->middleware('auth');

//kategori
Route::get('/kategori', function () {
    return view('admin.kategori');
})->middleware('auth');

//sub kategori
Route::get('/subkategori',[CategoryController::class, 'subcategory'])->middleware('auth');

//Tambah Data
Route::get('/tambah',[ReportController::class, 'create'])->name('tambah_data')->middleware('auth');

//detail data
Route::get('/detail/{report}', [ReportController::class, 'show'])->name('report_detail')->middleware('auth');

//gambar ckeditor
// Route::post('image-upload', [ImageUploadController::class, 'storeImage'])->name('imageupload');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
