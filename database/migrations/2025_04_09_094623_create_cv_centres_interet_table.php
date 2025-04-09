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
        Schema::create('cv_centre_interets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_profile_id')->constrained('cv_profiles')->onDelete('cascade');
            $table->string('nom'); // Ex: Photographie, Voyages
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
        Schema::dropIfExists('cv_centres_interet');
    }
};
