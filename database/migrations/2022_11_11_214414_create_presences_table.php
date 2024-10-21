<?php

use App\Enums\PresenceStatus;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Inscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Classe::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->date('date');
            $table->integer('present_filles')->default(0);
            $table->integer('present_garcons')->default(0);
            $table->integer('absent_filles')->default(0);
            $table->integer('absent_garcons')->default(0);
            $table->integer('total_presents')->default(0);
            $table->integer('total_absents')->default(0);
            $table->text('observation')->nullable();
            $table->timestamps();
            $table->unique(['classe_id', 'date', 'annee_id']);
        });
    }
};
