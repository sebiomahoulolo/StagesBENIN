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
        Schema::create('cv_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade'); // Clé étrangère vers la table etudiants
            $table->string('titre_profil')->nullable()->comment('Ex: Ingénieur Développement Web');
            $table->text('resume_profil')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone_cv', 20)->nullable(); // Téléphone spécifique pour le CV
            $table->string('email_cv')->nullable();       // Email spécifique pour le CV
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();   // Lien site web/portfolio
            $table->string('photo_cv_path')->nullable(); // Option pour surcharger la photo de l'étudiant
            $table->string('template_slug')->default('default'); // Pour gérer plusieurs templates plus tard
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
        Schema::dropIfExists('cv_profiles');
    }
};
