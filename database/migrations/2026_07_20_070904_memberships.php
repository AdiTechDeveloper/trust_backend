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
        //
        Schema::create('memberships',function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('membership_no')->unique()->nullable();
            $table->string('membership_type');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->enum('status',['Approved','Pending','Rejected','Expired']);
            $table->foreignID('approved_id')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
         Schema::dropIfExists('memberships');
    }
};
