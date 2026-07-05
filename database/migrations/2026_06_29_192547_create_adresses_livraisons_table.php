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
        Schema::create('adresses_livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acheteur_id')
                ->constrained('acheteurs')
                ->cascadeOnDelete();
            $table->string('adresse');
            $table->string('ville');
            $table->string('téléphone');
            $table->string('type')->default('domicile'); // domicile | travail | autre
            $table->boolean('par_defaut')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses_livraisons');
    }
};
