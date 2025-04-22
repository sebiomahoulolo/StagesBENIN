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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT
            $table->foreignId('event_id') // FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
                  ->constrained('events')
                  ->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique(); // UNIQUE KEY `registrations_email_unique` (`email`)
            $table->timestamps(); // created_at et updated_at (nullable)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};
