<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

// Public Landing Page Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kategori/{category}', [HomeController::class, 'index'])->name('category.show');

// Public News Detail Route
Route::get('/berita/{slug}', [HomeController::class, 'show'])->name('news.detail');

// Admin Panel Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // Post Berita (Create)
    Route::get('/post-berita', [AdminController::class, 'createPost'])->name('admin.post-berita');
    Route::post('/post-berita', [AdminController::class, 'storePost'])->name('admin.post-berita.store');

    // Edit Berita
    Route::get('/kelola-berita/{id}/edit', [AdminController::class, 'editNews'])->name('admin.kelola-berita.edit');
    Route::put('/kelola-berita/{id}', [AdminController::class, 'updateNews'])->name('admin.kelola-berita.update');

    // Layout Mapping
    Route::get('/layout-mapping', [AdminController::class, 'layoutMapping'])->name('admin.layout-mapping');

    // Kelola Berita
    Route::get('/kelola-berita', [AdminController::class, 'manageNews'])->name('admin.kelola-berita');
    Route::delete('/kelola-berita/{id}', [AdminController::class, 'deleteNews'])->name('admin.kelola-berita.delete');
});
