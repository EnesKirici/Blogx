<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    
    // Blog düzenleme sayfasını göster
    public function edit($slug)
    {
        // Slug'a göre postu bul
        $post = Post::where('slug', $slug)->firstOrFail();
        
        // Sadece yazarın kendisi düzenleyebilir
        if (!Auth::check() || $post->user_id !== Auth::id()) {
            return redirect('/')
                   ->with('error', 'Bu yazıyı düzenleme yetkiniz yok!');
        }
        
        return view('edit-post', compact('post'));
    }

    // Blog güncelleme işlemi
    public function update(Request $request, $slug)
    {
        // Postu bul
        $post = Post::where('slug', $slug)->firstOrFail();
        
        // Yetki kontrolü
        if (!Auth::check() || $post->user_id !== Auth::id()) {
            return redirect('/')
                   ->with('error', 'Bu yazıyı düzenleme yetkiniz yok!');
        }

        // Form doğrulama
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'excerpt' => 'nullable|string|max:500',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                   ->withErrors($validator)
                   ->withInput();
        }

        // Tags'i işle
        $tags = null;
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tags = array_filter($tags);
        }

        // Resim yükleme (yeni resim varsa)
        $featuredImage = $post->featured_image; // Mevcut resmi koru
        if ($request->hasFile('featured_image')) {
            // Eski resmi sil
            if ($post->featured_image) {
                $oldImagePath = public_path('storage/' . $post->featured_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $featuredImage = $request->file('featured_image')->store('posts', 'public');
        }

        // Status belirleme
        $status = $post->status; // Mevcut durumu koru
        $publishedAt = $post->published_at;

        if ($request->action === 'publish' || $request->has('is_published')) {
            $status = 'published';
            if (!$publishedAt) {
                $publishedAt = now();
            }
        } elseif ($request->action === 'draft') {
            $status = 'draft';
        }

        // Post güncelle
        $post->update([
            'title' => $request->title,
            'content' => $request->get('content'),
            'excerpt' => $request->excerpt,
            'featured_image' => $featuredImage,
            'tags' => $tags,
            'status' => $status,
            'allow_comments' => $request->has('allow_comments'),
            'published_at' => $publishedAt,
        ]);

        // Başarı mesajı
        $message = $status === 'published' 
            ? 'Blog yazınız başarıyla güncellendi!' 
            : 'Blog yazınız taslak olarak güncellendi!';

        return redirect()->route('posts.show', $post->slug)
               ->with('success', $message);
    }

    // Tek blog yazısını göster (DİNAMİK)
    public function show($slug)
    {
        // Slug'a göre postu bul
        $post = Post::with('user') // Yazar bilgileriyle birlikte
                   ->where('slug', $slug)
                   ->where('status', 'published') // Sadece yayında olanlar
                   ->firstOrFail(); // Bulamazsa 404

        // Görüntülenme sayısını artır
        $post->increment('views_count');

        // İlgili yazılar (aynı etiketlere sahip)
        $relatedPosts = Post::with('user')
                           ->where('status', 'published')
                           ->where('id', '!=', $post->id) // Mevcut yazı hariç
                           ->limit(2)
                           ->get();

        return view('post-detail', compact('post', 'relatedPosts'));
    }

    public function store(Request $request)
    {
        // Giriş kontrolü
        if (!Auth::check()) {
            return redirect()->route('user.login')
                   ->with('error', 'Blog yazısı oluşturmak için giriş yapmalısınız!');
        }

        // Form doğrulama
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'excerpt' => 'nullable|string|max:500',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                   ->withErrors($validator)
                   ->withInput();
        }

        // Tags'i işle (virgülle ayrılmış string → array)
        $tags = null;
        if ($request->tags) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tags = array_filter($tags); // Boş değerleri temizle
        }

        // Resim yükleme
        $featuredImage = null;
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image')->store('posts', 'public');
        }

        // Status belirleme (Form'daki action butonuna göre)
        $status = 'draft'; // Varsayılan
        $publishedAt = null;

        if ($request->action === 'publish' || $request->has('is_published')) {
            $status = 'published';
            $publishedAt = now();
        }

        // Post oluştur (GİRİŞ YAPMIŞ KULLANICININ ID'Sİ İLE)
        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->get('content'),
            'excerpt' => $request->excerpt,
            'featured_image' => $imagePath,
            'status' => 'published',
            'allow_comments' => $request->has('allow_comments'),
            'is_featured' => $request->has('is_featured'),
            'published_at' => now(),
            'user_id' => auth()->id()
        ]);
        
        // Tags'ları işle (YENİ YÖNTEM)
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagNames = array_filter($tagNames); // Boş olanları temizle
            
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = \App\Models\Tag::createFromName($tagName);
                    $tagIds[] = $tag->id;
                }
            }
            
            // Post'a tag'leri ekle
            $post->tags()->sync($tagIds);
        }
        
        // Başarı mesajı
        $message = $status === 'published' 
            ? 'Blog yazınız başarıyla yayınlandı!' 
            : 'Blog yazınız taslak olarak kaydedildi!';

        return redirect('/')
               ->with('success', $message);
    }

    // Kullanıcının kendi yazıları
    public function myPosts()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }

        $posts = Auth::user()->posts()->latest()->get();
        
        // $user = User::find(Auth::id());
        // $posts = $user->posts()->latest()->get();

        return view('my-posts', compact('posts'));
    }
}
