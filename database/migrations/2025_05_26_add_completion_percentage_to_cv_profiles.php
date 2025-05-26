<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cv_profiles', function (Blueprint $table) {
            $table->integer('completion_percentage')->nullable()->after('completion_status');
        });
    }

    public function down()
    {
        Schema::table('cv_profiles', function (Blueprint $table) {
            $table->dropColumn('completion_percentage');
        });
    }
};
