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
        Schema::table('lignecommandes', function (Blueprint $table) {
            // Décision du producteur propriétaire du produit de cette ligne,
            // indépendante du statut de paiement stocké sur "commandes".
            // Valeurs possibles : en_attente | confirmee | refusee | expiree
            $table->string('statut_producteur')->default('en_attente')->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lignecommandes', function (Blueprint $table) {
            $table->dropColumn('statut_producteur');
        });
    }
};