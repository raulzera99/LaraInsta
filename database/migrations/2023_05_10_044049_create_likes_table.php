<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // // Profile_id is a foreign key that references the id column of the profiles table.
            // $table->integer('profile_id');
            // $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');

            // // Post_id is a foreign key that references the id column of the posts table.
            // $table->integer('post_id');
            // $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('likes');
    }
};