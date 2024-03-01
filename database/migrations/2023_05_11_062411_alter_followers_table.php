<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        // Profile_id is a foreign key that references the id column of the profiles table.
        Schema::table('followers', function (Blueprint $table) {
            $table->foreign('profile_from_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->foreign('profile_to_id')->references('id')->on('profiles')->onDelete('cascade');
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
