<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cv_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
            $table->string('titre_profil')->nullable();
            $table->text('resume_profil')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone_cv')->nullable();
            $table->string('email_cv')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('photo_cv_path')->nullable();
            $table->string('template_slug')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->string('nationalite')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->json('completion_status')->nullable();
            $table->integer('completion_percentage')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cv_profiles');
    }
};
