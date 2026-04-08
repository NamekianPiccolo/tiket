<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PaymentController;

// Public routes

Route::get('/', [TiketController::class, 'dashboard'])->middleware('block.admin')->name('dashboard');
Route::post('/payment/notification', [PaymentController::class, 'notificationHandler']); //skip
Route::get('/detailTiket/{id}', [TiketController::class, 'detailtiket'])->middleware("block.admin")->name('detail.tiket');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('customer')->group(function () {
        Route::get("/tiketCustomer", [TiketController::class, 'tiketCustomer'])->name('tiket.customer');
        Route::post('/checkoutLangsung', [TransaksiController::class, 'checkout_Langsung'])->name('checkout.langsung');
        Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('transaksis.checkout');
        Route::post('/payment', [PaymentController::class, 'pay'])->name('api.payment.pay');
        Route::post('/createTiket', [PaymentController::class, 'createTiket'])->name('createTiket');
        Route::get('/thankyou', [PaymentController::class, 'thankyou'])->name('thankyou');
        Route::get('/payment/show', [TransaksiController::class, 'show'])->name('payment.show');
        Route::post('/beli-sekarang', [TransaksiController::class, 'beliSekarang'])->name('transaksi.beli-sekarang');
        Route::post('/bayar', [TransaksiController::class, 'bayar'])->name('transaksi.bayar');
        Route::resource('keranjang', KeranjangController::class)->names([
            'keranjang.index' => 'keranjang.index',
            'keranjang.create' => 'keranjang.create',
            'keranjang.store' => 'keranjang.store',
            'keranjang.show' => 'keranjang.show',
            'keranjang.edit' => 'keranjang.edit',
            'keranjang.update' => 'keranjang.update',
            'keranjang.destroy' => 'keranjang.destroy'
        ]);
        Route::resource('transaksi', TransaksiController::class)->names([
            'transaksi.index' => 'transaksi.index',
            'transaksi.create' => 'transaksi.create',
            'transaksi.edit' => 'transaksi.edit',
            'transaksi.update' => 'transaksi.update',
            'transaksi.destroy' => 'transaksi.destroy'
        ]);
    });


    Route::middleware('admin')->group(function () {
        Route::resource('tikets', TiketController::class)->names([
            'index' => 'tikets.index',
            'create' => 'tikets.create',
            'store' => 'tikets.store',
            'show' => 'tikets.show',
            'edit' => 'tikets.edit',
            'update' => 'tikets.update',
            'destroy' => 'tikets.destroy'
        ]);
        Route::get('/tikets/search', [TiketController::class, 'search'])->name('tikets.search');
        Route::get('/get-Regencie/{province_id}', [TiketController::class, 'getRegencie']);
        Route::get('/get-District/{regencie_id}', [TiketController::class, 'getDistrict']);
        Route::get('/validasi', [TiketController::class, 'validasi'])->name('validasi');
        Route::post('/tiket/scan', [TiketController::class, 'scan'])->name('admin.tickets.scan');
        Route::post('/tiket/verify', [TiketController::class, 'verify'])->name('admin.tickets.verify');
        });

        Route::get('/cek-imagick', function () {
    return extension_loaded('imagick')
        ? "✅ Imagick sudah terdeteksi!"
        : "❌ Imagick BELUM terdeteksi.";
});
});


