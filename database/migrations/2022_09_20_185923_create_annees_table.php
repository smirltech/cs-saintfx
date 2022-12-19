<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('annees', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('encours')->default(false);
            $table->timestamps();
        });
    }
};
