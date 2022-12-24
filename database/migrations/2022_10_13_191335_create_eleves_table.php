<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('matricule')->nullable()->unique()->comment('Matricule de l\'eleve attribue par l\'ecole');
            $table->string('nom');
            $table->string('postnom');
            $table->string('prenom')->nullable();
            $table->string('sexe')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('date_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('numero_permanent')->nullable()->unique()->comment('Numero permanent de l\'eleve attribue par le ministere de l\'education');
            $table->timestamps();
        });
    }
};
