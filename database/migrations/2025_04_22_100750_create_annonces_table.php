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
            $table->foreignId('entreprise_id')->constrained('entreprises');
            $table->string('nom_du_poste');
            $table->string('type_de_poste');
            $table->integer('nombre_de_place');
            $table->string('niveau_detude');
            $table->string('domaine');
            $table->string('lieu');
            $table->string('email');
            $table->dateTime('date_cloture');
            $table->text('description');
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('en_attente');
            $table->text('motif_rejet')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->string('slug')->unique();
            $table->boolean('est_active')->default(true);
            $table->integer('nombre_vues')->default(0);
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
