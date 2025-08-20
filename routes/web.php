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

// Yazı oluşturma (giriş yapmış kullanıcı için) - ÖNEMLİ: Bu önce olmalı!
Route::get('/posts/create', function () {
    return view('create-post');
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

Route::get('/create-post', function () {
    return view('create-post');
});

// register / login sayfası //
Route::get('/user-register', function () {
    return view('user-register');
});
