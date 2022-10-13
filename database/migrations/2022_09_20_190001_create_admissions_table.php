<?php

use App\Enum\AdmissionStatus;
use App\Models\Annee;
use App\Models\Etudiant;
use App\Models\Promotion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Etudiant::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Promotion::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Promotion::class, 'promotion2_id')->nullable();
            $table->foreignIdFor(Annee::class)->constrained()->restrictOnDelete();
            $table->string('status')->default(AdmissionStatus::pending->value);
            $table->string('code')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
