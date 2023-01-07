<?php

use App\Models\OuvrageCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ouvrage_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OuvrageCategory::class)->nullable()->constrained()->restrictOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
};
