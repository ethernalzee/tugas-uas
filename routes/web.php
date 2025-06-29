<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Member\BorrowingController as MemberBorrowingController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('books', AdminBookController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('borrowings', AdminBorrowingController::class);
    Route::post('borrowings/{borrowing}/return', [AdminBorrowingController::class, 'returnBook'])->name('borrowings.return');
});

// Member Routes
Route::middleware(['auth', 'member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboard::class, 'index'])->name('dashboard');
    Route::get('/books', [MemberBookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [MemberBookController::class, 'show'])->name('books.show');
    Route::post('/books/{book}/borrow', [MemberBookController::class, 'borrow'])->name('books.borrow');
    Route::get('/borrowings', [MemberBorrowingController::class, 'index'])->name('borrowings.index');
});