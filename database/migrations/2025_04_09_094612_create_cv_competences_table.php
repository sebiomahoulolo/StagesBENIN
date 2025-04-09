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
        Schema::create('cv_competences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained('cv_profiles')->onDelete('cascade');
            $table->string('categorie')->default('Autres'); // Ex: Développement Front-end, Back-end, Outils
            $table->string('nom'); // Ex: JavaScript (ES6+), React.js, Node.js
            $table->unsignedTinyInteger('niveau')->default(50)->comment('Niveau de 0 à 100');
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
        Schema::dropIfExists('cv_competences');
    }
};
