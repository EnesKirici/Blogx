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
        $post = Post::where('slug', $slug)->firstOrFail();
        
        if (!Auth::check() || $post->user_id !== Auth::id()) {
            return redirect('/')
                   ->with('error', 'Bu yazıyı düzenleme yetkiniz yok!');
        }
        
        return view('edit-post', compact('post'));
    }

    // Blog güncelleme işlemi
    public function update(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        if (!Auth::check() || $post->user_id !== Auth::id()) {
            return redirect('/')
                   ->with('error', 'Bu yazıyı düzenleme yetkiniz yok!');
        }

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

        $featuredImage = $post->featured_image;
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                $oldImagePath = public_path('storage/' . $post->featured_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $featuredImage = $request->file('featured_image')->store('posts', 'public');
        }

        $status = $post->status;
        $publishedAt = $post->published_at;

        if ($request->action === 'publish' || $request->has('is_published')) {
            $status = 'published';
            if (!$publishedAt) {
                $publishedAt = now();
            }
        } elseif ($request->action === 'draft') {
            $status = 'draft';
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->get('content'),
            'excerpt' => $request->excerpt,
            'featured_image' => $featuredImage,
            'status' => $status,
            'allow_comments' => $request->has('allow_comments'),
            'published_at' => $publishedAt,
        ]);

        $message = $status === 'published' 
            ? 'Blog yazınız başarıyla güncellendi!' 
            : 'Blog yazınız taslak olarak güncellendi!';

        return redirect()->route('posts.show', $post->slug)
               ->with('success', $message);
    }

    // Tek blog yazısını göster
    public function show($slug)
    {
        $post = Post::with(['user', 'tags', 'comments.user'])->where('slug', $slug)->firstOrFail();
        
        // Görüntüleme sayısını artır
        $post->increment('views_count');
        
        // Sadece son yazıları göster (basit)
        $relatedPosts = Post::with(['user'])
                       ->where('status', 'published')
                       ->where('id', '!=', $post->id)
                       ->latest('published_at')
                       ->take(4)
                       ->get();
    
        return view('post-detail', compact('post', 'relatedPosts'));
    }

    // Yeni blog yazısı kaydet
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('user.login')
                   ->with('error', 'Blog yazısı oluşturmak için giriş yapmalısınız!');
        }

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

        $slug = Str::slug($request->title);
        
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $featuredImage = null;
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image')->store('posts', 'public');
        }

        $status = 'draft';
        $publishedAt = null;

        if ($request->action === 'publish' || $request->has('is_published')) {
            $status = 'published';
            $publishedAt = now();
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->get('content'),
            'excerpt' => $request->excerpt,
            'featured_image' => $featuredImage,
            'status' => $status,
            'allow_comments' => $request->has('allow_comments'),
            'is_featured' => $request->has('is_featured'),
            'published_at' => $publishedAt,
            'user_id' => Auth::id()
        ]);
        
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagNames = array_filter($tagNames);
            
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = \App\Models\Tag::createFromName($tagName);
                    $tagIds[] = $tag->id;
                }
            }
            
            $post->tags()->sync($tagIds);
        }
        
        return redirect()->route('posts.show', $post->slug)
               ->with('success', 'Blog yazısı başarıyla yayınlandı!');
    }

    // BEĞENI BUTONU İÇİN YENİ METHOD
    public function like($slug)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Beğenmek için giriş yapmalısınız'
            ], 401);
        }

        $post = Post::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        // Beğeni kontrolü - Like tablosu veya post tablosunda user_id kontrolü
        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            // Beğeniyi kaldır
            $existingLike->delete();
            $liked = false;
        } else {
            // Beğeni ekle
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        // Güncel beğeni sayısını al
        $likesCount = $post->likes()->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $likesCount,
            'message' => $liked ? 'Yazı beğenildi!' : 'Beğeni kaldırıldı!'
        ]);
    }

    // Kullanıcının kendi yazıları
    public function myPosts()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login')
                   ->with('error', 'Bu sayfayı görüntülemek için giriş yapmalısınız!');
        }

        $posts = Auth::user()->posts()
                 ->with(['tags'])
                 ->withCount(['likes', 'comments'])
                 ->latest()
                 ->get();
    
        return view('myposts', compact('posts'));
    }

    public function destroy($slug)
    {
        try {
            $post = Post::where('slug', $slug)->firstOrFail();
            
            // Sadece yazı sahibi silebilir
            if ($post->user_id !== auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu yazıyı silme yetkiniz yok!'
                ], 403);
            }
            
            // 1. Post-tag ilişkilerini sil (post_tags tablosundan)
            $post->tags()->detach();
            
            // 2. Kullanılmayan tag'ları temizle
            $this->cleanupUnusedTags();
            
            // 3. Fotoğrafı sil (varsa)
            if ($post->featured_image) {
                $imagePath = public_path('storage/' . $post->featured_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            // 4. Post'u sil
            $post->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Yazı ve ilgili etiketler başarıyla silindi!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Silme işlemi sırasında hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    // Kullanılmayan tag'ları temizleme method'u
    private function cleanupUnusedTags()
    {
        // Hiçbir post'a bağlı olmayan tag'ları bul ve sil
        $unusedTags = \App\Models\Tag::doesntHave('posts')->get();
        
        foreach ($unusedTags as $tag) {
            $tag->delete();
        }
    }
}
