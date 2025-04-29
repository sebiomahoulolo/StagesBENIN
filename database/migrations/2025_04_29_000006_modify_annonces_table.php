<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->foreignId('secteur_id')->nullable()->constrained();
            $table->foreignId('specialite_id')->nullable()->constrained();
            $table->decimal('pretension_salariale', 10, 2)->nullable();
            $table->dropColumn('domaine');
        });
    }

    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropForeign(['secteur_id']);
            $table->dropForeign(['specialite_id']);
            $table->dropColumn(['secteur_id', 'specialite_id', 'pretension_salariale']);
            $table->string('domaine');
        });
    }
}; 