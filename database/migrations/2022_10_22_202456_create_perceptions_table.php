<?php

use App\Enums\FraisFrequence;
use App\Models\Annee;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('perceptions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('reference')->unique();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Frais::class)->constrained();
            $table->foreignIdFor(Inscription::class)->constrained();
            $table->foreignIdFor(Annee::class)->constrained();

            $table->string('frequence')->default(FraisFrequence::mensuel->name)->nullable()->comment('Fréquence de perception');
            $table->string('custom_property')->nullable()->comment('Par rapport à la fréquence, la perception concerne quelle periode');
            $table->double('montant')->nullable();
            $table->boolean('paid')->default(false);
            $table->string('paid_by')->nullable();

            $table->date('due_date')->default(Carbon::now()->format('Y-m-d'));
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['frais_id', 'inscription_id', 'custom_property', 'annee_id'], 'frais_inscription_custom_property_annee_unique');
        });
    }
};
