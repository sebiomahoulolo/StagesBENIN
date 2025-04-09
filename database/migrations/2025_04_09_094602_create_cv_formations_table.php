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
        Schema::create('cv_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained('cv_profiles')->onDelete('cascade');
            $table->string('diplome'); // Ex: Master en Informatique
            $table->string('etablissement'); // Ex: Université de Paris
            $table->string('ville')->nullable();
            $table->year('annee_debut');
            $table->year('annee_fin')->nullable(); // Null si en cours
            $table->text('description')->nullable(); // Ex: Mention Très Bien, Projet...
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
        Schema::dropIfExists('cv_formations');
    }
};
