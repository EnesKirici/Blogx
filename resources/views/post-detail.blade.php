@extends('layouts.app')

@section('title', 'Blog Detayı ')

@section('content')

<style>
    .btn-xx{
        background-color: #3d040a !important;
        border-color: #3d040a !important;
        border: none;
    }
    .btn-xx:hover{
        box-shadow: #dc3545 0 0 8px;
        transform: translateY(-3px);
        transition: all 0.3s ease;
        background-color: #3d040a !important;
    }
</style>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Blog Post (Dynamic) -->
        <article class="blog-post">
            <!-- Post Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="post-meta">
                    <i class="fas fa-user me-1"></i>{{ $post->user->name }} {{ $post->user->surname }}
                    <i class="fas fa-calendar ms-3 me-1"></i>{{ $post->published_at->format('d M Y') }}
                    <i class="fas fa-clock ms-3 me-1"></i>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} dakika okuma
                    <i class="fas fa-eye ms-3 me-1"></i>{{ $post->views_count }} görüntüleme
                </div>
                
                <!-- Edit/Delete buttons for post owner -->
                @auth
                    @if($post->user_id === auth()->id())
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('posts.edit', $post->slug) }}">
                                <i class="fas fa-edit me-1"></i>Düzenle
                            </a></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="deletePost('{{ $post->slug }}')">
                                <i class="fas fa-trash me-1"></i>Sil
                            </a></li>
                        </ul>
                    </div>
                    @endif
                @endauth
            </div>

            <h1 class="h2 mb-3">{{ $post->title }}</h1>
            
            <!-- Featured Image -->
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" 
                     class="rounded mb-4" style="width: 100%; height: 400px; object-fit: cover;">
            @else
                <img src="https://via.placeholder.com/800x400?text={{ urlencode($post->title) }}&bg=6c757d&color=ffffff" 
                     alt="{{ $post->title }}" class="rounded mb-4" style="width: 100%; height: 400px; object-fit: cover;">
            @endif
            
            <!-- Tags -->
            @if($post->tags && count($post->tags) > 0)
            <div class="d-flex flex-wrap gap-2 mb-4">
                @foreach($post->tags as $tag)
                    <span class="badge bg-secondary">{{ $tag }}</span>
                @endforeach
            </div>
            @endif

            <!-- Excerpt -->
            @if($post->excerpt)
            <p class="lead">
                {{ $post->excerpt }}
            </p>
            @endif
            
            <!-- Post Content -->
            <div class="post-content">
                {!! nl2br(e($post->content)) !!}
            </div>
            
            <!-- Reaction Bar (DİNAMİK BEĞENİLER) -->
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
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-share me-1"></i>Paylaş
                    </button>
                </div>
            </div>
        </article>

        <!-- Comments Section (DİNAMİK YORUMLAR) -->
        @if($post->allow_comments)
        <div class="comment-section mt-4">
            
            
            <!-- Add Comment Form -->
            @auth
            @else
            <div class="text-center mb-4">
                <p class="text-muted">Yorum yapmak için giriş yapmalısınız.</p>
                <a href="{{ route('user.login') }}" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-1"></i>Giriş Yap
                </a>
            </div>
            @endauth
            
            <!-- Comments List -->
            <div class="comments-section">
                <h4 class="mb-4">
                    <i class="fas fa-comments me-2"></i>Yorumlar ({{ $post->comments->count() }})
                </h4>
                
                @forelse($post->comments as $comment)
                <div class="comment-item mb-4 p-3 rounded" style="background-color: rgba(45, 45, 45, 0.8); border-left: 4px solid #dc3545;">
                    <div class="d-flex align-items-start">
                        <!-- Profil Fotoğrafı -->
                        <div class="me-3">
                            @if($comment->user->profile_photo)
                                <img src="{{ asset('storage/' . $comment->user->profile_photo) }}" 
                                     alt="{{ $comment->user->name }}" 
                                     class="rounded-circle" 
                                     style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #dc3545;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; border: 2px solid #dc3545;">
                                    <i class="fas fa-user text-light"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Yorum İçeriği -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong class="text-light">{{ $comment->user->name }} {{ $comment->user->surname }}</strong>
                                    <small class="text-muted ms-2">
                                        <i class="fas fa-clock me-1"></i>{{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->id() === $post->user_id))
                                <button class="btn btn-outline-danger btn-sm" 
                                        onclick="deleteComment({{ $comment->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                            
                            <p class="text-light mb-0">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-comment-slash fa-2x text-muted mb-3"></i>
                    <p class="text-muted">Henüz yorum yapılmamış. İlk yorumu siz yapın!</p>
                </div>
                @endforelse
            </div>

            <!-- Yorum Yapma Formu -->
            @auth
            <div class="comment-form mt-5">
                <h5 class="mb-3">
                    <i class="fas fa-pen me-2"></i>Yorum Yap
                </h5>
                
                <form action="{{ route('comments.store', ['slug'=>$post->slug]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    
                    <div class="d-flex align-items-start">
                        <!-- Yorum Yapan Kullanıcının Profil Fotoğrafı -->
                        <div class="me-3">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="rounded-circle" 
                                     style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #dc3545;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; border: 2px solid #dc3545;">
                                    <i class="fas fa-user text-light"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Yorum Input Alanı -->
                        <div class="flex-grow-1">
                            <div class="mb-3">
                                <textarea class="form-control bg-dark text-light border-secondary" 
                                          name="content" 
                                          rows="5" 
                                          placeholder="Düşüncelerinizi paylaşın..." 
                                          required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger btn-xx">
                                <i class="fas fa-paper-plane me-2"></i>Yorum Gönder
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @else
            <div class="text-center py-4 border rounded bg-dark">
                <i class="fas fa-sign-in-alt fa-2x text-muted mb-3"></i>
                <p class="text-muted mb-3">Yorum yapabilmek için giriş yapmanız gerekiyor.</p>
                <a href="{{ route('user.login') }}" class="btn btn-outline-danger">
                    <i class="fas fa-sign-in-alt me-2"></i>Giriş Yap
                </a>
            </div>
            @endauth
        </div>
        @endif
        
        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
        <div class="mt-5">
            <h4 class="mb-3">
                <i class="fas fa-bookmark me-2"></i>İlgili Yazılar
            </h4>
            <div class="row">
                @foreach($relatedPosts as $relatedPost)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        @if($relatedPost->featured_image)
                            <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                 class="card-img-top" alt="{{ $relatedPost->title }}" 
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/350x200?text={{ urlencode($relatedPost->title) }}&bg=6c757d&color=ffffff" 
                                 class="card-img-top" alt="{{ $relatedPost->title }}"
                                 style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{ \Illuminate\Support\Str::limit($relatedPost->title, 50) }}</h6>
                            <p class="card-text small text-muted">
                                {{ \Illuminate\Support\Str::limit($relatedPost->excerpt ?? strip_tags($relatedPost->content), 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $relatedPost->published_at->diffForHumans() }}</small>
                                <a href="{{ route('posts.show', $relatedPost->slug) }}" class="btn btn-primary btn-sm">Oku</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Geri Dön Butonu -->
        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Ana Sayfaya Dön
            </a>
        </div>
    </div>
</div>

@section('scripts')
<script>
function deletePost(slug) {
    if(confirm('Bu yazıyı silmek istediğinizden emin misiniz?')) {
        fetch(`/posts/${slug}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Yazı başarıyla silindi!');
                window.location.href = '/my-posts'; // Yazılarım sayfasına yönlendir
            } else {
                alert('Hata: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu!');
        });
    }
}

// Beğeni AJAX
document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', function() {
        const slug = this.dataset.slug;
        const liked = this.dataset.liked === 'true';
        
        fetch(`/posts/${slug}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Buton stilini güncelle
                if (data.liked) {
                    this.classList.remove('btn-outline-danger');
                    this.classList.add('btn-danger');
                    this.dataset.liked = 'true';
                } else {
                    this.classList.remove('btn-danger');
                    this.classList.add('btn-outline-danger');
                    this.dataset.liked = 'false';
                }
                
                // Beğeni sayısını güncelle
                this.querySelector('.likes-count').textContent = data.likes_count;
                
                // Toast mesajı (opsiyonel)
                console.log(data.message);
            }
        })
        .catch(error => {
            console.error('Hata:', error);
        });
    });
});
</script>
@endsection

<style>
    /* Yorum stilleri */
    .comment-item {
        transition: all 0.3s ease;
        border: 1px solid rgba(220,53,69,0.2);
    }

    .comment-item:hover {
        background-color: rgba(55, 55, 55, 0.9) !important;
        transform: translateX(5px);
        border-color: rgba(220,53,69,0.5);
    }

    .comment-form textarea:focus {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }

    /* Profil fotoğrafı hover efekti */
    .comment-item img:hover,
    .comment-form img:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
</style>

@endsection
