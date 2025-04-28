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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('recrutement_id');
            $table->text('lettre_motivation');
            $table->string('cv_path')->nullable();
            $table->enum('statut', ['en_attente', 'acceptee', 'refusee', 'en_cours', 'annulee'])->default('en_attente');
            $table->timestamp('date_candidature')->useCurrent();
            $table->timestamp('date_reponse')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');
            $table->foreign('recrutement_id')->references('id')->on('recrutements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatures');
    }
}; 