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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('date_ajout')->default(now());
            $table->date('date_debut')->nullable();
            $table->date('date_echeance')->nullable();
            $table->enum('categorie',['sous_contrat', 'pas_de_contrat'])->default('pas_de_contrat');
            $table->string('entreprise'); 
            $table->enum('statut', ['en_cours', 'terminee', 'a_venir', 'en_attente', 'annulee'])->default('en_cours');
            $table->enum('priorite', ['faible', 'moyenne', 'haute'])->default('moyenne');
            $table->text('commentaires');
          

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
