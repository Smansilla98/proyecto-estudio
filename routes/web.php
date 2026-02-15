<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RitmoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PartituraController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('ritmos', RitmoController::class);
    Route::post('/ritmos/{ritmo}/approve', [RitmoController::class, 'approve'])->name('ritmos.approve');

    // Videos
    Route::get('/videos', function () {
        $videos = \App\Models\Video::with(['ritmo', 'tambor'])->latest()->get();
        return view('videos.index', compact('videos'));
    })->name('videos.index');
    Route::post('/ritmos/{ritmo}/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::put('/videos/{video}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');

    // Partituras
    Route::get('/partituras', function () {
        $partituras = \App\Models\Partitura::with('ritmo')->latest()->get();
        return view('partituras.index', compact('partituras'));
    })->name('partituras.index');
    Route::post('/ritmos/{ritmo}/partituras', [PartituraController::class, 'store'])->name('partituras.store');
    Route::put('/partituras/{partitura}', [PartituraController::class, 'update'])->name('partituras.update');
    Route::delete('/partituras/{partitura}', [PartituraController::class, 'destroy'])->name('partituras.destroy');
});

