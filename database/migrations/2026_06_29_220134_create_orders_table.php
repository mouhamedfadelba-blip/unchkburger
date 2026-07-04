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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Client ayant passé la commande
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Référence de la commande
            $table->string('reference')->unique();

            // Montant total
            $table->decimal('total_amount', 10, 2);

            // Statut de la commande
            $table->enum('status', [
                'en_attente',
                'en_preparation',
                'prete',
                'payee',
                'annulee'
            ])->default('en_attente');

            // Date de paiement
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};