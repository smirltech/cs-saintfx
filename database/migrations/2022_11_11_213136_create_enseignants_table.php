<?php

use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('matricule')->unique()->nullable();
            $table->string('adresse')->nullable();
            $table->string('sexe')->nullable();
            $table->string('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->default('Congolaise');
            $table->foreignIdFor(Section::class)->constrained()->restrictOnDelete();

            $table->string('grade')->nullable();
            $table->string('specialite')->nullable();
            $table->string('diplome')->nullable();
            $table->string('date_embauche')->nullable();
            $table->string('date_depart')->nullable();
            $table->string('motif_depart')->nullable();
            $table->string('etat')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
};
