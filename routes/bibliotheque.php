<?php

use App\Http\Livewire\Bibliotheque\Auteur\AuteurIndexComponent;
use App\Http\Livewire\Bibliotheque\Auteur\AuteurShowComponent;
use App\Http\Livewire\Bibliotheque\Etiquette\EtiquetteIndexComponent;
use App\Http\Livewire\Bibliotheque\Ouvrage\OuvrageCreateComponent;
use App\Http\Livewire\Bibliotheque\Ouvrage\OuvrageIndexComponent;
use App\Http\Livewire\Bibliotheque\Ouvrage\OuvrageReadComponent;
use App\Http\Livewire\Bibliotheque\Ouvrage\OuvrageShowComponent;
use App\Http\Livewire\Bibliotheque\OuvrageCategory\OuvrageCategoryIndexComponent;
use App\Http\Livewire\Bibliotheque\OuvrageCategory\OuvrageCategoryShowComponent;
use App\Http\Livewire\Bibliotheque;

Route::get('bibliotheque', Bibliotheque\DashboardComponent::class)->name('bibliotheque')->middleware('auth');

Route::prefix('bibliotheque')->middleware(['auth:web'])->as('bibliotheque.')->group(function () {

    // Étiquettes
    Route::get('etiquettes', EtiquetteIndexComponent::class)->name('etiquettes');

    // Auteurs
    Route::get('auteurs', AuteurIndexComponent::class)->name('auteurs');
    Route::get('auteurs/{auteur}', AuteurShowComponent::class)->name('auteurs.show');

    // Categories
    Route::get('categories', OuvrageCategoryIndexComponent::class)->name('categories');
    Route::get('categories/{category}', OuvrageCategoryShowComponent::class)->name('categories.show');

    // Ouvrages
    Route::get('ouvrages', OuvrageIndexComponent::class)->name('ouvrages.index');
    Route::get('ouvrages/create', OuvrageCreateComponent::class)->name('ouvrages.create');
    Route::get('ouvrages/{ouvrage}', OuvrageShowComponent::class)->name('ouvrages.show');
    Route::get('ouvrages/{ouvrage}/edit', OuvrageCreateComponent::class)->name('ouvrages.edit');
    Route::get('ouvrages/{ouvrage}/read', OuvrageReadComponent::class)->name('ouvrages.read');

});

