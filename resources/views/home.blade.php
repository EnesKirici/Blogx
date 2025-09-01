@php 
use Illuminate\Support\Facades\DB;
@endphp

@extends('layouts.app')

@section('title', 'Ana Sayfa - Blog Sitesi')

@section('content')


<style>
    .text-decoration-none{
        color: white;
    }
        .text-decoration-none:hover{
        color: #dc3545 !important;
        transition: all 0.5s ease;
        }
    .text-primary{
        color: white;
    }


</style>
    <!-- Arama/Filtreleme Sonuçları Bilgisi -->
    @if(!empty($search) || !empty($selectedTag))
    <div class="col-12 mb-3">
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <div>
                @if(!empty($search) && !empty($selectedTag))
                    <i class="fas fa-search me-2"></i>
                    "<strong>{{ $search }}</strong>" araması ve "<strong>{{ $selectedTag }}</strong>" etiketi için {{ isset($posts) && $posts ? count($posts) : 0 }} sonuç bulundu
                @elseif(!empty($search))
                    <i class="fas fa-search me-2"></i>
                    "<strong>{{ $search }}</strong>" araması için {{ isset($posts) && $posts ? count($posts) : 0 }} sonuç bulundu
                @elseif(!empty($selectedTag))
                    <i class="fas fa-tag me-2"></i>
                    "<strong>{{ $selectedTag }}</strong>" etiketli {{ isset($posts) && $posts ? count($posts) : 0 }} yazı
                @endif
            </div>
            <a href="{{ url('/') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-times me-1"></i>Filtreleri Temizle
            </a>
        </div>
    </div>
    @endif

    <!-- Dynamic Blog Posts -->
    <div class="col-12">
        <h2 class="mb-4">
            @if(!empty($search))
                <i class="fas fa-search me-2 text-primary"></i>Arama Sonuçları
            @elseif(!empty($selectedTag))
                <i class="fas fa-hashtag me-2 text-warning"></i>{{ $selectedTag }} Etiketli Yazılar
            @else
                <i class="fas fa-fire me-2 text-danger"></i>Son Yazılar
            @endif
        </h2>
        
        @forelse($posts ?? [] as $post)
        <!-- Blog Post (Dynamic) -->
        <article class="blog-post">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="flex-grow-1 me-3">
                    <h3 class="h4 mb-2">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">
                            <!-- Arama kelimesini vurgula -->
                            @if(!empty($search))
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
                            @if(!empty($search))
                                {!! str_ireplace($search, '<mark>' . $search . '</mark>', $post->excerpt) !!}
                            @else
                                {{ $post->excerpt }}
                            @endif
                        @else
                            @php
                                $contentPreview = \Illuminate\Support\Str::limit(strip_tags($post->content), 200);
                            @endphp
                            @if(!empty($search))
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
                    class="rounded" style="width: 250px; height: 150px; object-fit: cover;">
                    @else
                    <img src="https://via.placeholder.com/200x150?text=Blog&bg=6c757d&color=ffffff" 
                    alt="Default" class="rounded" style="width: 200px; height: 150px; object-fit: cover;">
                    @endif
                </div>
            </div>  

                

            <!-- ETIKETLER - BASİT VERSİYON -->
            @php
                $postTags = DB::table('post_tags')
                             ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
                             ->where('post_tags.post_id', $post->id)
                             ->select('tags.name')
                             ->get();
            @endphp
            
            @if($postTags->count() > 0)
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach($postTags as $tag)
                    <a href="/?tag={{ urlencode($tag->name) }}" 
                       class="badge bg-dark text-light text-decoration-none rounded-pill px-3 py-2">
                        <i class="fas fa-hashtag me-1"></i>{{ $tag->name }}
                    </a>
                @endforeach
            </div>
            @endif

            <!-- REACTION BAR EN ALTTA -->
            <div class="reaction-bar d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3">
                    <!-- Beğeni Butonu (AJAX) -->
                    @auth
                        <button class="btn btn-outline-danger btn-sm like-btn" 
                                data-slug="{{ $post->slug }}"
                                data-liked="{{ $post->isLikedBy(auth()->user()) ? 'true' : 'false' }}">
                            <i class="fas fa-heart me-1"></i>
                            <span class="likes-count">{{ $post->likes_count }}</span> Beğeni
                        </button>
                    @else
                        <a href="{{ route('user.login') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-heart me-1"></i>{{ $post->likes_count }} Beğeni
                        </a>
                    @endauth
                    
                    <a href="{{ route('posts.show', $post->slug) }}#comments"
                        class="btn btn-outline-primary btn-sm"
                        aria-label="Yorumlara git">
                            <i class="fas fa-comment me-1"></i>
                            {{ $post->comments_count }} Yorum
                        </a>     

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
            @if(!empty($search))
                <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">"{{ $search }}" için sonuç bulunamadı</h4>
            @elseif(!empty($selectedTag))
                <i class="fas fa-hashtag fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">"{{ $selectedTag }}" etiketli yazı bulunamadı</h4>
            @else
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Henüz blog yazısı yok</h4>
            @endif
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-list me-2"></i>Tüm Yazıları Gör
            </a>
        </div>
        @endforelse

        <!-- Alt Butonlar -->
        @if(!isset($search)|| !$search)
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
            
            <a href="/index" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-list me-2"></i>Tüm Yazıları Gör
            </a>
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Beğeni butonları için AJAX
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const slug = this.dataset.slug;
            const liked = this.dataset.liked === 'true';
            
            // Butonu devre dışı bırak (çift tıklama önlemi)
            this.disabled = true;
            
            fetch(`/posts/${slug}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Beğeni durumuna göre buton stilini değiştir
                if (data.liked) {
                    // Beğenildi - Kırmızı yap
                    this.classList.remove('btn-outline-danger');
                    this.classList.add('btn-danger');
                    this.dataset.liked = 'true';
                } else {
                    // Beğeni kaldırıldı - Outline yap
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-outline-danger');
                    this.dataset.liked = 'false';
                }
                
                // Beğeni sayısını güncelle
                this.querySelector('.likes-count').textContent = data.likes_count;
                
                // Success feedback (opsiyonel)
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            // Hata durumunda kullanıcıya feedback
            this.style.backgroundColor = '#dc3545';
            setTimeout(() => {
                this.style.backgroundColor = '';
            }, 1000);
        })
        .finally(() => {
            // Butonu tekrar aktif et
            this.disabled = false;
        });
    });
});
</script>
@endsection
