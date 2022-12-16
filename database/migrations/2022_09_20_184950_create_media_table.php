<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('mediable');
            $table->string('mime_type');
            $table->string('filename');
            $table->string('location');
            $table->text('custom_property')->nullable();
            $table->string('collection_name')->nullable();
            $table->string('size')->nullable();
            $table->timestamps();
        });
    }
};
