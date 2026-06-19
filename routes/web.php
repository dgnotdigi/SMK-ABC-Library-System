<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth.session')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/catalog', \App\Livewire\Catalog::class)->name('catalog.index');
    Route::get('/catalog/{book}', \App\Livewire\BookDetail::class)->name('catalog.show');

    Route::get('/my-books', \App\Livewire\MyBooks::class)->name('my-books');
    Route::get('/my-holds', \App\Livewire\MyHolds::class)->name('my-holds');

    Route::middleware('admin')->group(function () {
        Route::get('/admin/checkouts', \App\Livewire\Admin\ActiveCheckouts::class)->name('admin.checkouts');
        Route::get('/admin/holds', \App\Livewire\Admin\HoldsQueue::class)->name('admin.holds');
        Route::get('/admin/reports', \App\Livewire\Admin\Reports::class)->name('admin.reports');
        Route::get('/admin/books/add', \App\Livewire\Admin\AddBook::class)->name('admin.books.add');
    });
});
