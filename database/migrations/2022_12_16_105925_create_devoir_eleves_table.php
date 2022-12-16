<?php

use App\Models\Devoir;
use App\Models\Eleve;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('devoir_eleves', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Devoir::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Eleve::class)->constrained()->restrictOnDelete();
            $table->longText('contenu')->nullable();
            $table->timestamps();
        });
    }
};
