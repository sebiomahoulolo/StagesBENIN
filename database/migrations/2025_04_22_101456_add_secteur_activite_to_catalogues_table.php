<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('catalogues', function (Blueprint $table) {
            $table->string('secteur_activite')->nullable()->after('titre'); // Ajoute la colonne après 'titre'
        });
    }

    public function down()
    {
        Schema::table('catalogues', function (Blueprint $table) {
            $table->dropColumn('secteur_activite'); // Suppression en cas de rollback
        });
    }
};