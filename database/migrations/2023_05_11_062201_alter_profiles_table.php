<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::table('profiles', function (Blueprint $table) {
            
            // User_id is a foreign key that references the id column of the users table.
            $table->foreignId('user_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            // Profile_id is a foreign key that references the id column of the medias table.
            $table->foreignId('medias_id')
            ->nullable()
            ->constrained()
            ->onDelete('cascade');

            // Like_id is a foreign key that references the id column of the likes table.
            // $table->foreignId('likes_id')
            // ->nullable()
            // ->constrained()
            // ->onDelete('cascade');

            // $table->integer('profile_image_id')->nullable();
            // $table->foreign('profile_image_id')->references('id')->on('medias')->onDelete('cascade');
            

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
