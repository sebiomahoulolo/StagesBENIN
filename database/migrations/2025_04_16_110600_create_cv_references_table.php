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
    public function up(): void
    {
        Schema::create('cv_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('prenom');
            $table->string('contact'); // Peut être un email ou un téléphone
            $table->string('poste')->nullable();
            $table->text('relation')->nullable(); // Nouveau champ: Relation avec le référent
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cv_references');
    }
};
