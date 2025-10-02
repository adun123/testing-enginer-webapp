<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_coas', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Salary, Other Income, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_coas');
    }
};
