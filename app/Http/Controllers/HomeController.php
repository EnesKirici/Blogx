<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Arama sorgusu
        $search = $request->get('search');
        
        // Posts sorgusu
        $postsQuery = Post::with('user')
                         ->where('status', 'published')
                         ->orderBy('published_at', 'desc');
        
        // Eğer arama yapılmışsa filtreleme uygula
        if ($search) {
            $postsQuery->where(function($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('content', 'LIKE', '%' . $search . '%')
                      ->orWhere('excerpt', 'LIKE', '%' . $search . '%');
            });
        }
        
        $posts = $postsQuery->take(10)->get(); // 10 sonuç göster
        
        return view('home', compact('posts', 'search'));
    }
}
