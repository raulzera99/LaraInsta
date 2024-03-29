<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('medias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('path');


            // // Profile_id is a foreign key that references the id column of the profiles table.
            // $table->foreignId('profile_id')
            // ->nullable()
            // ->constrained()
            // ->onDelete('cascade');

            // // Post_id is a foreign key that references the id column of the posts table.
            // $table->foreignId('post_id')
            // ->nullable()
            // ->constrained()
            // ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('medias');
    }
};
