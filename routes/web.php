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



Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');})->name('dashboard');

    //kategori
    Route::get('/kategori', function () {
        return view('admin.kategori');})->middleware('auth');

    //sub kategori
    Route::get('/subkategori',[CategoryController::class, 'subcategory'])->middleware('auth');
  
    //sub kategori
    Route::get('/kategori/{category}',[CategoryController::class, 'Categorydasboard'])->name('categorydashboard')->middleware('auth');

});

// Route::group(function(){
    //Tambah Data
    Route::get('/tambah',[ReportController::class, 'create'])->name('tambah_data');

    //detail data
    Route::get('/detail/{report}', [ReportController::class, 'show'])->name('report_detail');

    //data humas
    Route::get('/humas', function(){return view('user.humas');})->name('report_humas');

    //data humas
    Route::get('/kerjasama', function(){return view('user.kerjasama');})->name('report_kerjasama');

    //data pelayanan
    Route::get('/pelayanan', function(){return view('user.pelayanan');})->name('report_pelayanan');
// })->midleware('auth');


//gambar ckeditor
// Route::post('image-upload', [ImageUploadController::class, 'storeImage'])->name('imageupload');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//user dashboard
Route::get('/', function () {
    return view('user.userdashboard');
})->name('home')->middleware('auth');

