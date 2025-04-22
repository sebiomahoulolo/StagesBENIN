<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cv_profiles', function (Blueprint $table) {
            // Ajoute les nouvelles colonnes après 'portfolio_url' ou une autre colonne existante pertinente
            $table->string('situation_matrimoniale')->nullable()->after('portfolio_url');
            $table->string('nationalite')->nullable()->after('situation_matrimoniale');
            $table->date('date_naissance')->nullable()->after('nationalite');
            $table->string('lieu_naissance')->nullable()->after('date_naissance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cv_profiles', function (Blueprint $table) {
            // Supprime les colonnes si la migration est annulée
            $table->dropColumn([
                'situation_matrimoniale',
                'nationalite',
                'date_naissance',
                'lieu_naissance'
            ]);
        });
    }
}; 