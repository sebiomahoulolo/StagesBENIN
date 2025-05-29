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
        Schema::table('examens', function (Blueprint $table) {
            // Ajouter la colonne bonnes_reponses après total_questions
            $table->integer('bonnes_reponses')->default(0)->after('total_questions');
            
            // Ajouter la colonne reponses pour sauvegarder toutes les réponses (optionnel)
            $table->longText('reponses')->nullable()->after('bonnes_reponses');
            
            // Ajouter la colonne date_passage pour tracer quand l'examen a été passé
            $table->timestamp('date_passage')->nullable()->after('reponses');
            
            // Ajouter un index sur etudiant_id pour optimiser les recherches
            $table->index('etudiant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examens', function (Blueprint $table) {
            // Supprimer l'index
            $table->dropIndex(['etudiant_id']);
            
            // Supprimer les colonnes ajoutées
            $table->dropColumn([
                'bonnes_reponses',
                'reponses',
                'date_passage'
            ]);
        });
    }
};