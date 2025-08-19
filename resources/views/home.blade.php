@extends('layouts.app')

@section('title', 'Ana Sayfa - Blog Sitesi')

@section('content')
<div class="row">
    <!-- Hero Section -->
    <div class="col-12 mb-4">
        <div class="bg-primary text-white p-4 rounded">
            <h1 class="display-4">Hoş Geldiniz! 👋</h1>
            <p class="lead">En güncel blog yazılarını keşfedin, kendi deneyimlerinizi paylaşın.</p>
            <a href="/posts" class="btn btn-light btn-lg">
                <i class="fas fa-book-reader me-2"></i>Yazıları Keşfet
            </a>
        </div>
    </div>

    <!-- Sample Blog Posts -->
    <div class="col-12">
        <h2 class="mb-4">
            <i class="fas fa-fire me-2 text-danger"></i>Popüler Yazılar
        </h2>
        
        <!-- Blog Post 1 -->
        <article class="blog-post">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h3 class="h4 mb-2">
                        <a href="/posts/1" class="text-decoration-none">Laravel ile Modern Web Geliştirme</a>
                    </h3>
                    <div class="post-meta">
                        <i class="fas fa-user me-1"></i>Ahmet Yılmaz
                        <i class="fas fa-calendar ms-3 me-1"></i>15 Ağustos 2025
                        <i class="fas fa-clock ms-3 me-1"></i>5 dakika okuma
                    </div>
                </div>
                <img src="https://via.placeholder.com/100x70" alt="Laravel" class="rounded">
            </div>
            
            <p class="text-muted">
                Laravel framework'ü ile modern web uygulamaları geliştirmenin inceliklerini öğrenin. 
                MVC mimarisi, Eloquent ORM ve Blade template engine gibi konular...
            </p>
            
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-secondary">Laravel</span>
                <span class="badge bg-secondary">PHP</span>
                <span class="badge bg-secondary">Web Development</span>
            </div>
            
            <div class="reaction-bar d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-heart me-1"></i># Beğeni
                    </button>
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-comment me-1"></i># Yorum
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-warning btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-smile me-1"></i>Tepki
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">👍 Süper</a></li>
                            <li><a class="dropdown-item" href="#">❤️ Harika</a></li>
                            <li><a class="dropdown-item" href="#">😂 Komik</a></li>
                            <li><a class="dropdown-item" href="#">😮 Şaşırtıcı</a></li>
                        </ul>
                    </div>
                </div>
                <small class="text-muted">
                    <i class="fas fa-eye me-1"></i>## görüntüleme
                </small>
            </div>
        </article>

        <!-- Blog Post 2 -->
        <article class="blog-post">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h3 class="h4 mb-2">
                        <a href="/posts/2" class="text-decoration-none">JavaScript ES6+ Özellikleri</a>
                    </h3>
                    <div class="post-meta">
                        <i class="fas fa-user me-1"></i>Zeynep Kaya
                        <i class="fas fa-calendar ms-3 me-1"></i>12 Ağustos 2025
                        <i class="fas fa-clock ms-3 me-1"></i>7 dakika okuma
                    </div>
                </div>
                <img src="https://via.placeholder.com/100x70" alt="JavaScript" class="rounded">
            </div>
            
            <p class="text-muted">
                Modern JavaScript'in sunduğu arrow functions, destructuring, async/await gibi 
                güçlü özellikleri pratik örneklerle keşfedin...
            </p>
            
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge bg-warning text-dark">JavaScript</span>
                <span class="badge bg-warning text-dark">ES6+</span>
                <span class="badge bg-warning text-dark">Frontend</span>
            </div>
            
            <div class="reaction-bar d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-heart me-1"></i># Beğeni
                    </button>
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-comment me-1"></i># Yorum
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-warning btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-smile me-1"></i>Tepki
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">👍 Süper</a></li>
                            <li><a class="dropdown-item" href="#">❤️ Harika</a></li>
                            <li><a class="dropdown-item" href="#">😂 Komik</a></li>
                            <li><a class="dropdown-item" href="#">😮 Şaşırtıcı</a></li>
                        </ul>
                    </div>
                </div>
                <small class="text-muted">
                    <i class="fas fa-eye me-1"></i>## görüntüleme
                </small>
            </div>
        </article>

        <!-- Call to Action -->
        <div class="text-center mt-5 mb-4">
            <h4>Siz de yazı paylaşmak ister misiniz?</h4>
            <p class="text-muted">Bilgilerinizi topluluğumuzla paylaşın ve deneyimlerinizi aktarın.</p>
            <a href="/posts/create" class="btn btn-success btn-lg me-3">
                <i class="fas fa-plus me-2"></i>Yeni Yazı Oluştur
            </a>
            <a href="/register" class="btn btn-primary btn-lg me-3">
                <i class="fas fa-user-plus me-2"></i>Hemen Kayıt Ol
            </a>
            <a href="/posts" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-list me-2"></i>Tüm Yazıları Gör
            </a>
        </div>
    </div>
</div>
@endsection
