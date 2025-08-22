@extends('layouts.app')

@section('title', 'Ana Sayfa - Blog Sitesi')

@section('content')
<div class="row">
    <!-- Hero Section -->
    <div class="col-12 mb-4">
        <div class="bg-secondary text-white p-4 rounded">
            <h1 class="display-4">Hoş Geldiniz! 👋</h1>
            <p class="lead">En güncel blog yazılarını keşfedin, kendi deneyimlerinizi paylaşın.</p>
            <a href="/posts" class="btn btn-light btn-lg">
                <i class="fas fa-book-reader me-2"></i>Yazıları Keşfet
            </a>
        </div>
    </div>

    <!-- Arama Sonuçları Bilgisi -->
    @if($search)
    <div class="col-12 mb-3">
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-search me-2"></i>
                "<strong>{{ $search }}</strong>" araması için {{ $posts->count() }} sonuç bulundu
            </div>
            <a href="{{ url('/') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-times me-1"></i>Aramayı Temizle
            </a>
        </div>
    </div>
    @endif

    <!-- Dynamic Blog Posts -->
    <div class="col-12">
        <h2 class="mb-4">
            @if($search)
                <i class="fas fa-search me-2 text-primary"></i>Arama Sonuçları
            @else
                <i class="fas fa-fire me-2 text-danger"></i>Son Yazılar
            @endif
        </h2>
        
        @forelse($posts as $post)
        <!-- Blog Post (Dynamic) -->
        <article class="blog-post">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="flex-grow-1 me-3">
                    <h3 class="h4 mb-2">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">
                            <!-- Arama kelimesini vurgula -->
                            @if($search)
                                {!! str_ireplace($search, '<mark>' . $search . '</mark>', $post->title) !!}
                            @else
                                {{ $post->title }}
                            @endif
                        </a>
                    </h3>
                    <div class="post-meta mb-3">
                        <i class="fas fa-user me-1"></i>{{ $post->user->name }} {{ $post->user->surname }}
                        <i class="fas fa-calendar ms-3 me-1"></i>{{ $post->published_at->format('d M Y') }}
                    </div>
                    
                    <!-- ÖZET BURADA -->
                    <p class="text-muted mb-2">
                        @if($post->excerpt)
                            @if($search)
                                {!! str_ireplace($search, '<mark>' . $search . '</mark>', $post->excerpt) !!}
                            @else
                                {{ $post->excerpt }}
                            @endif
                        @else
                            @php
                                $contentPreview = \Illuminate\Support\Str::limit(strip_tags($post->content), 200);
                            @endphp
                            @if($search)
                                {!! str_ireplace($search, '<mark>' . $search . '</mark>', $contentPreview) !!}
                            @else
                                {{ $contentPreview }}
                            @endif
                        @endif
                    </p>
                    
                    <!-- İÇERİK İÇİN TIKLAYIN YAZISI -->
                    <div class="mb-3">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-primary text-decoration-none">
                            <i class="fas fa-arrow-right me-1"></i>
                            <small><strong>İçerik için tıklayın →</strong></small>
                        </a>
                    </div>
                </div>
                    
                <!-- RESİM SAĞ TARAFTA -->
                <div class="flex-shrink-0">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" 
                    class="rounded" style="width: 200px; height: 150px; object-fit: cover;">
                    @else
                    <img src="https://via.placeholder.com/200x150?text=Blog&bg=6c757d&color=ffffff" 
                    alt="Default" class="rounded" style="width: 200px; height: 150px; object-fit: cover;">
                    @endif
                </div>
            </div>
            
            <!-- ETIKETLER (ALTTA) -->
            @if($post->tags && count($post->tags) > 0)
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach($post->tags as $tag)
                    <span class="badge bg-secondary">{{ $tag }}</span>
                @endforeach
            </div>
            @endif
            
            <!-- REACTION BAR EN ALTTA -->
            <div class="reaction-bar d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-heart me-1"></i>{{ $post->likes_count }} Beğeni
                    </button>
                    <button class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-comment me-1"></i>{{ $post->comments_count }} Yorum
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
                    
                    <!-- Sadece yazarın kendisi düzenleyebilir -->
                    @auth
                        @if($post->user_id === auth()->id())
                        <a href="/posts/{{ $post->slug }}/edit" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-edit me-1"></i>Düzenle
                        </a>
                        @endif
                    @endauth
                </div>
                <small class="text-muted">
                    <i class="fas fa-eye me-1"></i>{{ $post->views_count }} görüntüleme
                </small>
            </div>
        </article>
        @empty
        
        <!-- Sonuç bulunamadı -->
        <div class="text-center py-5">
            @if($search)
                <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">"{{ $search }}" için sonuç bulunamadı</h4>
                <p class="text-muted">Farklı kelimeler deneyebilir veya tüm yazıları görüntüleyebilirsiniz.</p>
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-list me-2"></i>Tüm Yazıları Gör
                </a>
            @else
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Henüz blog yazısı yok</h4>
                <p class="text-muted">İlk yazıyı siz yazın ve topluluğumuzla paylaşın!</p>
                @auth
                    <a href="{{ route('user.create-post') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>İlk Yazıyı Yaz
                    </a>
                @else
                    <a href="{{ route('user.register') }}" class="btn btn-success btn-lg me-2">
                        <i class="fas fa-user-plus me-2"></i>Kayıt Ol
                    </a>
                    <a href="{{ route('user.login') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                    </a>
                @endauth
            @endif
        </div>
        @endforelse

        <!-- Alt Butonlar -->
        @if(!$search)
        <div class="text-center mt-5 mb-4">
            <h4>Siz de yazı paylaşmak ister misiniz?</h4>
            <p class="text-muted">Bilgilerinizi topluluğumuzla paylaşın ve deneyimlerinizi aktarın.</p>
            
            @auth
                <a href="{{ route('user.create-post') }}" class="btn btn-outline-success btn-lg me-3">
                    <i class="fas fa-plus me-2"></i>Yeni Yazı Oluştur
                </a>
                <a href="{{ route('posts.my-posts') }}" class="btn btn-outline-info btn-lg me-3">
                    <i class="fas fa-list me-2"></i>Yazılarım
                </a>
            @else
                <a href="{{ route('user.register') }}" class="btn btn-outline-primary btn-lg me-3">
                    <i class="fas fa-user-plus me-2"></i>Hemen Kayıt Ol
                </a>
                <a href="{{ route('user.login') }}" class="btn btn-outline-success btn-lg me-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                </a>
            @endauth
            
            <a href="/posts" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-list me-2"></i>Tüm Yazıları Gör
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
