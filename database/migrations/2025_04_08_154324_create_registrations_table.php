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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                  ->constrained('events')
                  ->onDelete('cascade');
            $table->string('name');

            // Définir la colonne email SANS la contrainte unique directe
            $table->string('email');

            $table->timestamps();

            // Définir la contrainte unique sur la PAIRE (event_id, email)
            $table->unique(['event_id', 'email'], 'event_email_unique'); // 'event_email_unique' est un nom optionnel pour la contrainte

            // Vous pouvez garder l'index simple sur email si vous faites souvent des recherches par email seul
            // $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};