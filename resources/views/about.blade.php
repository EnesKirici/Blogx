@extends('layouts.app')

@section('title', 'Hakkımızda - Blog Sitesi')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important;
        min-height: 100vh;
    }
    
    .hero-section {
        background: linear-gradient(135deg, #000000 0%, #434343 100%);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .content-card {
        background: rgba(45, 45, 45, 0.95);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        border: 1px solid #555;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7);
        border-color: #66a3ff;
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #4a90e2, #357abd);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 10px 20px rgba(74, 144, 226, 0.3);
    }
    
    .feature-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .stats-counter {
        background: linear-gradient(135deg, #2a2a2a, #1a1a1a);
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        border: 1px solid #444;
        transition: all 0.3s ease;
    }
    
    .stats-counter:hover {
        background: linear-gradient(135deg, #357abd, #4a90e2);
        transform: scale(1.05);
    }
    
    .stats-number {
        font-size: 3rem;
        font-weight: bold;
        color: #66a3ff;
        margin-bottom: 10px;
        text-shadow: 0 0 10px rgba(102, 163, 255, 0.3);
    }
    
    .team-card {
        background: rgba(30, 30, 30, 0.9);
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        border: 1px solid #444;
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        border-color: #66a3ff;
        box-shadow: 0 15px 30px rgba(102, 163, 255, 0.2);
    }
    
    .team-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4a90e2, #357abd);
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        border: 4px solid #66a3ff;
    }
    
    .section-title {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 60px;
        position: relative;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, #4a90e2, #357abd);
        border-radius: 2px;
    }
    
    .text-content {
        color: #e0e0e0;
        line-height: 1.8;
        font-size: 1.1rem;
    }
    
    .cta-section {
        background: linear-gradient(135deg, #4a90e2, #357abd);
        border-radius: 20px;
        padding: 50px;
        text-align: center;
        margin-top: 50px;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(255,255,255,0.05) 10px,
            rgba(255,255,255,0.05) 20px
        );
        animation: slide 20s linear infinite;
    }
    
    @keyframes slide {
        0% { transform: translateX(-50px) translateY(-50px); }
        100% { transform: translateX(50px) translateY(50px); }
    }
    
    .btn-custom {
        background: linear-gradient(135deg, #ffffff, #f0f0f0);
        color: #333;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }
    
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        color: #333;
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-3 text-white mb-4 font-weight-bold">
                    <i class="fas fa-users me-3"></i>Hakkımızda
                </h1>
                <p class="lead text-light mb-0">
                    Deneyimlerin paylaşıldığı, bilginin özgürce aktığı ve herkesin öğrenmeye açık olduğu bir platform
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <!-- Misyonumuz -->
    <div class="row">
        <div class="col-12">
            <h2 class="section-title">💡 Misyonumuz</h2>
        </div>
        <div class="col-lg-8 mx-auto">
            <div class="content-card">
                <div class="text-content">
                    <p class="mb-4">
                        <strong>Blog Sitesi</strong>, kullanıcıların kendi deneyimlerini, bilgilerini ve öğrendiklerini 
                        bir araya getirerek toplumsal bir öğrenme platformu oluşturmayı hedefler. Her ihtiyacı karşılayacak 
                        bilgiyi burada bulabilir, kendi deneyimlerinizi paylaşarak başkalarına yardımcı olabilirsiniz.
                    </p>
                    <p class="mb-4">
                        Teknolojiden yaşam tarzına, kariyer gelişiminden hobi önerilerine kadar geniş bir yelpazede 
                        içerikler üretiyoruz. Amacımız, herkesin öğrenmeye ve paylaşmaya açık olduğu, destekleyici 
                        bir topluluk oluşturmaktır.
                    </p>
                    <p class="mb-0">
                        <strong>Birlikte öğrenir, birlikte büyürüz!</strong> Her yazı, bir deneyimdir; her yorum, 
                        bir perspektiftir; her paylaşım, topluluğumuzun daha da güçlenmesidir.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Özelliklerimiz -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="section-title">🚀 Neler Sunuyoruz?</h2>
        </div>
        <div class="col-md-4 mb-4">
            <div class="content-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <h4 class="text-white mb-3">Kolay İçerik Oluşturma</h4>
                <p class="text-content">
                    Kullanıcı dostu editör ile markdown desteği sayesinde profesyonel 
                    blog yazıları oluşturun. Resim ekleme, kod blokları ve zengin metin 
                    formatlaması ile fikirlerinizi en iyi şekilde ifade edin.
                </p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="content-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4 class="text-white mb-3">Topluluk Odaklı</h4>
                <p class="text-content">
                    Yorumlar, beğeniler ve tepkilerle etkileşimli bir deneyim yaşayın. 
                    Diğer kullanıcılarla bağlantı kurun, fikirlerinizi tartışın ve 
                    birbirinden öğrenin.
                </p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="content-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h4 class="text-white mb-3">Güçlü Arama</h4>
                <p class="text-content">
                    Gelişmiş arama algoritması ile aradığınız konuları kolayca bulun. 
                    Başlık, içerik ve etiket bazlı filtreleme ile istediğiniz bilgiye 
                    anında ulaşın.
                </p>
            </div>
        </div>
    </div>

    <!-- İstatistikler -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="section-title">📊 Platformumuz Rakamlarla</h2>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-counter">
                <div class="stats-number" id="postsCount">0</div>
                <h5 class="text-white">Blog Yazısı</h5>
                <p class="text-muted mb-0">Paylaşılan deneyimler</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-counter">
                <div class="stats-number" id="usersCount">0</div>
                <h5 class="text-white">Aktif Kullanıcı</h5>
                <p class="text-muted mb-0">Topluluğumuzun üyeleri</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-counter">
                <div class="stats-number" id="commentsCount">0</div>
                <h5 class="text-white">Yorum</h5>
                <p class="text-muted mb-0">Yapılan etkileşimler</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="stats-counter">
                <div class="stats-number" id="likesCount">0</div>
                <h5 class="text-white">Beğeni</h5>
                <p class="text-muted mb-0">Takdir edilen içerikler</p>
            </div>
        </div>
    </div>

    <!-- Değerlerimiz -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="section-title">💎 Değerlerimiz</h2>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="content-card">
                <h4 class="text-white mb-3">
                    <i class="fas fa-heart text-danger me-2"></i>Şeffaflık ve Güven
                </h4>
                <p class="text-content">
                    Tüm içeriklerimiz gerçek kullanıcı deneyimlerine dayanır. Sahte veya yanıltıcı 
                    bilgilere yer vermeyiz. Her yazarın kimliği açık ve güvenilirdir.
                </p>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="content-card">
                <h4 class="text-white mb-3">
                    <i class="fas fa-handshake text-primary me-2"></i>Kapsayıcılık
                </h4>
                <p class="text-content">
                    Her seviyeden, her yaştan ve her geçmişten insanı kucaklıyoruz. Öğrenme 
                    yolculuğunda kimseyi geride bırakmayız, herkesin sesini duyurmasını sağlarız.
                </p>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="content-card">
                <h4 class="text-white mb-3">
                    <i class="fas fa-rocket text-warning me-2"></i>Sürekli Gelişim
                </h4>
                <p class="text-content">
                    Platformumuz ve topluluğumuz sürekli gelişir. Kullanıcı geri bildirimlerini 
                    dinler, yeni özellikler ekler ve deneyimi sürekli iyileştiririz.
                </p>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="content-card">
                <h4 class="text-white mb-3">
                    <i class="fas fa-shield-alt text-success me-2"></i>Kalite ve Güvenlik
                </h4>
                <p class="text-content">
                    İçerik kalitesini ve platform güvenliğini en üst düzeyde tutarız. 
                    Kişisel verileriniz korunur, moderation sistemimiz ile zararlı içerikler engellenir.
                </p>
            </div>
        </div>
    </div>

    <!-- Ekip (Simulated) -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="section-title">👥 Topluluk Liderleri</h2>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="team-card">
                <div class="team-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h4 class="text-white">Platform Yöneticileri</h4>
                <p class="text-primary mb-2">Teknoloji & Geliştirme</p>
                <p class="text-content">
                    Platformun teknik altyapısını geliştiren ve kullanıcı deneyimini 
                    sürekli iyileştiren ekibimiz.
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="team-card">
                <div class="team-avatar">
                    <i class="fas fa-users"></i>
                </div>
                <h4 class="text-white">Topluluk Moderatörleri</h4>
                <p class="text-primary mb-2">İçerik & Moderasyon</p>
                <p class="text-content">
                    İçerik kalitesini koruyan, topluluk kurallarını uygulayan 
                    ve kullanıcılara destek olan gönüllü moderatörlerimiz.
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="team-card">
                <div class="team-avatar">
                    <i class="fas fa-star"></i>
                </div>
                <h4 class="text-white">Aktif Yazarlar</h4>
                <p class="text-primary mb-2">İçerik Üreticileri</p>
                <p class="text-content">
                    Düzenli olarak kaliteli içerik üreten, topluluğa değer katan 
                    ve deneyimlerini paylaşan özel yazarlarımız.
                </p>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row">
        <div class="col-12">
            <div class="cta-section">
                <h2 class="text-white mb-4">Topluluğumuza Katılın!</h2>
                <p class="text-white mb-4 lead">
                    Deneyimlerinizi paylaşın, başkalarından öğrenin ve birlikte büyüyelim. 
                    Her ses değerlidir, her deneyim önemlidir.
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    @auth
                        <a href="{{ route('user.create-post') }}" class="btn btn-custom">
                            <i class="fas fa-plus me-2"></i>İlk Yazınızı Oluşturun
                        </a>
                        <a href="{{ route('index') }}" class="btn btn-outline-light">
                            <i class="fas fa-home me-2"></i>Ana Sayfaya Dön
                        </a>
                    @else
                        <a href="{{ route('user.register') }}" class="btn btn-custom">
                            <i class="fas fa-user-plus me-2"></i>Hemen Kayıt Olun
                        </a>
                        <a href="{{ route('user.login') }}" class="btn btn-outline-light">
                            <i class="fas fa-sign-in-alt me-2"></i>Giriş Yapın
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Sayısal animasyonlar
function animateCounter(elementId, targetValue, duration = 2000) {
    const element = document.getElementById(elementId);
    const startTime = performance.now();
    const startValue = 0;

    function updateCounter(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        // Easing function (ease-out)
        const easeOut = 1 - Math.pow(1 - progress, 3);
        const currentValue = Math.floor(startValue + (targetValue - startValue) * easeOut);
        
        element.textContent = currentValue.toLocaleString();
        
        if (progress < 1) {
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = targetValue.toLocaleString();
        }
    }

    requestAnimationFrame(updateCounter);
}

// Sayfa yüklendiğinde animasyonları başlat
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer ile lazy loading
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // İstatistik animasyonları
                animateCounter('postsCount', 150, 2000);
                animateCounter('usersCount', 1250, 2500);
                animateCounter('commentsCount', 850, 2200);
                animateCounter('likesCount', 3200, 2800);
                
                observer.unobserve(entry.target);
            }
        });
    });

    const statsSection = document.querySelector('.stats-counter').parentElement.parentElement;
    observer.observe(statsSection);
});

// Hover efektleri için extra animasyonlar
document.querySelectorAll('.content-card, .team-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-5px) scale(1.02)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});
</script>
@endsection

@endsection