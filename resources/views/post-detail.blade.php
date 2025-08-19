@extends('layouts.app')

@section('title', 'Laravel ile Modern Web Geliştirme - Blog Sitesi')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Blog Post -->
        <article class="blog-post">
            <!-- Post Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="post-meta">
                    <i class="fas fa-user me-1"></i>Ahmet Yılmaz
                    <i class="fas fa-calendar ms-3 me-1"></i>15 Ağustos 2025
                    <i class="fas fa-clock ms-3 me-1"></i>5 dakika okuma
                    <i class="fas fa-eye ms-3 me-1"></i>1,234 görüntüleme
                </div>
                
                <!-- Edit/Delete buttons for post owner -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/posts/1/edit">
                            <i class="fas fa-edit me-1"></i>Düzenle
                        </a></li>
                        <li><a class="dropdown-item text-danger" href="#" onclick="deletePost()">
                            <i class="fas fa-trash me-1"></i>Sil
                        </a></li>
                    </ul>
                </div>
            </div>

            <h1 class="h2 mb-3">Laravel ile Modern Web Geliştirme</h1>
            
            <!-- Featured Image -->
            <img src="https://via.placeholder.com/800x400" alt="Laravel" class="img-fluid rounded mb-4">
            
            <!-- Tags -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <span class="badge bg-secondary">Laravel</span>
                <span class="badge bg-secondary">PHP</span>
                <span class="badge bg-secondary">Web Development</span>
            </div>
            
            <!-- Post Content -->
            <div class="post-content">
                <p class="lead">
                    Laravel, PHP dünyasının en popüler framework'lerinden biridir. Modern web uygulamaları 
                    geliştirmek için ihtiyacınız olan tüm araçları sunar.
                </p>
                
                <h3>Giriş</h3>
                <p>
                    Web geliştirme dünyası sürekli gelişiyor ve yeni teknolojiler ortaya çıkıyor. 
                    Bu hızlı değişim ortamında, geliştiricilerin işini kolaylaştıran framework'ler 
                    büyük önem kazanıyor. Laravel da bu amaçla ortaya çıkmış ve PHP ekosisteminde 
                    kendine sağlam bir yer edinmiştir.
                </p>
                
                <h3>Laravel'in Avantajları</h3>
                <ul>
                    <li><strong>Eloquent ORM:</strong> Veritabanı işlemlerini basitleştirir</li>
                    <li><strong>Blade Template Engine:</strong> Temiz ve esnek view katmanı</li>
                    <li><strong>Artisan CLI:</strong> Güçlü komut satırı araçları</li>
                    <li><strong>Middleware:</strong> HTTP isteklerini filtreleme</li>
                    <li><strong>Route System:</strong> Esnek URL yönetimi</li>
                </ul>
                
                <h3>Örnek Kod</h3>
                <pre class="bg-light p-3 rounded"><code class="language-php">// Route tanımlama
Route::get('/posts', [PostController::class, 'index']);

