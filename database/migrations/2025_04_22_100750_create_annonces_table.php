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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entreprise_id');
            $table->foreign('entreprise_id')->references('user_id')->on('entreprises');
            $table->string('nom_du_poste');
            $table->string('type_de_poste');
            $table->integer('nombre_de_place');
            $table->string('niveau_detude');
            $table->string('domaine');
            $table->string('lieu');
            $table->string('email');
            $table->dateTime('date_cloture');
            $table->text('description');

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
        Schema::dropIfExists('annonces');
    }
};
