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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Etiket adı (örn: "laravel", "php", "javascript")
            $table->string('slug')->unique(); // URL dostu versiyon
            $table->string('color', 7)->default('#10B981'); // Etiket rengi
            $table->boolean('is_active')->default(true); // Aktif/pasif durumu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
