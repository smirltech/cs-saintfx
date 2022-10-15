<?php

use App\Enum\EtatCivil;
use App\Enum\EtudiantStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();

            $table->string('telephone')->unique()->nullable();
            $table->string('email')->unique();

            $table->string('nom')->nullable();
            $table->string('postnom')->nullable();
            $table->string('prenom')->nullable();

            $table->string('matricule')->unique()->nullable();

            $table->string('sexe')->nullable();
            $table->string('etat_civil')->default(EtatCivil::single->value)->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('adresse')->nullable();

            $table->string('mere')->nullable();
            $table->string('pere')->nullable();
            $table->string('tuteur')->nullable();
            $table->string('origine')->nullable()->comment('Origine de parents');
            $table->string('contact_urgence')->nullable();
            $table->string('adresse_urgence')->nullable();


            $table->string('step');
            $table->string('status')->default(EtudiantStatus::pending->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
