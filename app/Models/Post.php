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
        'status',
        'allow_comments',
        'is_featured',
        'published_at',
        'user_id',
        'views_count',
        'likes_count'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'published_at' => 'datetime'
    ];

    // User ilişkisi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Comments ilişkisi
    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->latest();
    }

    // Likes ilişkisi
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Tags ilişkisi (Many-to-Many) - YENİ
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    // Kullanıcı beğenmiş mi?
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Dinamik like sayısı
    public function getLikesCountAttribute()
    {
        return $this->attributes['likes_count'] ?? $this->likes()->count();
    }

    // Dinamik comment sayısı  
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    // Dinamik views sayısı
    public function getViewsCountAttribute()
    {
        return $this->attributes['views_count'] ?? 0;
    }

    // Tag isimlerini array olarak döndür (backward compatibility için)
    public function getTagNamesAttribute()
    {
        return $this->tags->pluck('name')->toArray();
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
