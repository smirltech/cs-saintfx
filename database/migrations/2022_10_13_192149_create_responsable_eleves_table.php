<?php

use App\Models\Eleve;
use App\Models\Responsable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('responsable_eleves', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(Eleve::class);
            $table->foreignIdFor(Responsable::class);
            $table->string('relation');
            $table->timestamps();
        });
    }
};
