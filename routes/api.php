<?php

use App\Http\Controllers\Api\EleveController;
use Orion\Facades\Orion;

Route::group(['as' => 'api.'], function () {
    Orion::resource('eleves', EleveController::class)->only(['index', 'show']);
    /* Orion::hasManyResource('eleves', 'inscriptions', EleveInscriptionsController::class)->only(['index', 'show']);
     Orion::hasManyResource('eleves', 'reponsables', EleveResponsablesController::class)->only(['index', 'show']);*/
});
