<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Beğeni toggle (beğen/beğenmekten vazgeç)
    public function toggle(Request $request, $slug)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Giriş yapmalısınız!'], 401);
        }

        $post = Post::where('slug', $slug)->firstOrFail();

        $existingLike = Like::where('post_id', $post->id)
                           ->where('user_id', Auth::id())
                           ->first();

        if ($existingLike) {
            // Beğeniyi kaldır
            $existingLike->delete();
            $post->decrementLikes(); // Model'deki method
            $liked = false;
            $message = 'Beğeni kaldırıldı!';
        } else {
            // Beğeni ekle
            Like::create([
                'post_id' => $post->id,
                'user_id' => Auth::id()
            ]);
            $post->incrementLikes(); // Model'deki method
            $liked = true;
            $message = 'Post beğenildi!';
        }

        $likesCount = $post->fresh()->likes_count;

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $likesCount,
            'message' => $message
        ]);
    }
}
