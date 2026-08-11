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
        Schema::create('poojas', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description');
            $table->decimal('price',10,2);
            $table->string('duration')->nullable();
            $table->string('timings')->nullable();
            $table->text('location')->nullable();
            $table->json('benefits')->nullable();
            $table->json('samagri')->nullable();
            $table->longText('process')->nullable();
            $table->string('photo')->nullable();
            $table->json('gallery');

            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poojas');
    }
};
