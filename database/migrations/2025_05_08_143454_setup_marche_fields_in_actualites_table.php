<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates or updates the actualites table to include fields for Marché Public data.
     *
     * @return void
     */
    public function up()
    {
        // Option 1: Create table if it DOES NOT exist
        if (!Schema::hasTable('actualites')) {
            Schema::create('actualites', function (Blueprint $table) {
                $table->id();
                // Standard Actualite fields (adjust if needed)
                $table->string('titre'); // Can be used for Document Title or derived title
                $table->text('contenu')->nullable(); // Could be used for Details or Document Content

                // --- New Fields for Marché Public ---
                $table->string('autorite_contractante');
                $table->year('gestion'); // Store just the year
                $table->text('details'); // Object/Details of the marche
                $table->decimal('montant', 15, 2)->nullable(); // Example: Up to 999 Trillion, 2 decimal places
                $table->string('type_marche'); // travaux, fournitures, etc.
                $table->string('mode_passation'); // appel_offres_ouvert, etc.
                $table->string('document_titre')->nullable(); // Title specifically for the PDF
                $table->string('document_path')->nullable(); // Renamed from image_path, stores path to PDF
                $table->text('document_contenu')->nullable(); // Summary of the PDF
                $table->date('date_publication');
                $table->string('categorie'); // appel_offre, avis_attribution, etc.

                // --- Author Relationship ---
                // Assuming 'auteur' was just a text field before. We add a proper foreign key.
                // If you already had a 'user_id' or 'auteur_id', adjust accordingly.
                $table->foreignId('auteur_id')->nullable()->constrained('users')->onDelete('set null'); // Link to users table
                $table->string('auteur')->nullable(); // Keep old text field maybe? Or remove if only using auteur_id

                $table->timestamps(); // created_at, updated_at
            });
        }
        // Option 2: Modify table if it DOES exist
        else {
            Schema::table('actualites', function (Blueprint $table) {

                // Rename image_path to document_path if image_path exists and document_path doesn't
                if (Schema::hasColumn('actualites', 'image_path') && !Schema::hasColumn('actualites', 'document_path')) {
                    $table->renameColumn('image_path', 'document_path');
                }
                 // Ensure document_path exists even if image_path didn't
                 if (!Schema::hasColumn('actualites', 'document_path')) {
                    $table->string('document_path')->nullable()->after('contenu'); // Add placement if desired
                }

                // Add missing columns (idempotent check)
                if (!Schema::hasColumn('actualites', 'autorite_contractante')) {
                    $table->string('autorite_contractante')->after('titre'); // Example placement
                }
                if (!Schema::hasColumn('actualites', 'gestion')) {
                    $table->year('gestion')->after('autorite_contractante');
                }
                 if (!Schema::hasColumn('actualites', 'details')) {
                    $table->text('details')->after('gestion'); // Add details column
                } else {
                     $table->text('details')->nullable()->change(); // Ensure it allows NULL if needed
                }
                 if (!Schema::hasColumn('actualites', 'montant')) {
                    $table->decimal('montant', 15, 2)->nullable()->after('details');
                }
                 if (!Schema::hasColumn('actualites', 'type_marche')) {
                    $table->string('type_marche')->nullable()->after('montant'); // Make nullable if modifying existing table
                }
                 if (!Schema::hasColumn('actualites', 'mode_passation')) {
                    $table->string('mode_passation')->nullable()->after('type_marche'); // Make nullable
                }
                 if (!Schema::hasColumn('actualites', 'document_titre')) {
                    $table->string('document_titre')->nullable()->after('mode_passation');
                }
                 if (!Schema::hasColumn('actualites', 'document_contenu')) {
                    $table->text('document_contenu')->nullable()->after('document_path');
                }

                 // Ensure date_publication and categorie exist (might already)
                 if (!Schema::hasColumn('actualites', 'date_publication')) {
                     $table->date('date_publication')->nullable()->after('document_contenu'); // Make nullable
                 } else {
                      $table->date('date_publication')->nullable()->change(); // Ensure nullable if needed
                 }
                 if (!Schema::hasColumn('actualites', 'categorie')) {
                     $table->string('categorie')->nullable()->after('date_publication'); // Make nullable
                 } else {
                      $table->string('categorie')->nullable()->change();
                 }

                 // Handle auteur relationship - Add if missing
                 if (!Schema::hasColumn('actualites', 'auteur_id')) {
                     // Add the column first
                     $table->unsignedBigInteger('auteur_id')->nullable()->after('categorie');
                     // Then add the foreign key constraint
                     // Note: Adding constraints to existing tables with data can be tricky.
                     // Best practice is often to add the column nullable, populate it, then add the constraint non-nullable if required.
                     // Or ensure the users table exists and has corresponding IDs.
                     // $table->foreign('auteur_id')->references('id')->on('users')->onDelete('set null');
                 }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This down method is simplified. A full rollback of modifications
        // can be complex. This focuses on dropping the added columns if the table existed.
        if (Schema::hasTable('actualites')) {
             Schema::table('actualites', function (Blueprint $table) {
                // Define columns to drop (only if they were added by 'up')
                $columnsToDrop = [
                    'autorite_contractante',
                    'gestion',
                    'details',
                    'montant',
                    'type_marche',
                    'mode_passation',
                    'document_titre',
                    'document_contenu',
                    // Drop auteur_id carefully, potentially remove foreign key first if added
                    // 'auteur_id', // Uncomment if added and you want to drop
                ];

                // Drop foreign key if it was added (check name if custom)
                // Need to know the conventional name or specify it if it was custom
                // $table->dropForeign(['auteur_id']); // Or $table->dropForeign('actualites_auteur_id_foreign');

                // Drop columns if they exist
                 foreach ($columnsToDrop as $column) {
                     if (Schema::hasColumn('actualites', $column)) {
                         $table->dropColumn($column);
                     }
                 }

                // Optionally rename document_path back to image_path if it was renamed
                 if (Schema::hasColumn('actualites', 'document_path') && !Schema::hasColumn('actualites', 'image_path')) {
                    $table->renameColumn('document_path', 'image_path');
                } elseif (Schema::hasColumn('actualites', 'document_path') && Schema::hasColumn('actualites', 'image_path')) {
                    // If both exist (unlikely with the 'up' logic), decide which one to drop or keep.
                    // Dropping document_path if it was added by this migration:
                    if (!isset($wasOriginallyCreated) || !$wasOriginallyCreated) { // Rough check
                       // $table->dropColumn('document_path');
                    }
                }

             });
        } else {
            // If 'up' created the table, then 'down' should drop it entirely.
            // This part is tricky because the 'up' method handles both create and modify.
            // A safer 'down' might only drop the columns added in the 'else' block of 'up'.
            // For simplicity, we might assume if the table exists, we only drop columns.
            // If you NEED full rollback for the create case, separate migrations are better.
            // Schema::dropIfExists('actualites'); // Use this only if 'up' *always* created the table
        }
    }
};