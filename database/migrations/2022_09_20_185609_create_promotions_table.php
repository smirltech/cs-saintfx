<?php

use App\Models\Filiere;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Filiere::class)->constrained()->restrictOnDelete();
            $table->string('grade');
            $table->string('code')->unique()->comment('Ex: BAC1 ISI');
            $table->timestamps();
        });
    }
};
