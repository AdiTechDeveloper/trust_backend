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
        Schema::table('community_family_members', function (Blueprint $table) {
            $table->dropForeign('community_family_members_community_member_id_foreign');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('community_family_members', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->foreign('user_id', 'community_family_members_community_member_id_foreign')
                ->references('id')
                ->on('community_members')
                ->onDelete('cascade');
        });
    }
};
