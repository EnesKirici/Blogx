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
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Hangi yazıya ait
            $table->string('filename'); // Dosya adı
            $table->string('original_name'); // Orijinal dosya adı
            $table->string('path'); // Dosya yolu
            $table->string('alt_text')->nullable(); // Alt metin (SEO için)
            $table->integer('size'); // Dosya boyutu (byte)
            $table->string('mime_type'); // Dosya türü (image/jpeg, image/png vb.)
            $table->integer('width')->nullable(); // Resim genişliği
            $table->integer('height')->nullable(); // Resim yüksekliği
            $table->integer('order')->default(0); // Sıralama
            $table->timestamps();

            // İndeksler
            $table->index(['post_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};
