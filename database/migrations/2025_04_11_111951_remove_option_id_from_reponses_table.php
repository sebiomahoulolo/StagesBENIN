<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reponses', function (Blueprint $table) {
            $table->dropColumn('option_id');
        });
    }

    public function down(): void
    {
        Schema::table('reponses', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id')->nullable(); // ou sans nullable si besoin
        });
    }
};
