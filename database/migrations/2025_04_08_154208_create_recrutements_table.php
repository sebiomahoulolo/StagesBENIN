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
        Schema::create('recrutements', function (Blueprint $table) {
            $table->id(); // int(11) NOT NULL AUTO_INCREMENT -> bigint unsigned
            $table->foreignId('entreprise_id') // FOREIGN KEY (`entreprise_id`) REFERENCES `entreprises` (`id`)
                  ->constrained('entreprises')
                  ->onDelete('restrict'); // SQL n'a pas spécifié, restrict est plus sûr par défaut
            $table->string('titre'); // varchar(255)
            $table->string('type_contrat', 100);
            $table->text('description');
            $table->text('competences_requises')->nullable();
            $table->date('date_debut')->nullable();
            $table->string('lieu')->nullable();
            $table->string('salaire', 100)->nullable();
            $table->date('date_expiration')->nullable();
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
        Schema::dropIfExists('recrutements');
    }
};
