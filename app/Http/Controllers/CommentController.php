<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Yorum ekleme
    public function store(Request $request, $slug)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Yorum yapmak için giriş yapmalısınız!');
        }

        $post = Post::where('slug', $slug)->firstOrFail();

        if (!$post->allow_comments) {
            return redirect()->back()->with('error', 'Bu yazıda yorumlara izin verilmiyor!');
        }

        $request->validate([
            'content' => 'required|string|min:3|max:1000'
        ], [
            'content.required' => 'Yorum içeriği zorunludur.',
            'content.min' => 'Yorum en az 3 karakter olmalıdır.',
            'content.max' => 'Yorum en fazla 1000 karakter olabilir.'
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return redirect()->back()->with('success', 'Yorumunuz başarıyla eklendi!');
    }

    // Yorum silme (sadece yorum sahibi)
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (!Auth::check() || $comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bu yorumu silme yetkiniz yok!');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Yorumunuz silindi!');
    }
}
