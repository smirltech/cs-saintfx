<?php

use App\Models\Annee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('revenus', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('nom');
            $table->string('description')->nullable();
            $table->float('montant');
            $table->foreignIdFor(Annee::class)->constrained();
            $table->timestamps();
        });
    }
};
