<?php

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Enseignant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('classe_enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Classe::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Enseignant::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }
};
