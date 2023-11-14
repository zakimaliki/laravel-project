<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::post('/products/upload', [ProductController::class, 'upload']);


// Route untuk menampilkan daftar produk
Route::get('/list-product', [ProductController::class, 'list_product']);

// Route untuk menampilkan detail produk
Route::get('/detail-product/{id}', [ProductController::class, 'detail_product']);

// Route untuk menyimpan produk baru
Route::post('/create-product', [ProductController::class, 'create_product']);

// Route untuk mengupdate produk
Route::put('/update-product/{id}', [ProductController::class, 'update_product']);

// Route untuk menghapus produk
Route::delete('/delete-product/{id}', [ProductController::class, 'delete_product']);