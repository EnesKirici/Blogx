<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController; 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
PostController


// Admin Routes (Laravel 11/12 style)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/posts', [AdminController::class, 'posts'])->name('admin.posts');
    Route::delete('/admin/posts/{id}', [AdminController::class, 'deletePost'])->name('admin.posts.delete');
    Route::post('/admin/posts/{id}/toggle-status', [AdminController::class, 'togglePostStatus'])->name('admin.posts.toggle-status');
});

// Ana sayfa
Route::get('/', [HomeController::class, 'index'])->name('index');


//APİ route
Route::get('/api/tags', [HomeController::class, 'getTags'])->name('api.tags');

// TEK BLOG GÖRÜNÜMÜ (DİNAMİK)
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Hakkımızda sayfası 
Route::get('/hakkimizda', [HomeController::class, 'about'])->name('about');

// BLOG DÜZENLEME
Route::get('/posts/{slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{slug}', [PostController::class, 'update'])->name('posts.update');

// YORUM SİSTEMİ
Route::post('/posts/{slug}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// BEĞENİ SİSTEMİ 
Route::post('/posts/{slug}/like', [PostController::class, 'like'])->name('posts.like');

// KULLANICI PROFİLİ
Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my-posts');

// post silme
Route::delete('/posts/{slug}', [PostController::class, 'destroy'])->name('posts.destroy');

// Kullanıcı profil güncelleme
Route::post('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.update-profile');


// Auth Routes
Route::get('/kullanici-olustur', [RegisterController::class, 'show'])->name('user.register');
Route::post('/kullanici-olustur', [RegisterController::class, 'register']);

Route::get('/kullanici-giris', [LoginController::class, 'show'])->name('user.login');
Route::post('/kullanici-giris', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::post('/posts', [PostController::class, 'store'])->name('posts.store');


// Post Routes
Route::get('/post-olustur', function () {
    if (!Auth::check()) {
        return redirect('/')
               ->with('error', 'Yazınızı oluşturmak istiyorsanız lütfen kayıt olunuz veya giriş yapınız!');
    }
    return view('create-post');
})->name('user.create-post');