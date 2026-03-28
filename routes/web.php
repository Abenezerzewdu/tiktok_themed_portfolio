<?php

use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AboutController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//home page
Route::get('/',[ProjectController::class,'index']);
Route::get('/project/{slug}', [ProjectController::class, 'show']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminProjectController::class, 'index']);
    Route::post('/admin/projects', [AdminProjectController::class, 'store']);
    

});
Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/message', [AdminProjectController::class, 'message']);
Route::post('/message',[AdminProjectController::class,'storeMessage']);

// About Chronicle routes
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::middleware(['auth'])->group(function () {
    Route::put('/about', [AboutController::class, 'update'])->name('about.update');
});

require __DIR__.'/auth.php';
