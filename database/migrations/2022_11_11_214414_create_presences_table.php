<?php

use App\Models\Eleve;
use App\Models\Inscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Inscription::class)->constrained()->restrictOnDelete();
            $table->date('date');
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }
};
