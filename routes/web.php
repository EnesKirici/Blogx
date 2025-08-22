<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController; // YENİ
use App\Http\Controllers\LikeController; // YENİ
use Illuminate\Support\Facades\Auth;

// Ana sayfa
Route::get('/', [HomeController::class, 'index'])->name('index');


// Blog yazıları
Route::get('/posts', function () {
    return view('home');
});

// TEK BLOG GÖRÜNÜMÜ (DİNAMİK)
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// BLOG DÜZENLEME
Route::get('/posts/{slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{slug}', [PostController::class, 'update'])->name('posts.update');

// YORUM SİSTEMİ (YENİ)
Route::post('/posts/{slug}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

// BEĞENİ SİSTEMİ (YENİ)
Route::post('/posts/{slug}/like', [LikeController::class, 'toggle'])->name('posts.like');

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

// Post Routes
Route::get('/post-olustur', function () {
    if (!Auth::check()) {
        return redirect('/')
               ->with('error', 'Yazınızı oluşturmak istiyorsanız lütfen kayıt olunuz veya giriş yapınız!');
    }
    return view('create-post');
})->name('user.create-post');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my-posts');

