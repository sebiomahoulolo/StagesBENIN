<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tier', function (Blueprint $table) {
            $table->id(); // Colonne ID auto-incrémentée (bigint unsigned)

            // Clé étrangère vers la table users
            // Assurez-vous que votre table users existe !
            $table->foreignId('user_id')
                  ->constrained('users') // Lie à la table 'users' et à la colonne 'id' par défaut
                  ->onDelete('cascade'); // Optionnel: supprime les tiers si l'utilisateur est supprimé

            $table->string('title'); // Correspond à 'title' (varchar)
            $table->text('description')->nullable(); // Correspond à 'description' (text, peut être null)
            $table->decimal('price', 10, 2)->default(0.00); // Correspond à 'price' (decimal pour la précision monétaire)
            $table->integer('duration')->comment('Durée en mois'); // Correspond à 'duration' (integer)
            // $table->string('duration_unit')->nullable(); // Décommenter si la colonne existe vraiment
            $table->integer('visibility_level')->default(0); // Correspond à 'visibility_level' (integer)
            $table->json('extra_features')->nullable(); // Correspond à 'extra_features' (type JSON natif si supporté, sinon TEXT)
            $table->string('transaction_id')->nullable()->index(); // Correspond à 'transaction_id' (varchar, peut être null, indexé pour recherche rapide)
            $table->string('payment_status', 50)->nullable()->default('pending'); // Correspond à 'payment_status' (varchar avec longueur max, peut être null)
            $table->timestamp('payment_date')->nullable(); // Correspond à 'payment_date' (timestamp, peut être null)
            $table->boolean('is_purchasable')->default(true); // Correspond à 'is_purchasable' (boolean)

            $table->timestamps(); // Ajoute les colonnes created_at et updated_at (timestamp nullable)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Important : désactiver temporairement les contraintes de clé étrangère
        // peut être nécessaire selon le SGBD et l'ordre de suppression des tables.
        // Schema::disableForeignKeyConstraints(); // Décommenter si nécessaire

        Schema::dropIfExists('tier');

        // Schema::enableForeignKeyConstraints(); // Décommenter si nécessaire
    }
};