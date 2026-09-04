<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->date('viewed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_views');
    }
};
