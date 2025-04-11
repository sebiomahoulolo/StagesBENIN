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
    public function up(): void
    {
        Schema::table('reponses', function (Blueprint $table) {
            $table->integer('choix_index')->nullable()->after('question_id');
        });
    }
    
    public function down(): void
    {
        Schema::table('reponses', function (Blueprint $table) {
            $table->dropColumn('choix_index');
        });
    }
    
};
