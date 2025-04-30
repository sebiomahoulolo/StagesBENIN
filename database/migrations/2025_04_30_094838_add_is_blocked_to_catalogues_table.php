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
    Schema::table('catalogues', function (Blueprint $table) {
        $table->boolean('is_blocked')->default(0);
    });
}

public function down()
{
    Schema::table('catalogues', function (Blueprint $table) {
        $table->dropColumn('is_blocked');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
};
