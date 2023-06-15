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
        Schema::table('role_permission', function (Blueprint $table) {
            
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete()->cascadeOnUpdate();

            $table->primary(['role_id', 'permission_id']);

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
