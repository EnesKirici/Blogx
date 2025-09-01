<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request = null)
    {
        $search = $request ? $request->input('search', '') : '';
        $selectedTag = $request ? $request->input('tag', '') : '';
        
        // DEBUG - GEÇİCİ
        if (!empty($search)) {
            \Log::info('Arama yapılıyor:', [
                'search' => $search,
                'request_all' => $request->all()
            ]);
        }
        
        try {
            // Basit post çekme
            $allPosts = Post::with('user')
                           ->where('status', 'published')
                           ->orderBy('published_at', 'desc')
                           ->get();
            
            $filteredPosts = $allPosts;
            
            // ARAMA FİLTRELEME - DÜZELT
            if (!empty($search)) {
                $filteredPosts = $filteredPosts->filter(function($post) use ($search) {
                    $searchLower = strtolower($search);
                    
                    return stripos($post->title, $searchLower) !== false ||
                           stripos($post->content, $searchLower) !== false ||
                           stripos($post->excerpt ?? '', $searchLower) !== false;
                });
            }
            
            // TAG FİLTRELEME
            if (!empty($selectedTag)) {
                $filteredPosts = $filteredPosts->filter(function($post) use ($selectedTag) {
                    $postTags = $this->getPostTags($post);
                    
                    foreach ($postTags as $tag) {
                        if (strtolower(trim($tag)) === strtolower(trim($selectedTag))) {
                            return true;
                        }
                    }
                    return false;
                });
            }
            
            $posts = $filteredPosts->take(10);
            
        } catch (\Exception $e) {
            $posts = collect([]);
        }
        
        return view('home', [
            'posts' => $posts,
            'search' => $search,
            'selectedTag' => $selectedTag
        ]);
    }

    // Post'un tag'lerini al (her sistemle uyumlu)
    private function getPostTags($post)
    {
        $tags = [];
        
        // Relational tags varsa
        try {
            if ($post->relationLoaded('tags') && $post->tags && $post->tags->count() > 0) {
                foreach ($post->tags as $tag) {
                    $tags[] = $tag->name;
                }
                return $tags;
            }
        } catch (\Exception $e) {
            // Relational yok, devam et
        }
        
        // JSON/Array tags varsa
        try {
            $rawTags = $post->getAttributes()['tags'] ?? $post->tags ?? null;
            
            if (is_string($rawTags)) {
                $tags = json_decode($rawTags, true) ?: [];
            } elseif (is_array($rawTags)) {
                $tags = $rawTags;
            }
        } catch (\Exception $e) {
            // Hata varsa boş döndür
        }
        
        return $tags;
    }

    public function about()
    {
        return view('about');
    }
}
