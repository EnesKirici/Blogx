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
        
        try {
            $query = Post::with('user')
                        ->where('status', 'published');
            
            // Arama filtreleme
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'LIKE', $searchTerm)
                      ->orWhere('content', 'LIKE', $searchTerm)
                      ->orWhere('excerpt', 'LIKE', $searchTerm);
                });
            }
            
            // Tag filtreleme (BASİT)
            if (!empty($selectedTag)) {
                $query->whereJsonContains('tags', $selectedTag);
            }
            
            // Normal sıralama (sadece yenilik)
            $query->orderBy('published_at', 'desc');
            
            $posts = $query->limit(10)->get();
            
        } catch (\Exception $e) {
            $posts = collect([]);
        }
        
        return view('home', [
            'posts' => $posts,
            'search' => $search,
            'selectedTag' => $selectedTag
        ]);
    }

    // Hakkımızda sayfası
    public function about()
    {
        return view('about');
    }

    // Basit etiketleri döndür
    public function getTags()
    {
        try {
            // Tüm post'lardan etiketleri topla
            $posts = Post::where('status', 'published')
                        ->whereNotNull('tags')
                        ->get();
            
            $tagCounts = [];
            
            foreach ($posts as $post) {
                if ($post->tags && is_array($post->tags)) {
                    foreach ($post->tags as $tag) {
                        $tag = trim($tag);
                        if (!empty($tag)) {
                            $tagCounts[$tag] = isset($tagCounts[$tag]) ? $tagCounts[$tag] + 1 : 1;
                        }
                    }
                }
            }
            
            // Alfabetik sıralama
            ksort($tagCounts);
            
            $tags = [];
            foreach ($tagCounts as $tag => $count) {
                $tags[] = [
                    'name' => $tag,
                    'count' => $count
                ];
            }
            
            return response()->json([
                'success' => true,
                'tags' => $tags
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'tags' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
}