// Controller methodu
public function index()
{
    $posts = Post::with('user')->latest()->paginate(10);
    return view('posts.index', compact('posts'));
}</code></pre>
                
                <h3>Sonuç</h3>
                <p>
                    Laravel ile web geliştirme süreci hem daha hızlı hem de daha keyifli hale geliyor. 
                    Modern PHP geliştirme yapacaksanız, Laravel'i mutlaka denemelisiniz.
                </p>
            </div>
            
            <!-- Reaction Bar -->
            <div class="reaction-bar d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-heart me-1"></i>42 Beğeni
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-warning btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-smile me-1"></i>Tepki
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">👍 Süper (15)</a></li>
                            <li><a class="dropdown-item" href="#">❤️ Harika (12)</a></li>
                            <li><a class="dropdown-item" href="#">😂 Komik (3)</a></li>
                            <li><a class="dropdown-item" href="#">😮 Şaşırtıcı (8)</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-share me-1"></i>Paylaş
                    </button>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="comment-section mt-4">
            <h4 class="mb-3">
                <i class="fas fa-comments me-2"></i>Yorumlar (12)
            </h4>
            
            <!-- Add Comment Form -->
            <div class="mb-4">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <textarea class="form-control" rows="3" placeholder="Yorumunuzu yazın..."></textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Markdown desteklenir
                                </small>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i>Yorum Yap
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Comment 1 -->
            <div class="mb-3">
                <div class="d-flex">
                    <img src="https://via.placeholder.com/40x40" alt="User" class="rounded-circle me-3">
                    <div class="flex-grow-1">
                        <div class="bg-white p-3 rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>Mehmet Demir</strong>
                                    <small class="text-muted ms-2">2 saat önce</small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">
                                            <i class="fas fa-reply me-1"></i>Yanıtla
                                        </a></li>
                                        <li><a class="dropdown-item text-danger" href="#">
                                            <i class="fas fa-flag me-1"></i>Şikayet Et
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-2">
                                Harika bir yazı olmuş! Laravel'in Eloquent ORM'ı gerçekten çok pratik. 
                                Ben de projelerimde sıkça kullanıyorum.
                            </p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-heart me-1"></i>5
                                </button>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-reply me-1"></i>Yanıtla
                                </button>
                            </div>
                        </div>
                        
                        <!-- Nested Reply -->
                        <div class="nested-comment mt-2">
                            <div class="d-flex">
                                <img src="https://via.placeholder.com/32x32" alt="User" class="rounded-circle me-2">
                                <div class="flex-grow-1">
                                    <div class="bg-light p-2 rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div>
                                                <strong class="small">Ahmet Yılmaz</strong>
                                                <small class="text-muted ms-1">1 saat önce</small>
                                                <span class="badge bg-success ms-1">Yazar</span>
                                            </div>
                                        </div>
                                        <p class="small mb-1">
                                            @Mehmet Demir Teşekkürler! Laravel'in sunduğu kolaylıklar gerçekten etkileyici.
                                        </p>
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-heart me-1"></i>2
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Comment 2 -->
            <div class="mb-3">
                <div class="d-flex">
                    <img src="https://via.placeholder.com/40x40" alt="User" class="rounded-circle me-3">
                    <div class="flex-grow-1">
                        <div class="bg-white p-3 rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>Ayşe Kaya</strong>
                                    <small class="text-muted ms-2">4 saat önce</small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">
                                            <i class="fas fa-reply me-1"></i>Yanıtla
                                        </a></li>
                                        <li><a class="dropdown-item text-danger" href="#">
                                            <i class="fas fa-flag me-1"></i>Şikayet Et
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                            <p class="mb-2">
                                Symfony vs Laravel karşılaştırması da yapabilir misiniz? 
                                Hangi durumda hangisini tercih etmeliyiz?
                            </p>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-heart me-1"></i>8
                                </button>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-reply me-1"></i>Yanıtla
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Load More Comments -->
            <div class="text-center">
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-chevron-down me-1"></i>Daha Fazla Yorum Yükle
                </button>
            </div>
        </div>
        
        <!-- Related Posts -->
        <div class="mt-5">
            <h4 class="mb-3">
                <i class="fas fa-bookmark me-2"></i>İlgili Yazılar
            </h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="PHP">
                        <div class="card-body">
                            <h6 class="card-title">PHP 8.3 Yenilikleri</h6>
                            <p class="card-text small text-muted">
                                PHP'nin en son versiyonunda gelen yenilikler...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">3 gün önce</small>
                                <a href="/posts/3" class="btn btn-primary btn-sm">Oku</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Vue">
                        <div class="card-body">
                            <h6 class="card-title">Vue.js ile SPA Geliştirme</h6>
                            <p class="card-text small text-muted">
                                Single Page Application geliştirme rehberi...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">1 hafta önce</small>
                                <a href="/posts/4" class="btn btn-primary btn-sm">Oku</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function deletePost() {
    if(confirm('Bu yazıyı silmek istediğinizden emin misiniz?')) {
        // AJAX ile silme işlemi
        alert('Yazı silindi!');
    }
}
</script>
@endsection
@endsection
