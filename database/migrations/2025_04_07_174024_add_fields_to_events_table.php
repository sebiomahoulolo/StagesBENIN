<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('start_date')->nullable();  // <--- nullable ici
            $table->dateTime('end_date')->nullable();    // <--- nullable ici
            $table->string('location')->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('max_participants')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->nullable();
        });
    }
    

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'description',
                'start_date',
                'end_date',
                'location',
                'type',
                'max_participants',
                'image',
                'created_at',
                'updated_at'
            ]);
        });
    }
};
