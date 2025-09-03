<?php
// filepath: c:\Users\MS\Desktop\z\Blogx\app\Models\Tag.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug', 
        'description',
        'usage_count'
    ];

    // Posts ilişkisi (Many-to-Many)
    public function posts()
{
    return $this->belongsToMany(Post::class, 'post_tags', 'tag_id', 'post_id');
}

    // Tag oluştur veya mevcut olanı getir
    public static function createFromName($name)
    {
        $name = trim($name);
        $slug = Str::slug($name);
        
        // Mevcut tag'i kontrol et
        $existingTag = self::where('name', $name)->first();
        if ($existingTag) {
            $existingTag->increment('usage_count');
            return $existingTag;
        }
        
        // Yeni tag oluştur
        return self::create([
            'name' => $name,
            'slug' => $slug,
            'usage_count' => 1
        ]);
    }

    // Kullanılmayan tag'ları temizleme method'u
    private function cleanupUnusedTags()
{
    $unusedTagIds = \Illuminate\Support\Facades\DB::table('tags')
        ->leftJoin('post_tags', 'tags.id', '=', 'post_tags.tag_id')
        ->whereNull('post_tags.tag_id')
        ->pluck('tags.id');
    
    if ($unusedTagIds->count() > 0) {
        \App\Models\Tag::whereIn('id', $unusedTagIds)->delete();
    }
}

    
}
