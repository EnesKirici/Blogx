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

    public function tags()
{
    return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
}

    // Comments ilişkisi
    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->latest();
    }

    // Likes ilişkisi
    public function likes()
    {
        return $this->hasMany(\App\Models\Like::class);
    }

    // Emojiler ilişkisi
    public function emojis()
    {
        return $this->hasMany(PostEmoji::class);
    }

    // Tags ilişkisi (Many-to-Many) - SADECE BU KALACAK

    // Kullanıcı beğenmiş mi?
    public function isLikedBy($user)
    {
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

    // Tag isimlerini array olarak döndür (home.blade.php uyumluluğu için)
    public function getTagNamesAttribute()
    {
        return $this->tags->pluck('name')->toArray();
    }

    // Emoji ile ilgili metodlar
public function getEmojiCounts()
{
    return $this->emojis()
        ->selectRaw('emoji_type, COUNT(*) as count')
        ->groupBy('emoji_type')
        ->pluck('count', 'emoji_type')
        ->toArray();
}

public function getUserEmoji($userId)
{
    if (!$userId) return null;
    
    return $this->emojis()
        ->where('user_id', $userId)
        ->first();
}

public function getTotalEmojiCount()
{
    return $this->emojis()->count();
}

// Görüntülenme sayısını güvenli artırma (session bazlı)
public function incrementViewCount()
{
    $sessionKey = 'post_viewed_' . $this->id;
    
    if (!session()->has($sessionKey)) {
        $this->increment('views_count');
        session()->put($sessionKey, true);
    }
}
}
