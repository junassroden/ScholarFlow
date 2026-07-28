<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PaperController;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/auth/google', [AuthController::class, 'redirectGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'callbackGoogle'])->name('google.callback');

Route::get('/auth/github', [AuthController::class, 'redirectGithub'])->name('github.login');
Route::get('/auth/github/callback', [AuthController::class, 'callbackGithub'])->name('github.callback');

Route::get('/search', [SearchController::class, 'search']);

Route::get('/paper', [PaperController::class, 'show'])->name('paper.show');

Route::get('/test-openaire', function () {

    $response = Http::get(
        'https://api.openaire.eu/search/publications',
        [
            'keywords' => 'artificial intelligence',
            'size' => 1,
        ]
    );

    dd([
        'status' => $response->status(),
        'headers' => $response->headers(),
        'body' => $response->body(),
    ]);
});