<?php

use Illuminate\Support\Facades\Route;

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

// Yazı oluşturma (giriş yapmış kullanıcı için)
Route::get('/posts/create', function () {
    return view('create-post');
});

// Test sayfaları
Route::get('/home', function () {
    return view('home');
});

Route::get('/post-detail', function () {
    return view('post-detail');
});

Route::get('/create-post', function () {
    return view('create-post');
});
