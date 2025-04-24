<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email');
            $table->unsignedBigInteger('catalogue_id');
            $table->integer('note'); // Note sur 5
            $table->text('commentaire')->nullable();
            $table->timestamps();

            // Clé étrangère
            $table->foreign('catalogue_id')->references('id')->on('catalogues')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('avis');
    }
};
