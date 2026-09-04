<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slots', function (Blueprint $table) {
            $table->id();
            $table->string('slot_code')->unique(); // FOTO_1, FOTO_2, FOTO_3, FOTO_4, FOTO_5, FOTO_6, FOTO_7
            $table->foreignId('article_id')->nullable()->constrained('articles')->onDelete('set null');
            $table->string('override_title')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slots');
    }
};
