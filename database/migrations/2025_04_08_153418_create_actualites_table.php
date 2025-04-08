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
        Schema::create('actualites', function (Blueprint $table) {
            $table->id(); // int(11) NOT NULL AUTO_INCREMENT -> remplacé par bigint unsigned pour standard Laravel
            $table->string('titre'); // varchar(255)
            $table->text('contenu');
            $table->string('image_path')->nullable();
            $table->dateTime('date_publication');
            $table->string('categorie', 100)->nullable();
            $table->string('auteur')->nullable();
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actualites');
    }
};
