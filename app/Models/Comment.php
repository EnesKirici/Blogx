<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Yorum sahibi kullanıcı
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Yorumun ait olduğu post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Onaylı yorumlar
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
}
