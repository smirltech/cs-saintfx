<?php
use App\Http\Livewire\Finance;

Route::get('finance', Finance\Dashboard\DashboardComponent::class)->name('finance')->middleware('auth');

Route::prefix('finance')->middleware(['auth:web'])->as('finance.')->group(function () {

    // Rapport
    Route::get('rapports', Finance\Rapport\RapportIndexComponent::class)->name('rapports');

    //Revenu
    Route::get('revenus', Finance\Revenu\RevenuIndexComponent::class)->name('revenus');

    //Depense
    Route::get('depenses', Finance\Depense\DepenseIndexComponent::class)->name('depenses');

    Route::get('depense-types', Finance\DepenseType\DepenseTypeIndexComponent::class)->name('depense-types');
    Route::get('depense-types/{depenseType}', Finance\DepenseType\DepenseTypeShowComponent::class)->name('depense-types.show');

    //Frais
    Route::get('frais', Finance\Frais\FraisIndexComponent::class)->name('frais');

    //Perception
    Route::get('perceptions/create', Finance\Perception\PerceptionCreateComponent::class)->name('perceptions.create');
    Route::get('perceptions/classe_create', Finance\Perception\PerceptionClasseCreateComponent::class)->name('perceptions.classe-create');
    Route::get('perceptions/{perception}/edit', Finance\Perception\PerceptionEditComponent::class)->name('perceptions.edit');
    Route::get('perceptions', Finance\Perception\PerceptionIndexComponent::class)->name('perceptions');
    Route::get('caisse', Finance\Perception\CaisseComponent::class)->name('caisse');

    //Perception
    //Route::get('eleves', Finance\Eleve\EleveIndexComponent::class)->name('eleves');
    // Route::get('eleves/{id}', Finance\Eleve\EleveShowComponent::class)->name('eleves.show');
});

