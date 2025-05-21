<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class ModifierEntrepriseDansAnnonces extends Migration
{
    public function up()
    {
        Schema::table('annonces', function (Blueprint $table) {
            // Supprime la clé étrangère si elle existe
            if (Schema::hasColumn('annonces', 'entreprise_id')) {
                $table->dropForeign(['entreprise_id']);
                $table->dropColumn('entreprise_id');
            }

            // Ajoute un champ texte à la place
            $table->string('entreprise')->after('id'); // ou après un autre champ selon ta logique
        });
    }

    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            // Supprimer le champ texte
            $table->dropColumn('entreprise');

            // Remettre la clé étrangère si besoin
            $table->unsignedBigInteger('entreprise_id')->nullable();
            $table->foreign('entreprise_id')->references('id')->on('entreprises')->onDelete('cascade');
        });
    }
};
