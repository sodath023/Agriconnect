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
        Schema::table('acheteurs', function (Blueprint $table) {
            $table->string('typeacheteur')->default('particulier')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acheteurs', function (Blueprint $table) {
            $table->boolean('typeacheteur')->default(false)->change();
        });
    }
};
