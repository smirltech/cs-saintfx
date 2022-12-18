<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('frais', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('description')->nullable();
            $table->float('montant');
            $table->string('frequence'); //App\Enum\FraisFrequence
            $table->string('type'); //App\Enum\FraisType
            $table->morphs('classable');
            $table->integer('annee_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
