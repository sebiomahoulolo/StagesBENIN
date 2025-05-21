<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('actualites', function (Blueprint $table) {
            // Add status column after 'categorie', default to 'draft'
            if (!Schema::hasColumn('actualites', 'status')) {
                 $table->string('status')->default('draft')->after('categorie')->index(); // draft, published
            }
             // Ensure auteur_id is nullable if not already
             if (Schema::hasColumn('actualites', 'auteur_id')) {
                 $table->unsignedBigInteger('auteur_id')->nullable()->change();
             }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actualites', function (Blueprint $table) {
            if (Schema::hasColumn('actualites', 'status')) {
                $table->dropColumn('status');
            }
             // You might want to revert nullable change for auteur_id if needed
        });
    }
};