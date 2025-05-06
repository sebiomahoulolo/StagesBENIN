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
        Schema::table('etudiants', function (Blueprint $table) {
            // Ajoutez la colonne 'status'. Vous pouvez ajuster le type et les options.
            // 'string' est courant. Vous pouvez ajouter une valeur par défaut.
            $table->string('status')->default('pending')->after('email'); // Ou après une autre colonne pertinente
            // Optionnel: Ajouter un index si vous filtrez souvent par statut
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            // Supprime l'index si vous l'avez ajouté
            // $table->dropIndex(['status']); // Le nom peut varier, vérifier avec `show indexes from etudiants;`
            $table->dropColumn('status');
        });
    }
};