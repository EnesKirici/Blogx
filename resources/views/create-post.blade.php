@extends('layouts.app')

@section('title', 'Yeni Yazı Oluştur - Blog Sitesi')

@section('content')
<style>
    body {
        background: #5a5a5a !important;
    }
    .card {
        background: #3d3d3d;
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid #555;
    }
    .card-header {
        background: #2a2a2a;
        color: #ffffff;
        border-radius: 15px 15px 0 0;
        border-bottom: 1px solid #555;
    }
    .form-control {
        background: #4a4a4a;
        border: 1px solid #555;
        color: white;
        border-radius: 8px;
    }
    .form-control:focus {
        background: #4a4a4a;
        border-color: #66a3ff;
        box-shadow: 0 0 0 0.2rem rgba(102, 163, 255, 0.25);
        color: white;
    }
    .form-control::placeholder {
        color: #bbb;
    }
    .form-label {
        color: #e0e0e0;
        font-weight: 500;
    }
    .form-text {
        color: #999;
    }
    .btn-outline-secondary {
        border-color: #555;
        color: #e0e0e0;
    }
    .btn-outline-secondary:hover {
        background: #555;
        border-color: #666;
        color: white;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4a90e2, #357abd);
        border: none;
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #357abd, #2968a3);
        transform: translateY(-2px);
    }
    .bg-light {
        background: #2a2a2a !important;
        border-color: #555 !important;
    }
    .modal-content {
        background: #3d3d3d;
        color: #e0e0e0;
    }
    .modal-header {
        border-bottom: 1px solid #555;
    }
    .modal-footer {
        border-top: 1px solid #555;
    }
    .table {
        color: #e0e0e0;
    }
    .table td {
        border-color: #555;
    }
    .form-check-label {
        color: #e0e0e0;
    }
