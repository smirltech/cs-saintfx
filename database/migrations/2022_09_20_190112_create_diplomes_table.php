<?php

use App\Models\Etudiant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('diplomes', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->float('pourcentage')->nullable();
            $table->string('section')->nullable();
            $table->string('option')->nullable();
            $table->string('date_delivrance')->nullable();
            $table->string('lieu_delivrance')->default('Kinshasa')->nullable();
            $table->string('ecole')->nullable();
            $table->string('code_ecole')->nullable();
            $table->string('province_ecole')->nullable();
            $table->foreignIdFor(Etudiant::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }
};
