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
        Schema::create('cv_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained('cv_profiles')->onDelete('cascade');
            $table->string('poste'); // Ex: Lead Développeur Front-end
            $table->string('entreprise'); // Ex: Technologie Innovante Inc.
            $table->string('ville')->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable(); // Null si poste actuel
            $table->text('description')->nullable(); // Description générale
            $table->text('taches_realisations')->nullable(); // Liste des tâches/réalisations (peut être JSON ou texte formaté)
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('cv_experiences');
    }
};
