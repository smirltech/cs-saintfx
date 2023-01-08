<?php

use App\Models\OuvrageCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ouvrages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OuvrageCategory::class)->constrained()->restrictOnDelete();
            $table->string('titre');
            $table->string('sous_titre')->nullable();
            $table->text('resume')->nullable();
            $table->string('edition')->nullable()->comment("version de l'ouvrage");
            $table->string('lieu')->nullable()->comment("ville de publication");
            $table->string('editeur')->nullable()->comment("maison de publication");
            $table->date('date')->nullable()->comment("date de publication");
            $table->string('url')->comment("lien url de publication");
            $table->timestamps();
        });
    }
};
