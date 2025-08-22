<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug', 
        'content',
        'excerpt',
        'featured_image',
        'tags',
        'status',
        'allow_comments',
        'is_featured',
        'published_at',
        'user_id'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'published_at' => 'datetime'
    ];

    // Yazarla ilişki
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Yorumlar ilişkisi (YENİ)
    public function comments()
    {
        return $this->hasMany(Comment::class)->approved()->latest();
    }

    // Beğeniler ilişkisi (YENİ)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Toplam beğeni sayısı
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    // Toplam yorum sayısı
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    // Kullanıcı bu post'u beğenmiş mi?
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Slug otomatik oluştur
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title) . '-' . uniqid();
            }
        });
    }

    // Yayında olanlar
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Görüntülenme artır
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    // Kullanıcı bu post'un sahibi mi?
    public function isOwnedBy($user)
    {
        return $this->user_id === $user->id;
    }
}
