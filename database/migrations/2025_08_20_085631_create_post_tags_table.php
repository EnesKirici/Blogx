<?php
// filepath: c:\Users\MS\Desktop\z\Blogx\database\migrations\2025_08_20_085631_create_post_tags_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tags tablosu
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->string('slug')->unique(); 
            $table->text('description')->nullable(); 
            $table->integer('usage_count')->default(0); 
            $table->timestamps();
            
            $table->index('name');
            $table->index('slug');
        });

        // Post-Tag ilişki tablosu
        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Benzersiz ilişki
            $table->unique(['post_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('tags');
    }
};