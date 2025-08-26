<?php

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
        return $this->belongsToMany(Post::class, 'post_tags');
    }

    // Slug otomatik oluştur
    public static function createFromName($name)
    {
        $name = trim($name);
        $slug = Str::slug($name);
        
        // Aynı isimde tag var mı kontrol et
        $existingTag = self::where('name', $name)->first();
        if ($existingTag) {
            // Varsa usage_count'u artır
            $existingTag->increment('usage_count');
            return $existingTag;
        }
        
        // Yoksa yeni oluştur
        return self::create([
            'name' => $name,
            'slug' => $slug,
            'usage_count' => 1
        ]);
    }
}
