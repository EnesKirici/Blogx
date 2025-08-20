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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Hangi yazıya yorum
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Yorumu yapan kullanıcı
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // Üst yorum (cevap sistemi için)
            $table->text('content'); // Yorum içeriği
            $table->boolean('is_approved')->default(true); // Onaylanmış mı? (moderasyon için)
            $table->timestamps();

            // İndeksler
            $table->index(['post_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
