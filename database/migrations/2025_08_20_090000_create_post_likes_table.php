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
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Beğenen kullanıcı
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Beğenilen yazı
            $table->timestamps();

            // Aynı kullanıcı aynı yazıyı sadece bir kez beğenebilir
            $table->unique(['user_id', 'post_id']);
            
            // İndeks
            $table->index(['post_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_likes');
    }
};
