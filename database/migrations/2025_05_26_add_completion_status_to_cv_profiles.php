<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cv_profiles', function (Blueprint $table) {
            $table->json('completion_status')->nullable()->after('lieu_naissance');
        });
    }

    public function down()
    {
        Schema::table('cv_profiles', function (Blueprint $table) {
            $table->dropColumn('completion_status');
        });
    }
};
