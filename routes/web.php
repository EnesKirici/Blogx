<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;

// Ana sayfa
Route::get('/', function () {
    return view('home');
});

// Blog yazıları
Route::get('/posts', function () {
    return view('home');
});

Route::get('/posts/{id}', function ($id) {
    return view('post-detail');
});

// Test sayfaları
Route::get('/home', function () {
    return view('home');
});

Route::get('/post-detail', function () {
    return view('post-detail');
});

// Auth Routes
Route::get('/kullanici-olustur', [RegisterController::class, 'show'])->name('user.register');
Route::post('/kullanici-olustur', [RegisterController::class, 'register']);

Route::get('/kullanici-giris', [LoginController::class, 'show'])->name('user.login');
Route::post('/kullanici-giris', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Post Routes (GİRİŞ ZORUNLU)
Route::middleware('auth')->group(function () {
    Route::get('/post-olustur', function () {
        return view('create-post');
    })->name('user.create-post');
    
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});