</style>
</style>
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Yeni Blog Yazısı Oluştur
                </h3>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">                  
             @csrf
                    
                    <!-- Başlık -->
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <i class="fas fa-heading me-1"></i>Başlık *
                        </label>
                        <input type="text" class="form-control" id="title" name="title" 
                               placeholder="Yazınızın başlığını girin..." required>
                        <div class="form-text">Dikkat çekici ve açıklayıcı bir başlık seçin</div>
                    </div>
                    
                    <!-- Özet -->
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">
                            <i class="fas fa-align-left me-1"></i>Özet
                        </label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3" 
                                  placeholder="Yazınızın kısa bir özetini yazın..."></textarea>
                        <div class="form-text">Bu özet, yazı listelerinde görüntülenecek</div>
                    </div>
                    
                    <!-- Kapak Resmi -->
                    <div class="mb-3">
                        <label for="featured_image" class="form-label">
                            <i class="fas fa-image me-1"></i>Kapak Resmi
                        </label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image" 
                               accept="image/*">
                        <div class="form-text">JPG, PNG veya WebP formatında yükleyebilirsiniz (Maks: 5MB)</div>
                    </div>
                    
                    <!-- Etiketler -->
                    <div class="mb-3">
                        <label for="tags" class="form-label">
                            <i class="fas fa-tags me-1"></i>Etiketler
                        </label>
                        <input type="text" class="form-control" id="tags" name="tags" 
                               placeholder="laravel, php, web-geliştirme">
                        <div class="form-text">Virgül ile ayırarak birden fazla etiket ekleyebilirsiniz</div>
                    </div>
                    
                    <!-- İçerik -->
                    <div class="mb-3">
                        <label for="content" class="form-label">
                            <i class="fas fa-edit me-1"></i>İçerik *
                        </label>
                        
                        <!-- Editor Toolbar -->
                        <div class="border rounded-top p-2 bg-light">
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('bold')">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('italic')">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('underline')">
                                    <i class="fas fa-underline"></i>
                                </button>
                            </div>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertList('ul')">
                                    <i class="fas fa-list-ul"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertList('ol')">
                                    <i class="fas fa-list-ol"></i>
                                </button>
                            </div>
                            <div class="btn-group me-2" role="group">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertLink()">
                                    <i class="fas fa-link"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="insertCode()">
                                    <i class="fas fa-code"></i>
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#previewModal">
                                    <i class="fas fa-eye me-1"></i>Önizleme
                                </button>
                            </div>
                        </div>
                        
                        <textarea class="form-control border-top-0 rounded-top-0" id="content" name="content" 
                                  rows="15" placeholder="Yazınızın içeriğini buraya yazın...

                                        Markdown formatını destekliyoruz:

                                        # Büyük Başlık
                                        ## Orta Başlık
                                        ### Küçük Başlık

                                        **Kalın metin** ve *italik metin*

                                        - Liste öğesi 1
                                        - Liste öğesi 2

                                        [Link metni](https://example.com)

                                        ```kod bloğu```

                                        > Alıntı metni"
                                 required></textarea>
                                 
                        <div class="form-text">
                            <i class="fab fa-markdown me-1"></i>
                            Markdown formatı desteklenir | 
                            <a href="#" data-bs-toggle="modal" data-bs-target="#markdownHelp">Markdown Rehberi</a>
                        </div>
                    </div>
                    
                    <!-- Yayın Ayarları -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-cog me-1"></i>Yayın Ayarları
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" checked>
                                        <label class="form-check-label" for="is_published">
                                            <i class="fas fa-globe me-1"></i>Hemen yayınla
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allow_comments" name="allow_comments" checked>
                                        <label class="form-check-label" for="allow_comments">
                                            <i class="fas fa-comments me-1"></i>Yorumlara izin ver
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{route('index')  }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Geri Dön
                        </a>
                        <div>
                            <button type="submit" name="action" value="draft" class="btn btn-outline-primary me-2">
                                <i class="fas fa-save me-1"></i>Taslak Kaydet
                            </button>
                            <button type="submit" name="action" value="publish" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>Yayınla
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Yazı Önizlemesi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="preview-content" class="blog-post">
                    <!-- Önizleme içeriği buraya gelecek -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Düzenlemeye Devam Et</button>
            </div>
        </div>
    </div>
</div>

<!-- Markdown Help Modal -->
<div class="modal fade" id="markdownHelp" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fab fa-markdown me-2"></i>Markdown Rehberi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td><code># Başlık</code></td>
                            <td>Büyük başlık</td>
                        </tr>
                        <tr>
                            <td><code>## Alt Başlık</code></td>
                            <td>Orta başlık</td>
                        </tr>
                        <tr>
                            <td><code>**kalın**</code></td>
                            <td><strong>kalın</strong> metin</td>
                        </tr>
                        <tr>
                            <td><code>*italik*</code></td>
                            <td><em>italik</em> metin</td>
                        </tr>
                        <tr>
                            <td><code>[link](url)</code></td>
                            <td>Bağlantı oluşturur</td>
                        </tr>
                        <tr>
                            <td><code>- liste</code></td>
                            <td>Madde işaretli liste</td>
                        </tr>
                        <tr>
                            <td><code>```kod```</code></td>
                            <td>Kod bloğu</td>
                        </tr>
                        <tr>
                            <td><code>> alıntı</code></td>
                            <td>Alıntı bloğu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Anladım</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Basit metin formatlaması
function formatText(command) {
    document.execCommand(command, false, null);
}

function insertList(type) {
    if(type === 'ul') {
        document.execCommand('insertUnorderedList', false, null);
    } else {
        document.execCommand('insertOrderedList', false, null);
    }
}

function insertLink() {
    const url = prompt('Link URL\'sini girin:');
    if(url) {
        document.execCommand('createLink', false, url);
    }
}

function insertCode() {
    const selection = window.getSelection().toString();
    if(selection) {
        document.execCommand('insertHTML', false, `<code>${selection}</code>`);
    }
}

// Önizleme
document.getElementById('previewModal').addEventListener('show.bs.modal', function() {
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;
    
    // Basit markdown to HTML dönüştürme (gerçek projede markdown parser kullanılmalı)
    let html = content
        .replace(/^# (.*$)/gim, '<h1>$1</h1>')
        .replace(/^## (.*$)/gim, '<h2>$1</h2>')
        .replace(/^### (.*$)/gim, '<h3>$1</h3>')
        .replace(/\*\*(.*)\*\*/gim, '<strong>$1</strong>')
        .replace(/\*(.*)\*/gim, '<em>$1</em>')
        .replace(/\n/gim, '<br>');
    
    document.getElementById('preview-content').innerHTML = `
        <h1>${title || 'Başlık girilmedi'}</h1>
        <div class="post-meta mb-3">
            <i class="fas fa-user me-1"></i>Sizin Adınız
            <i class="fas fa-calendar ms-3 me-1"></i>${new Date().toLocaleDateString('tr-TR')}
        </div>
        <div>${html || 'İçerik girilmedi'}</div>
    `;
});

// Karakter sayacı
document.getElementById('title').addEventListener('input', function() {
    const length = this.value.length;
    console.log(`Başlık: ${length} karakter`);
});

// Otomatik kaydetme (localStorage)
setInterval(function() {
    const formData = {
        title: document.getElementById('title').value,
        excerpt: document.getElementById('excerpt').value,
        content: document.getElementById('content').value,
        tags: document.getElementById('tags').value
    };
    localStorage.setItem('blog_draft', JSON.stringify(formData));
}, 30000); // 30 saniyede bir kaydet

// Sayfa yüklendiğinde taslağı geri yükle
window.addEventListener('load', function() {
    const draft = localStorage.getItem('blog_draft');
    if(draft && confirm('Kaydedilmiş bir taslağınız var. Geri yüklemek ister misiniz?')) {
        const data = JSON.parse(draft);
        document.getElementById('title').value = data.title || '';
        document.getElementById('excerpt').value = data.excerpt || '';
        document.getElementById('content').value = data.content || '';
        document.getElementById('tags').value = data.tags || '';
    }
});
</script>
@endsection

@endsection
