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
        Schema::table('donations', function (Blueprint $table) {
            $table->string('receipt_number')->nullable()->unique()->after('id');
            $table->string('receipt_path')->nullable()->after('receipt_number');
            $table->timestamp('receipt_generated_at')->nullable()->after('receipt_path');
            $table->timestamp('whatsapp_sent_at')->nullable()->after('receipt_generated_at');
            $table->string('whatsapp_status')->default('pending')->after('whatsapp_sent_at'); // pending, sent, failed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['receipt_number', 'receipt_path', 'receipt_generated_at', 'whatsapp_sent_at', 'whatsapp_status']);
        });
    }
};
