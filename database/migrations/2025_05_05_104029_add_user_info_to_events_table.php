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
    Schema::table('events', function (Blueprint $table) {
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('phone_number')->nullable();
        $table->string('email')->nullable();
    });
}

public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn(['first_name', 'last_name', 'phone_number', 'email']);
    });
}

};
