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
        Schema::create('complaints_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'plainte' ou 'suggestion'
            $table->string('sujet');
            $table->text('contenu');
            $table->unsignedBigInteger('etudiant_id')->nullable(); // nullable pour permettre l'anonymat
            $table->boolean('is_anonymous')->default(false);
            $table->string('photo_path')->nullable(); // Chemin vers la photo de preuve
            $table->string('statut')->default('nouveau'); // 'nouveau', 'en_cours', 'résolu'
            $table->text('reponse')->nullable(); // réponse de l'administrateur
            $table->timestamps();
            
            // Contrainte de clé étrangère
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaints_suggestions');
    }
}; 