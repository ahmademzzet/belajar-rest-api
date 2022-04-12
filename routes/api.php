<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//panggil productController sebagai object
use App\Http\Controllers\ProductController;

//buat route untuk menambahkan data product
Route::post('/product',[ProductController::class,'store']);

//route untuk menampilkan data product secara keseluruhan
Route::get('/product',[ProductController::class,'showAll']);

//route untuk menampilkan data produk berdasarkan nama
Route::get('/product/search/product_name={product_name}',[ProductController::class,'showById']);
