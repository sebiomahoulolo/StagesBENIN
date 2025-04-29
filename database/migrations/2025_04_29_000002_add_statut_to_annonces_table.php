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
        Schema::table('annonces', function (Blueprint $table) {
            if (!Schema::hasColumn('annonces', 'statut')) {
                $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('en_attente');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            if (Schema::hasColumn('annonces', 'statut')) {
                $table->dropColumn('statut');
            }
        });
    }
}; 