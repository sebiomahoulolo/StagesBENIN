<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatutToEtudiantsTable extends Migration
{
    /**
     * Ajoute la colonne `statut` à la table `etudiants`.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->boolean('statut')->default(1)->after('formation'); // 1 = actif par défaut
        });
    }

    /**
     * Supprime la colonne `statut`.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
}
