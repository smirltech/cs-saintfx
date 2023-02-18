<?php

use App\Models\Ouvrage;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ouvrage_etiquettes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ouvrage::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Tag::class)->constrained()->restrictOnDelete();
            $table->timestamps();
        });
    }
};
