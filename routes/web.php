<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BarangController;

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

Route::get('/', function() {
	return view('dokumentasi');
});

Route::redirect('/dokumentasi', '/');

Route::controller(DashboardController::class)->group(function()
{
	Route::get('/dashboard', 'index');
	Route::post('/dashboard/search', 'search');
	Route::post('/dashboard/sort-barang', 'sort_barang');
	Route::post('/dashboard/sort-jenis-barang', 'sort_jenis_barang');
});

Route::controller(TransaksiController::class)->group(function()
{
	Route::get('/transaksi', 'index');
	Route::post('/transaksi/search', 'search');
	Route::post('/transaksi/sort', 'sort');
	Route::post('/transaksi/search-stok', 'search_stok');
	Route::post('/transaksi/store', 'store');
	Route::post('/transaksi/update', 'update');
	Route::get('/transaksi/delete/{transaksi}', 'delete');
});

Route::controller(BarangController::class)->group(function()
{
	Route::get('/barang', 'index');
	Route::post('/barang/store', 'store');
	Route::post('/barang/update', 'update');
	Route::get('/barang-show', 'show');
	Route::post('/barang/store_stok', 'store_stok');
	Route::get('/barang/delete/{barang}', 'delete');
});
