<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $selectedTag = $request->get('tag', '');
        
        // Slider için son 5 blog yazısı (görselli olanlar) - dinamik
        $sliderQuery = Post::with(['user'])
                          ->where('status', 'published')
                          ->whereNotNull('featured_image')
                          ->latest('published_at');
        
        // Eğer arama varsa slider'da da arama yap
        if (!empty($search)) {
            $sliderQuery->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }
        
        // Tag filtresi varsa slider'da da uygula
        if (!empty($selectedTag)) {
            $sliderQuery->whereHas('tags', function($q) use ($selectedTag) {
                $q->where('name', $selectedTag);
            });
        }
        
        $sliderPosts = $sliderQuery->take(5)->get();
        
        // Normal posts sorgusu
        $query = Post::with(['user', 'tags'])
                     ->withCount(['likes', 'comments'])
                     ->where('status', 'published')
                     ->latest('published_at');
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }
        
        if (!empty($selectedTag)) {
            $query->whereHas('tags', function($q) use ($selectedTag) {
                $q->where('name', $selectedTag);
            });
        }
        
        $posts = $query->get();
        
        return view('home', compact('posts', 'search', 'selectedTag', 'sliderPosts'));
    }

    public function about()
    {
        return view('about');
    }

    // API Endpoint - Sadece relational tags
    public function getTags()
    {
        try {
            $tags = Tag::has('posts')
                       ->withCount('posts')
                       ->orderBy('posts_count', 'desc')
                       ->take(10)
                       ->get();
                       
            return response()->json([
                'success' => true,
                'tags' => $tags
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tag\'lar yüklenirken hata oluştu'
            ], 500);
        }
    }
}
