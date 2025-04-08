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
        Schema::create('catalogue', function (Blueprint $table) {
            $table->id(); // int(11) NOT NULL AUTO_INCREMENT -> bigint unsigned
            $table->string('titre'); // varchar(255)
            $table->text('description');
            $table->string('duree', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('niveau', 100)->nullable();
            $table->text('pre_requis')->nullable();
            $table->text('contenu')->nullable();
            $table->string('image_path')->nullable();
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
        Schema::dropIfExists('catalogue');
    }
};
