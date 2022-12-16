<?php

use App\Models\Annee;
use App\Models\Eleve;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('resultats', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Eleve::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->string('custom_property')->nullable();
            $table->string('pourcentage')->nullable();
            $table->string('place')->nullable();
            $table->timestamps();
        });
    }
};
