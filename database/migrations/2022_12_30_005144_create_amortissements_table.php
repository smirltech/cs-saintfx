<?php

use App\Models\Materiel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('amortissements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Materiel::class)->constrained()->restrictOnDelete();
            $table->date('date');
            $table->integer('montant')->nullable();
            $table->timestamps();
        });
    }
};
