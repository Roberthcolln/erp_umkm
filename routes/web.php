<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LaporanKeseluruhanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\SettingController;
use App\Livewire\Pengeluaran;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/produk/{slug}', [HomeController::class, 'detailProduk'])->name('produk.detail');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{slug}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard.index');

    Route::resource('setting', SettingController::class);
    Route::post('image-upload', [SettingController::class, 'storeImage'])->name('image.upload');
    Route::resource('dashboard', DashboardController::class);
    Route::resource('kategori_produk', KategoriProdukController::class);
    Route::resource('produk', ProdukController::class);

    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/transactions', [CartController::class, 'transactions'])->name('transactions')->middleware('auth');
    Route::get('/cetak-struk/{order}', [\App\Http\Controllers\CartController::class, 'cetakStruk'])->name('cetak-struk');

    Route::get('/pengeluaran', Pengeluaran::class);
    Route::resource('pengeluaran', PengeluaranController::class);

    Route::resource('saldo', SaldoController::class);

    Route::get('/laporan', \App\Livewire\LaporanKeseluruhan::class)->middleware('auth');
    Route::resource('laporan', LaporanKeseluruhanController::class);
    Route::get('/laporan/pdf', [LaporanKeseluruhanController::class, 'cetakPDF'])->name('laporan.pdf')->middleware('auth');
});
