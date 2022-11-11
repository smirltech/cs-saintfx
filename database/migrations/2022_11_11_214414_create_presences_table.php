<?php

use App\Models\Eleve;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Eleve::class)->constrained()->restrictOnDelete();
            $table->date('date');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }
};
