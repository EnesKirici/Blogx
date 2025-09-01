<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Blog Sitesi')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* GLOBAL DARK THEME  */
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important;
            min-height: 100vh;
            color: #e0e0e0 !important;
        }
        
        /* Blog Posts - Dark Theme */
        .blog-post {
            background: rgba(45, 45, 45, 0.95) !important;
            border: 1px solid #555 !important;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .blog-post:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            border-color: #dc3545!important;
        }
        
        .post-meta {
            color: #b0b0b0 !important;
            font-size: 0.9em;
        }
        
        .reaction-bar {
            border-top: 1px solid #555 !important;
            padding-top: 15px;
            margin-top: 20px;
        }
        
        .comment-section {
            background: rgba(30, 30, 30, 0.9) !important;
            border: 1px solid #444;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .nested-comment {
            margin-left: 30px;
            padding-left: 15px;
            border-left: 3px solid #66a3ff;
        }
        
        /* Cards & Alerts Dark Theme */
        .card {
            background: rgba(45, 45, 45, 0.95) !important;
            border: 1px solid #555 !important;
            color: #e0e0e0 !important;
        }
        
        .alert {
            background: rgba(45, 45, 45, 0.95) !important;
            border: 1px solid #555 !important;
            color: #e0e0e0 !important;
        }
        
        /* Text Colors */
        h1, h2, h3, h4, h5, h6 {
            color: #ffffff !important;
        }
        
        .text-muted {
            color: #b0b0b0 !important;
        }
        
        /* Badges */
        .badge.bg-secondary {
            background: linear-gradient(135deg, #4a90e2, #357abd) !important;
            color: white !important;
        }
        
        /* Buttons */
        .btn-outline-danger:hover {
            background: #dc3545 !important;
            border-color: #dc3545 !important;
        }
        
        /* Tag Dropdown Styles */
        .tag-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .tag-dropdown-content {
            display: none;
            position: absolute;
            background: rgba(30, 30, 30, 0.98);
            min-width: 280px;
            max-height: 400px;
            overflow-y: auto;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            border: 1px solid #555;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            top: 100%;
            left: 0;
        }
        
        .tag-dropdown-content.show {
            display: block;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .tag-item {
            color: #e0e0e0;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            justify-content: between;
            align-items: center;
            border-bottom: 1px solid #444;
            transition: all 0.3s ease;
        }
        
        .tag-item:hover {
            background: rgba(102, 163, 255, 0.2);
            color: #66a3ff;
            text-decoration: none;
        }
        
        .tag-count {
            background: #4a90e2;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            margin-left: auto;
        }
        
        /* Footer Dark */
        footer {
            background: linear-gradient(135deg, #000000, #2d2d2d) !important;
            border-top: 1px solid #444;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: #e0e0e0 !important;
        }
        
        /* Forms */
        .form-control {
            background: rgba(45, 45, 45, 0.9) !important;
            border: 1px solid #555 !important;
            color: #e0e0e0 !important;
        }
        
        .form-control:focus {
            background: rgba(45, 45, 45, 0.95) !important;
            border-color: #66a3ff !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 163, 255, 0.25) !important;
            color: #e0e0e0 !important;
        }
        
        .form-control::placeholder {
            color: #888 !important;
            
        }
       .bg-dark {
        background: linear-gradient(135deg, #000000, #2d2d2d) !important;
        border-top: 1px solid #444;
        }
        .navbar-dark .navbar-brand,
        .navbar-dark .navbar-nav .nav-link{
                color:#e0e0e0 !important;
                transition: all 0.3s ease;
        }

        .navbar-dark .navbar-brand:hover,
        .navbar-dark .navbar-nav .nav-link:hover{
                color:#dc3545 !important;
                text-shadow: 0 0 8px rgba(255,77,77,0.6);
                }

        .dropdown-item:hover{
            color:#dc3545 !important;
            transition: all 0.5s ease;
            
        }
        
        .form-control:hover,
        .form-control:focus
        {
            border-color: #dc3545 !important;
            box-shadow: 0 0 8px rgba(255,77,77,0.6) !important;
        }

              

    </style>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-blog me-2"></i>Blog Sitesi
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">
                            <i class="fas fa-home me-1"></i>Ana Sayfa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">
                            <i class="fas fa-newspaper me-1"></i>Tüm Yazılar
                        </a>
                    </li>
                    <!-- TAG DROPDOWN (YENİ) -->
                    <li class="nav-item tag-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tagDropdown" role="button">
                            <i class="fas fa-tags me-1"></i>Kategoriler
                        </a>
                        <div class="tag-dropdown-content" id="tagDropdownContent">
                            <div class="p-3 border-bottom" style="border-color: #555 !important;">
                                <h6 class="text-white mb-0">
                                    <i class="fas fa-tags me-2"></i>Blog Etiketleri
                                </h6>
                                <small class="text-muted">Konulara göre filtrele</small>
                            </div>
                            <div id="tagsList">
                                <!-- Dinamik olarak doldurulacak -->
                                <div class="text-center p-4">
                                    <i class="fas fa-spinner fa-spin text-primary"></i>
                                    <p class="text-muted mt-2 mb-0">Etiketler yükleniyor...</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i>Hakkımızda
                        </a>
                    </li>
                </ul>
                
                <!-- Arama Kutusu -->
                <form class="d-flex me-3" method="GET" action="{{ url('/') }}">
                    <div class="input-group">
                        <input class="form-control" type="search" name="search" 
                            placeholder="Blog ara..." 
                            value="{{ request('search') }}" 
                             aria-label="Search">
                        <button class="btn btn-outline-danger" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Giriş Yap
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.register') }}">
                                <i class="fas fa-user-plus me-1"></i>Kayıt Ol
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.create-post')}}">
                                    <i class="fas fa-plus me-1"></i>Yeni Yazı
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('posts.my-posts') }}">
                                    <i class="fas fa-edit me-1"></i>Profil/Yazılarım
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-1"></i>Çıkış Yap
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav> 

    <!-- Main Content -->
    <main class="container mt-4">
        <!-- Flash Messages Container -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Başarılı!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Hata!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Bilgi!</strong> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Hata!</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3 mt-5">
        <p>&copy; 2025 Blog Sitesi. Tüm hakları saklıdır.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Tag Dropdown JavaScript bölümünü değiştir -->
    <script>
        // Tag dropdown toggle
        document.getElementById('tagDropdown').addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = document.getElementById('tagDropdownContent');
            dropdown.classList.toggle('show');
            
            // İlk açılışta etiketleri yükle
            if (dropdown.classList.contains('show') && !dropdown.dataset.loaded) {
                loadTags();
                dropdown.dataset.loaded = 'true';
            }
        });

        // Dışarı tıklayınca kapat
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('tagDropdownContent');
            const trigger = document.getElementById('tagDropdown');
            
            if (!trigger.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Basit etiketleri AJAX ile yükle
        function loadTags() {
            fetch('/api/tags')
                .then(response => response.json())
                .then(data => {
                    const tagsList = document.getElementById('tagsList');
                    
                    if (data.tags && data.tags.length > 0) {
                        let tagsHTML = '';
                        data.tags.forEach(tag => {
                            tagsHTML += `
                                <a href="/?tag=${encodeURIComponent(tag.name)}" class="tag-item">
                                    <span>
                                        <i class="fas fa-hashtag me-2" style="color: #4a90e2;"></i>
                                        ${tag.name}
                                    </span>
                                    <span class="tag-count">${tag.count}</span>
                                </a>
                            `;
                        });
                        tagsList.innerHTML = tagsHTML;
                    } else {
                        tagsList.innerHTML = `
                            <div class="text-center p-4">
                                <i class="fas fa-tags fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Henüz etiket bulunmuyor</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Etiketler yüklenirken hata:', error);
                    document.getElementById('tagsList').innerHTML = `
                        <div class="text-center p-4">
                            <i class="fas fa-exclamation-triangle text-warning mb-3"></i>
                            <p class="text-muted mb-0">Etiketler yüklenemedi</p>
                            <small class="text-muted">Hata: ${error.message}</small>
                        </div>
                    `;
                });
        }
    </script>
    
    @yield('scripts')
</body>
</html>