<?php

use App\Models\Annee;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('categorie'); //App\Enum\DepenseCategorie
            $table->float('montant');
            $table->mediumText('note')->nullable();
            $table->string('reference')->nullable();
            $table->foreignIdFor(Annee::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }
};
