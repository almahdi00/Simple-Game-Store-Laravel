<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\GameController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes untuk semua user yang sudah login (role admin & user)
Route::middleware('auth')->group(function () {
    Route::get('/library', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tambahan routes upload/edit/delete game user
    // Route user upload game
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');

    // Route user edit game
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');

    // Route hapus game
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
    Route::get('/my-games', [GameController::class, 'myGames'])->name('games.my');
    Route::get('/games/index', [GameController::class, 'index'])->name('games.index');
    Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');
    Route::get('/play/{game}', [GameController::class, 'play'])->name('games.play')->middleware('can:play,game');
    Route::get('/transactions/{transaction}/print', [\App\Http\Controllers\User\TransactionController::class, 'printSingle'])
        ->middleware('auth')
        ->name('transactions.print');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // Menambahkan game ke keranjang
    Route::post('/cart/add/{game}', [CartController::class, 'add'])->name('cart.add');

    // Checkout semua item sekaligus
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // ✅ Checkout satu item dari keranjang
    Route::post('/cart/checkout/{id}', [CartController::class, 'checkoutItem'])->name('cart.checkoutItem');

    // Menghapus item dari keranjang
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
});

// Routes khusus untuk admin saja
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('games', [AdminGameController::class, 'index'])->name('games.index');
    Route::get('games/create', [AdminGameController::class, 'create'])->name('games.create');
    Route::post('games', [AdminGameController::class, 'store'])->name('games.store');
    Route::get('games/{game}/edit', [AdminGameController::class, 'edit'])->name('games.edit');
    Route::put('games/{game}', [AdminGameController::class, 'update'])->name('games.update');
    Route::delete('games/{game}', [AdminGameController::class, 'destroy'])->name('games.destroy');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
});

require __DIR__ . '/auth.php';
