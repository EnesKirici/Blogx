<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // $this->middleware() kaldırıldı!
    
    // Admin Dashboard
    public function dashboard()
    {
        // Admin kontrolünü burada yap
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Bu sayfaya erişim yetkiniz yok!');
        }
        
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $recentPosts = Post::with('user')->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('totalUsers', 'totalPosts', 'totalComments', 'recentPosts'));
    }
    
    // Tüm blogları yönet
    public function posts()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/')->with('error', 'Bu sayfaya erişim yetkiniz yok!');
        }
        
        $posts = Post::with(['user', 'tags'])
                    ->withCount(['likes', 'comments'])
                    ->latest()
                    ->paginate(20);
        
        return view('admin.posts', compact('posts'));
    }
    
    // Blog sil (admin yetkisi)
    public function deletePost($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Yetkiniz yok!'], 403);
        }
        
        try {
            $post = Post::findOrFail($id);
            
            if ($post->featured_image) {
                $imagePath = public_path('storage/' . $post->featured_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $post->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Blog yazısı başarıyla silindi!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Silme işlemi sırasında hata oluştu!'
            ], 500);
        }
    }
    
    // Blog durumunu değiştir
    public function togglePostStatus($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Yetkiniz yok!'], 403);
        }
        
        try {
            $post = Post::findOrFail($id);
            $post->status = $post->status === 'published' ? 'draft' : 'published';
            $post->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Blog durumu güncellendi!',
                'status' => $post->status
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Güncelleme sırasında hata oluştu!'
            ], 500);
        }
    }
}