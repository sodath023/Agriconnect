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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('category_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->string('nom');

        $table->text('description')->nullable();

        $table->decimal('prix',12,2);

        $table->integer('stock');

        $table->string('unite')
              ->default('kg');

        $table->string('image')->nullable();

        $table->decimal('latitude',10,7)->nullable();

        $table->decimal('longitude',10,7)->nullable();

        $table->enum('statut',[
            'en_attente',
            'valide',
            'rejete'
        ])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

