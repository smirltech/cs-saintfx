<?php

use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Eleve::class)->constrained();
            $table->foreignIdFor(Classe::class)->constrained();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->string('categorie')->default(InscriptionCategorie::normal->name);
            $table->integer('montant')->nullable();
            $table->string('status')->default(InscriptionStatus::pending->value);
            $table->unique(["eleve_id", "annee_id"], 'eleve_annee');
            $table->timestamps();

        });
    }
};
