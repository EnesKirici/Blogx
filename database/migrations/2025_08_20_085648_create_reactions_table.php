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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tepki veren kullanıcı
            $table->morphs('reactable'); // Polymorphic ilişki (post veya comment olabilir)
            $table->enum('type', ['like', 'love', 'laugh', 'angry', 'sad', 'wow']); // Tepki türü
            $table->timestamps();

            // Aynı kullanıcı aynı içeriğe sadece bir tepki verebilir
            $table->unique(['user_id', 'reactable_id', 'reactable_type']);
            
            // İndeksler
            $table->index(['reactable_id', 'reactable_type', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
