<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// Route untuk menampilkan daftar produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth');

// Route untuk menampilkan formulir tambah produk
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Route untuk menyimpan produk baru
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Route untuk menampilkan detail produk berdasarkan ID
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Route untuk menampilkan formulir edit produk berdasarkan ID
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

// Route untuk memperbarui produk berdasarkan ID
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

// Route untuk menghapus produk berdasarkan ID
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
