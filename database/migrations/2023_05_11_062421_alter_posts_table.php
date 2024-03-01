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
        Schema::table('posts', function (Blueprint $table) {

            // Profile_id is a foreign key that references the id column of the profiles table.
            $table->foreignId('profile_id')
            ->constrained()
            ->onDelete('cascade');

            // Like_id is a foreign key that references the id column of the likes table.
            $table->foreignId('like_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
