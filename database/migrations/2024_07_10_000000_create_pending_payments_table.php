<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pending_payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->unsignedBigInteger('etudiant_id');
            $table->string('formule');
            $table->integer('montant');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_payments');
    }
}; 