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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // اسم الكتاب
            $table->json('author'); // اسم الكاتب
            $table->json('summary'); // نبذة مختصرة
            $table->integer('publication_year'); // سنة الإصدار
            $table->json('publisher'); // دار النشر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
