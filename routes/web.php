<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskListController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Membuat route untuk home
// Route untuk halaman utama aplikasi, memanggil method 'index' dari TaskController
Route::get('/', [TaskController::class, 'index'])->name('home');

// Route resource untuk mengelola 'lists', menggunakan TaskListController
Route::resource('lists', TaskListController::class);
// Route untuk fitur pencarian, memanggil method 'search' dari SearchController
Route::get('search', [SearchController::class, 'search'])->name('search');

// Route resource untuk mengelola 'tasks', menggunakan TaskController
Route::resource('tasks', TaskController::class);
// Route untuk menandai tugas sebagai selesai (completed), memanggil method 'complete' dari TaskController
Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

Route::patch('/tasks/{task}/change-list', [TaskController::class, 'changeList'])->name('tasks.changeList');
