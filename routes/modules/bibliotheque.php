<?php

use App\Http\Livewire\Bibliotheque;
use App\Http\Livewire\Bibliotheque\Auteur;
use App\Http\Livewire\Bibliotheque\Ouvrage;
use App\Http\Livewire\Bibliotheque\OuvrageCategory;
use App\Http\Livewire\Bibliotheque\Tags;

Route::get('bibliotheque', Bibliotheque\DashboardComponent::class)->name('bibliotheque')->middleware('auth');

Route::prefix('bibliotheque')->middleware(['auth:web'])->as('bibliotheque.')->group(function () {

    // Étiquettes
    Route::get('etiquettes', Tags\TagsIndexComponent::class)->name('etiquettes');

    // Auteurs
    Route::get('auteurs', Auteur\AuteurIndexComponent::class)->name('auteurs');
    Route::get('auteurs/{auteur}', Auteur\AuteurShowComponent::class)->name('auteurs.show');

    // Categories
    Route::get('categories', Bibliotheque\OuvrageCategory\OuvrageCategoryIndexComponent::class)->name('categories');
    Route::get('categories/{category}', OuvrageCategory\OuvrageCategoryShowComponent::class)->name('categories.show');

    // Ouvrages
    Route::get('ouvrages', Ouvrage\OuvrageIndexComponent::class)->name('ouvrages.index');
    Route::get('ouvrages/create', Ouvrage\OuvrageCreateComponent::class)->name('ouvrages.create');
    Route::get('ouvrages/{ouvrage}', Ouvrage\OuvrageShowComponent::class)->name('ouvrages.show');
    Route::get('ouvrages/{ouvrage}/edit', Ouvrage\OuvrageCreateComponent::class)->name('ouvrages.edit');
    Route::get('ouvrages/{ouvrage}/read', Ouvrage\OuvrageReadComponent::class)->name('ouvrages.read');

});

