<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController; // Import admin
use App\Http\Controllers\Admin\PhotoController as AdminPhotoController; // Import admin


// ### PUBLIC SITE ###
// This is the route for your main homepage (replaces index.php)
Route::get('/', [PageController::class, 'home'])->name('home');

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

        //Gallery Management (Full CRUD)
        Route::resource('galleries', AdminGalleryController::class);

        //Photo Management (Nested under Galleries)
        Route::get('galleries/{gallery}/photos', [AdminPhotoController::class, 'index'])->name('photos.index'); // <-- CORRECTED
        Route::post('galleries/{gallery}/photos', [AdminPhotoController::class, 'store'])->name('photos.store');
        Route::delete('photos/{photo}', [AdminPhotoController::class, 'destroy'])->name('photos.destroy');

        //Future Blog routes will go here
        // Route::resource('posts', AdminPostController::class);

    });
});

require __DIR__.'/auth.php';
