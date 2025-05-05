<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            // Ajout de la relation avec specialite
            $table->foreignId('specialite_id')->nullable()->constrained()->onDelete('set null');
        });

        Schema::table('entreprises', function (Blueprint $table) {
            // Le secteur est déjà présent comme string, on le garde tel quel pour l'instant
            // car il permet plus de flexibilité pour les entreprises
        });
    }

    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropForeign(['specialite_id']);
            $table->dropColumn('specialite_id');
        });
    }
};