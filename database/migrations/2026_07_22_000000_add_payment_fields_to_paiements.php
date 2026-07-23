<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     * Ajout des champs nécessaires pour la simulation du paiement mobile money
     */
    public function up(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            // Ajout du numéro de téléphone pour le paiement mobile money
            $table->string('phone_number')->nullable()->after('methode');
            
            // Type d'opérateur (MTN, Moov)
            $table->enum('operator', ['MTN', 'Moov', 'other'])->nullable()->after('phone_number');
            
            // Date et heure du paiement
            $table->timestamp('payment_date')->nullable()->after('statut');
            
            // Motif d'échec du paiement (optionnel)
            $table->text('failure_reason')->nullable()->after('payment_date');
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'operator', 'payment_date', 'failure_reason']);
        });
    }
};
