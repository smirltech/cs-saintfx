<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('postnom');
            $table->string('prenom')->nullable();
            $table->string('sexe')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('date_naissance')->nullable();
            $table->integer('responsable_id')->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('matricule')->nullable();
            $table->timestamps();
        });
    }
};
