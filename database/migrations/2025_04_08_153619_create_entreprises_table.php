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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id(); // int(11) NOT NULL AUTO_INCREMENT -> bigint unsigned
            $table->string('nom'); // varchar(255)
            $table->string('secteur')->nullable();
            $table->text('description')->nullable();
            $table->text('adresse')->nullable();
            $table->string('email'); // Le dump n'a pas d'index unique, ajoutez ->unique() si nécessaire
            $table->string('telephone', 20)->nullable();
            $table->string('site_web')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('contact_principal')->nullable();
            $table->timestamps(); // created_at et updated_at

            $table->foreignId('user_id')
                  ->nullable()             // Permet à une entreprise d'exister sans compte lié
                  ->unique()               // Assure relation 1-1 User <-> Entreprise
                  ->constrained('users')   // Clé étrangère vers la table 'users'
                  ->onDelete('cascade');   // Supprime l'entreprise si l'utilisateur est supprimé
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entreprises');
    }
};
