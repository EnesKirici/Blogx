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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Kategori adı (örn: "Teknoloji", "Seyahat")
            $table->string('slug')->unique(); // URL dostu versiyon (örn: "teknoloji", "seyahat")
            $table->text('description')->nullable(); // Kategori açıklaması
            $table->string('color', 7)->default('#3B82F6'); // Kategori rengi (hex kodu)
            $table->boolean('is_active')->default(true); // Aktif/pasif durumu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
