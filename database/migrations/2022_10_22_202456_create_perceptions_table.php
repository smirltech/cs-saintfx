<?php

use App\Models\Frais;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('perceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Frais::class)->constrained();
            $table->integer('inscription_id')->nullable();
            $table->string('custom_property')->nullable();
            $table->integer('annee_id');
            $table->integer('montant')->nullable()->default(0);
            $table->integer('paid')->nullable()->default(0);
            $table->string('paid_by')->nullable();
            $table->unique(["frais_id", "inscription_id", "custom_property", "annee_id"], 'frais_inscription_annee');
            $table->date('due_date')->default(Carbon::now()->format('Y-m-d'));
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
