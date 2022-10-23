<?php

use App\Http\Controllers\Api\EleveController;
use App\Http\Resources\AnneeResource;
use App\Models\Annee;
use Orion\Facades\Orion;

Route::group(['as' => 'api.'], function () {
    Orion::resource('eleves', EleveController::class)->only(['index', 'show']);
    Route::get('annees', function () {
        return AnneeResource::collection(Annee::all());
    });
    Route::get('annees/encours', function () {
        return AnneeResource::make(Annee::encours());
    });
});
