<?php

use App\Http\Controllers\Account\PasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Permissions\AssignController;
use App\Http\Controllers\Permissions\AssignuserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SuperadminController;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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



Route::prefix('admin')->middleware('permission:Akses Admin')->group(function () {

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

Route::prefix('superadmin')->middleware('permission:Akses Super Admin')->group( function () {

    Route::get('/userkategori', function(){
        return view ('superadmin.tambahkategori');
    })->name('superadmin_tambah');

    Route::get('/role', function(){
        return view('superadmin.role');
    })->name('role');
    
    Route::get('/permission', function(){
        return view('superadmin.permission');
    })->name('permission');

    Route::get('/assignrole', function(){
        return view('superadmin.assignrole');
    })->name('assignrole');

    Route::get('/assignrole/{role}', [AssignController::class, 'edit'])->name('assign_edit');
    Route::put('/assignrole/{role}', [AssignController::class, 'update'])->name('assign_update');
    Route::get('/userkategori/{user}/edit', [AssignuserController::class, 'edit'])->name('assignuser_edit'); 
    Route::put('/userkategori/{user}', [AssignuserController::class, 'update'])->name('assignuser_update'); 

});


Route::middleware('has.role')->group(function(){
    //Tambah Data
    Route::get('/tambah',[ReportController::class, 'create'])->name('tambah_data');

    //detail data
    Route::get('/detail/{report}', [ReportController::class, 'show'])->name('report_detail');

    //data humas
    Route::get('/reportdashboard', [ReportController::class, 'index'])->name('report_dashboard');

});

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//user dashboard
Route::get('/', function () {
    return view('user.userdashboard');
})->name('home')->middleware('auth', 'verified');

   //Route profile
   Route::get('/profile', function () {
    return view('user.profile');})->middleware('auth');


Route::get('/pdf/{report}', [ReportController::class, 'pdf'])->name('pdf');
//Lihat dokumentasi lainnya
Route::get('lihat_lainnya/{report}',[ReportController::class, 'viewlainnya'])->name('view_pdf');
//Lihat dokumentasi st
Route::get('lihat_st/{report}',[ReportController::class, 'viewst'])->name('view_st');

//Ubah Password
Route::middleware('auth')->group( function() {
    Route::get('ubahpassword', [PasswordController::class, 'edit'])->name('password_edit');
    Route::patch('ubahpassword/{password}', [PasswordController::class, 'update'])->name('password_update');
});


