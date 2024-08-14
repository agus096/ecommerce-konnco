<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PaymentController;

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



Route::middleware(['web', 'admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/listproduk', [ProdukController::class, 'showProduk'])->name('showProduk');
    Route::post('admin/listproduk', [ProdukController::class, 'store'])->name('products.store');
    Route::delete('admin/listproduk/{id}', [ProdukController::class, 'destroy'])->name('products.destroy');
    Route::put('admin/listproduk/{id}', [ProdukController::class, 'update'])->name('products.update');
    Route::get('admin/listpesanan', [PaymentController::class, 'showPesanan'])->name('showPesanan');
});


// Rute untuk menangani proses login
Route::get('/', [IndexController::class, 'index'])->name('index');

// Rute untuk menampilkan form login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Rute untuk menangani proses login
Route::post('login', [LoginController::class, 'login']);

// Rute untuk menangani logout
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/create-transaction', [PaymentController::class, 'createTransaction']);

Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification']);