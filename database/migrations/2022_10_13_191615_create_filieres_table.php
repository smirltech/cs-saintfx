<?php

use App\Models\Option;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('filieres', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Option::class)->constrained();
            $table->string('nom')->unique();
            $table->mediumText('description')->nullable();
            $table->string('code')->unique();
            $table->timestamps();
        });
    }
};
