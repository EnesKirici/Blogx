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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email'); // Profil resmi
            $table->text('bio')->nullable()->after('avatar'); // Kullanıcı hakkında
            $table->string('website')->nullable()->after('bio'); // Website bağlantısı
            $table->string('twitter')->nullable()->after('website'); // Twitter hesabı
            $table->string('instagram')->nullable()->after('twitter'); // Instagram hesabı
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'bio', 'website', 'twitter', 'instagram']);
        });
    }
};
