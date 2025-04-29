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
            $table->unsignedBigInteger('annonce_id');
            $table->foreign('annonce_id')->references('id')->on('annonces')->onDelete('cascade');
            $table->unsignedBigInteger('etudiant_id');
            $table->foreign('etudiant_id')->references('user_id')->on('etudiants')->onDelete('cascade');
            $table->text('lettre_motivation')->nullable();
            $table->string('cv_path')->nullable();
            $table->enum('statut', ['en_attente', 'en_cours', 'accepte', 'rejete'])->default('en_attente');
            $table->text('motif_rejet')->nullable();
            $table->timestamps();
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