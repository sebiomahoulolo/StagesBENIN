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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id(); // int(11) NOT NULL AUTO_INCREMENT -> bigint unsigned
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('email')->unique(); // UNIQUE KEY `email` (`email`)
            $table->string('telephone', 20)->nullable();
            $table->string('formation')->nullable();
            $table->string('niveau', 50)->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps(); // created_at et updated_at

            $table->foreignId('user_id')
                  ->nullable()           // Permet à un étudiant d'exister sans compte lié
                  ->unique()             // Assure relation 1-1 User <-> Etudiant
                  ->constrained('users') // Clé étrangère vers la table 'users'
                  ->onDelete('cascade'); // Supprime l'étudiant si l'utilisateur est supprimé
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
};
