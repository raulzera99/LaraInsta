<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            
            
            // // User_id is a foreign key that references the id column of the users table.
            // $table->foreignId('user_id')
            // ->constrained()
            // ->onDelete('cascade');

            // // Profile_id is a foreign key that references the id column of the medias table.
            // $table->foreignId('profile_image_id')
            // ->nullable()
            // ->constrained()
            // ->onDelete('cascade');

            // // $table->integer('profile_image_id')->nullable();
            // // $table->foreign('profile_image_id')->references('id')->on('medias')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('profiles');
    }
};
