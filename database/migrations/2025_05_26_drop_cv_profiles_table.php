<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('cv_profiles');
    }

    public function down()
    {
        // Cette migration ne peut pas être annulée car elle supprime la table
    }
};
