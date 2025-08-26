<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request = null)
    {
        $search = $request ? $request->input('search', '') : '';
        $selectedTag = $request ? $request->input('tag', '') : '';
        
        try {
            // HER İKİ SİSTEMİ DE YÜKLEYELİM
            $query = Post::with(['user', 'tags'])
                        ->where('status', 'published');
            
            // ARAMA FİLTRELEME
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('content', 'LIKE', '%' . $search . '%')
                      ->orWhere('excerpt', 'LIKE', '%' . $search . '%');
                });
            }
            
            // TAG FİLTRELEME - HİBRİT YAKLAŞIM
            if (!empty($selectedTag)) {
                $query->where(function($q) use ($selectedTag) {
                    // 1. Relational tags'da ara
                    $q->whereHas('tags', function($tagQuery) use ($selectedTag) {
                        $tagQuery->where('name', $selectedTag);
                    })
                    // 2. JSON tags'da ara (eski sistem)
                    ->orWhereJsonContains('tags', $selectedTag)
                    ->orWhere('tags', 'LIKE', '%"' . $selectedTag . '"%');
                });
            }
            
            $posts = $query->orderBy('published_at', 'desc')
                          ->limit(10)
                          ->get();
            
        } catch (\Exception $e) {
            // Hata durumunda basit query
            $posts = Post::with('user')
                        ->where('status', 'published')
                        ->orderBy('published_at', 'desc')
                        ->limit(10)
                        ->get();
        }
        
        return view('home', [
            'posts' => $posts,
            'search' => $search,
            'selectedTag' => $selectedTag
        ]);
    }

    public function about()
    {
        return view('about');
    }

    // API Endpoint - Hibrit sistem
    public function getTags()
    {
        try {
            $tagCounts = [];
            
            // 1. Relational tags'ları al
            $relationalTags = Tag::withCount('posts')
                                ->orderBy('posts_count', 'desc')
                                ->get();
            
            foreach ($relationalTags as $tag) {
                $tagCounts[$tag->name] = $tag->posts_count;
            }
            
            // 2. JSON tags'ları da al (eski sistem)
            $posts = Post::where('status', 'published')
                        ->whereNotNull('tags')
                        ->get();
            
            foreach ($posts as $post) {
                // Sadece JSON field'ı varsa işle
                if ($post->getAttributes()['tags']) {
                    $postTags = [];
                    
                    if (is_string($post->getAttributes()['tags'])) {
                        $postTags = json_decode($post->getAttributes()['tags'], true) ?: [];
                    }
                    
                    foreach ($postTags as $tag) {
                        $tag = trim($tag);
                        if (!empty($tag)) {
                            $tagCounts[$tag] = isset($tagCounts[$tag]) ? $tagCounts[$tag] + 1 : 1;
                        }
                    }
                }
            }
            
            // En çok kullanılan etiketler önce
            arsort($tagCounts);
            
            $tags = [];
            foreach ($tagCounts as $tag => $count) {
                $tags[] = [
                    'name' => $tag,
                    'count' => $count
                ];
            }
            
            return response()->json([
                'success' => true,
                'tags' => $tags,
                'debug' => [
                    'relational_tags' => $relationalTags->count(),
                    'total_unique_tags' => count($tags)
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'tags' => []
            ], 500);
        }
    }
}
