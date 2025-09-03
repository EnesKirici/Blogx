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
        Schema::create('post_emojis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('emoji_type', 20); // super, love, funny, wow, sad, angry
            $table->timestamps();
            
            // Bir kullanıcı bir post'a sadece bir emoji verebilir
            $table->unique(['post_id', 'user_id'], 'post_user_emoji_unique');
            $table->index(['post_id', 'emoji_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_emojis');
    }
};
