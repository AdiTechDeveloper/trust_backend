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
            $table->string('designation')->nullable();
            $table->string('company_name')->nullable();

            $table->enum('source_type', [
                'registration',
                'community',
                'gaushala_donation',
                'bhojanshala_donation',
            ])->default('registration');

            $table->boolean('is_donor')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'designation',
                'company_name',
                'source_type',
                'is_donor',
            ]);
        });
    }
};
