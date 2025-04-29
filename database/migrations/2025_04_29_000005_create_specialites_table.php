<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('specialites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secteur_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('specialites');
    }
}; 