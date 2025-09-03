<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostEmoji extends Model
{
    protected $fillable = [
        'post_id',
        'user_id', 
        'emoji_type'
    ];

    // İlişkiler
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Emoji türleri ve simgeleri
    public static function getEmojiTypes(): array
    {
        return [
            'super' => '👍',
            'love' => '❤️', 
            'funny' => '😂',
            'wow' => '😮',
            'sad' => '😢',
            'angry' => '😡'
        ];
    }

    // Emoji türlerinin Türkçe isimleri
    public static function getEmojiLabels(): array
    {
        return [
            'super' => 'Süper',
            'love' => 'Harika', 
            'funny' => 'Komik',
            'wow' => 'Şaşırtıcı',
            'sad' => 'Üzücü',
            'angry' => 'Kızgın'
        ];
    }

    // Emoji renkleri
    public static function getEmojiColors(): array
    {
        return [
            'super' => '#28a745',
            'love' => '#dc3545', 
            'funny' => '#ffc107',
            'wow' => '#17a2b8',
            'sad' => '#6c757d',
            'angry' => '#fd7e14'
        ];
    }
}
