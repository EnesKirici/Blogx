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
            $table->string('surname')->nullable()->after('name');      // Soyad (name'den sonra)
            $table->string('gender')->nullable()->after('email');      // Cinsiyet (email'den sonra)
            $table->string('city')->nullable()->after('gender');       // Şehir (gender'dan sonra)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['surname', 'gender', 'city']);
        });
    }
};
