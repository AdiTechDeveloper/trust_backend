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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('category');
            $table->string('language')->nullable();
            $table->text('description')->nullable();
            $table->string('video_url');
            $table->string('thumbail')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
