<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController; // Import admin
use App\Http\Controllers\Admin\PhotoController as AdminPhotoController; // Import admin
use App\Http\Controllers\Admin\PostController as AdminPostController; // Import admin


// ### PUBLIC SITE ###
// This is the route for your main homepage (replaces index.php)
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// ### ADMIN PANEL ###
// All routes in this group require the user to be logged in
// and will be prefixed with '/dashboard'

Route::middleware('auth')->group(function () {

    // Breeze's Profile Routes
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ### ADMIN-ONLY ROUTES ###
    // Routes in *this* group require the user to be logged in AND be an admin.
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        Route::resource('galleries', AdminGalleryController::class);

        Route::get('galleries/{gallery}/photos', [AdminPhotoController::class, 'index'])->name('photos.index');
        Route::post('galleries/{gallery}/photos', [AdminPhotoController::class, 'store'])->name('photos.store');
        Route::delete('photos/{photo}', [AdminPhotoController::class, 'destroy'])->name('photos.destroy');

        Route::patch('photos/{photo}/set-cover', [AdminPhotoController::class, 'setCover'])->name('photos.setCover');
        Route::patch('galleries/{gallery}/feature', [AdminGalleryController::class, 'feature'])->name('galleries.feature');
        Route::patch('galleries/{gallery}/unfeature', [AdminGalleryController::class, 'unfeature'])->name('galleries.unfeature');

        Route::resource('posts', AdminPostController::class);

    });
});

require __DIR__.'/auth.php';
