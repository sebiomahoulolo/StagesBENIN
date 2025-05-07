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
        Schema::create('demande_employes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->enum('type', ['stage', 'emploi']);
            $table->string('domaine');
            $table->string('niveau_experience')->nullable();
            $table->string('niveau_etude');
            $table->text('competences_requises');
            $table->integer('nombre_postes')->default(1);
            $table->decimal('salaire_min', 10, 2)->nullable();
            $table->decimal('salaire_max', 10, 2)->nullable();
            $table->string('type_contrat');
            $table->date('date_debut');
            $table->date('date_limite')->nullable();
            $table->string('lieu');
            $table->enum('statut', ['en_attente', 'approuvee', 'rejetee', 'expiree'])->default('en_attente');
            $table->text('motif_rejet')->nullable();
            $table->boolean('est_urgente')->default(false);
            $table->boolean('est_active')->default(true);
            $table->integer('nombre_vues')->default(0);
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_employes');
    }
};
