@php
use Illuminate\Support\Facades\DB;
@endphp

@extends('layouts.app')

@section('title', 'Yazılarım - Blog Sitesi')

@section('content')

<style> 
.profile-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,0.3);
    object-fit: cover;
}

.stats-card {
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 1rem;
    backdrop-filter: blur(10px);
}

.my-post-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 2rem;
}


.post-status {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10;
}

.badge.bg-dark:hover {
    background-color: #333 !important;
    color: #fff !important;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.4);
    transition: all 0.3s ease;
}

.badge.bg-dark:hover {
  background-color: #333 !important;
  color: #fff !important;
  box-shadow: 0 0 8px rgba(255, 255, 255, 0.4); /* beyaz parıltı */
  transition: all 0.3s ease;
}

    a.text-decoration-none{
    color:white !important;
    }
    a.text-decoration-none:hover{
        color: #dc3545 !important;
        text-shadow: 0 0 8px rgba(255,77,77,0.6);
        transition: all 0.3s ease;
        }
    .my-post-card {
    border: 1px solid #555 !important;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    margin-bottom: 2rem;
}

.my-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: #dc3545 !important;
    box-shadow: 0 0 15px rgba(220,53,69,0.4);
}
    
</style>

<!-- Profil Kartı -->
<div class="profile-card">
    <div class="row align-items-center">
        <div class="col-md-3 text-center">
            <div class="profile-avatar bg-white text-dark d-flex align-items-center justify-content-center mx-auto">
                <i class="fas fa-user fa-2x"></i>
            </div>
            <!-- Profil fotoğrafı butonunu şimdilik kaldırdık -->
        </div>
        <div class="col-md-6">
            <h2 class="mb-1">{{ auth()->user()->name }} {{ auth()->user()->surname ?? '' }}</h2>
            <p class="mb-3 opacity-75">{{ auth()->user()->email }}</p>
            <p class="mb-0">Blogger olarak paylaştığınız içeriklerle topluluğumuza katkıda bulunuyorsunuz!</p>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center">
                <h3 class="mb-1">{{ $posts->count() }}</h3>
                <small>Toplam Yazı</small>
            </div>
            <div class="stats-card text-center mt-2">
                <h3 class="mb-1">{{ $posts->where('status', 'published')->count() }}</h3>
                <small>Yayında</small>
            </div>
        </div>
    </div>
</div>

<!-- Sayfa Başlığı ve Aksiyonlar -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-newspaper me-2 text-primary"></i>Yazılarım
    </h2>
    <div>
        <a href="{{ route('user.create-post') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i>Yeni Yazı
        </a>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
            <i class="fas fa-home me-1"></i>Ana Sayfa
        </a>
    </div>
</div>

<!-- Blog Yazıları -->
@forelse($posts as $post)
<div class="card my-post-card">
    <!-- Durum Badge'i -->
    <div class="post-status">
        @if($post->status === 'published')
            <span class="badge bg-success">
                <i class="fas fa-eye me-1"></i>Yayında
            </span>
        @else
            <span class="badge bg-warning text-dark">
                <i class="fas fa-edit me-1"></i>Taslak
            </span>
        @endif
    </div>

    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-8">
                <h4 class="card-title mb-2">
                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">
                        {{ $post->title }}
                    </a>
                </h4>
                
                <div class="text-muted small mb-3">
                    <i class="fas fa-calendar me-1"></i>
                    {{ $post->created_at->format('d M Y') }}
                    @if($post->published_at)
                        • <i class="fas fa-globe me-1"></i>
                        {{ $post->published_at->format('d M Y') }} tarihinde yayınlandı
                    @endif
                </div>

                <p class="card-text text-muted mb-3">
                    {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}
                </p>

                <!-- Etiketler -->
                @php
                    $postTags = DB::table('post_tags')
                                 ->join('tags', 'post_tags.tag_id', '=', 'tags.id')
                                 ->where('post_tags.post_id', $post->id)
                                 ->select('tags.name')
                                 ->get();
                @endphp
                
                @if($postTags->count() > 0)
                <div class="mb-3">
                    @foreach($postTags as $tag)
                        <span class="badge bg-dark text-light me-1">
                            <i class="fas fa-hashtag me-1"></i>{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
                @endif

                <!-- İstatistikler -->
                <div class="d-flex gap-3 text-muted small">
                    <span><i class="fas fa-heart me-1"></i>{{ $post->likes_count }} Beğeni</span>
                    <span><i class="fas fa-comment me-1"></i>{{ $post->comments_count }} Yorum</span>
                    <span><i class="fas fa-eye me-1"></i>{{ $post->views_count }} Görüntüleme</span>
                </div>
            </div>

            <div class="col-md-4 text-end">
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         class="img-fluid rounded mb-3" 
                         style="height: 120px; width: 100%; object-fit: cover;">
                @endif

                <!-- Aksiyon Butonları -->
                <div class="btn-group-vertical w-100">
                    @if($post->status === 'published')
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>Görüntüle
                        </a>
                    @endif
                    
                    <a href="/posts/{{ $post->slug }}/edit" 
                       class="btn btn-outline-success btn-sm">
                        <i class="fas fa-edit me-1"></i>Düzenle
                    </a>
                    
                    <button class="btn btn-outline-danger btn-sm" 
                            onclick="deletePost('{{ $post->slug }}')">
                        <i class="fas fa-trash me-1"></i>Sil
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <i class="fas fa-pen-fancy fa-3x text-muted mb-3"></i>
    <h4 class="text-muted">Henüz hiç yazınız yok</h4>
    <p class="text-muted">İlk blog yazınızı oluşturun ve topluluğumuzla paylaşın!</p>
    <a href="{{ route('user.create-post') }}" class="btn btn-success btn-lg">
        <i class="fas fa-plus me-2"></i>İlk Yazımı Oluştur
    </a>
</div>
@endforelse

@endsection

@section('scripts')
<script>
function deletePost(slug) {
    if (confirm('Bu yazıyı silmek istediğinizden emin misiniz?')) {
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
                location.reload();
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
</script>
@endsection
