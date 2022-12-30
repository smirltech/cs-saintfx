<?php

use App\Enums\MaterialStatus;
use App\Models\Materiel;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Materiel::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(User::class, 'borrower_id')->constrained('users', 'id')->restrictOnDelete();
            $table->foreignIdFor(User::class, 'lender_out_id')->constrained('users', 'id')->restrictOnDelete();
            $table->date('date_out')->nullable();
            $table->string('status_out')->default(MaterialStatus::ok->name);
            $table->foreignIdFor(User::class, 'lender_in_id')->nullable()->constrained('users', 'id')->restrictOnDelete();
            $table->date('date_in')->nullable();
            $table->string('status_in')->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }
};
