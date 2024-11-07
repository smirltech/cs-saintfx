<?php

use App\Enums\Devise;
use App\Models\Annee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('revenus', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('type')->nullable()->comment('Type de revenu');
            $table->string('nom');
            $table->string('description')->nullable();
            $table->double('montant')->nullable()->comment('Montant a payer');
            $table->string('devise')->default(Devise::CDF->value);
            $table->string('custom_property')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
