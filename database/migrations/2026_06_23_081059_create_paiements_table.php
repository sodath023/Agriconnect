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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->decimal('montant',12,2);

        $table->string('methode');

        $table->string('reference')
              ->nullable();

        $table->enum('statut',[
            'PENDING',
            'SUCCESS',
            'FAILED'
        ])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
