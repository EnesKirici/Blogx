<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $selectedTag = $request->get('tag');
        
        $query = Post::with(['user', 'tags']) // tags eklendi
                     ->withCount(['likes', 'comments'])
                     ->where('status', 'published')
                     ->latest('published_at');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }
        
        if ($selectedTag) {
            $query->whereHas('tags', function($q) use ($selectedTag) {
                $q->where('name', $selectedTag);
            });
        }
        
        $posts = $query->get();
        
        return view('home', compact('posts', 'search', 'selectedTag'));
    }
    

    public function about()
    {
        return view('about');
    }



    // API Endpoint - Sadece relational tags
    public function getTags()
    {
        try {
            $tags = Tag::orderBy('usage_count', 'desc')
                      ->orderBy('name', 'asc')
                      ->get();
            
            $tagsArray = [];
            foreach ($tags as $tag) {
                $tagsArray[] = [
                    'name' => $tag->name,
                    'count' => $tag->usage_count,
                    'slug' => $tag->slug
                ];
            }
            
            return response()->json([
                'success' => true,
                'tags' => $tagsArray
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
