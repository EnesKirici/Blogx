<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Yazarın ID'si
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Kategori ID'si
            $table->string('title'); // Yazı başlığı
            $table->string('slug')->unique(); // URL dostu başlık
            $table->text('excerpt')->nullable(); // Kısa özet
            $table->longText('content'); // Yazı içeriği
            $table->string('featured_image')->nullable(); // Ana resim
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // Yazı durumu
            $table->boolean('is_featured')->default(false); // Öne çıkarılmış yazı mı?
            $table->boolean('allow_comments')->default(true); // Yorumlara izin ver
            $table->integer('views_count')->default(0); // Görüntülenme sayısı
            $table->integer('likes_count')->default(0); // Beğeni sayısı
            $table->timestamp('published_at')->nullable(); // Yayın tarihi
            $table->timestamps();

            // İndeksler
            $table->index(['status', 'published_at']);
            $table->index(['user_id', 'status']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
