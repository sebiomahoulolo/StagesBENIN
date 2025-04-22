<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
        public function up(): void
        {
            Schema::create('catalogues', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('titre');
                $table->text('description');
                $table->string('logo')->nullable();
                $table->string('localisation');
                $table->integer('nb_activites');
                $table->string('activite_principale');
                $table->text('desc_activite_principale');
                $table->string('activite_secondaire')->nullable();
                $table->text('desc_activite_secondaire')->nullable();
                $table->text('autres')->nullable();
                $table->string('image')->nullable();
                $table->timestamps(); // created_at et updated_at
            });
        }
    
        public function down(): void
        {
            Schema::dropIfExists('catalogues');
        }
    };
    

