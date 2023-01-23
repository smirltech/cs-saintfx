<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\MediaController;
use App\Http\Livewire\Bibliotheque\Auteur\AuteurIndexComponent;
use App\Http\Livewire\Bibliotheque\Etiquette\EtiquetteIndexComponent;
use App\Http\Livewire\Bibliotheque\Ouvrage\OuvrageIndexComponent;
use App\Http\Livewire\Bibliotheque\Ouvrage\OuvrageShowComponent;
use App\Http\Livewire\Bibliotheque\OuvrageCategory\OuvrageCategoryIndexComponent;
use App\Http\Livewire\Bibliotheque\OuvrageCategory\OuvrageCategoryShowComponent;
use App\Http\Livewire\Finance;
use App\Http\Livewire\Logistique\Fongible\Consommable\ConsommableIndexComponent;
use App\Http\Livewire\Logistique\Fongible\Consommable\ConsommableShowComponent;
use App\Http\Livewire\Logistique\Fongible\Unit\UnitIndexComponent;
use App\Http\Livewire\Logistique\NonFongible\Materiel\MaterielIndexComponent;
use App\Http\Livewire\Logistique\NonFongible\Materiel\MaterielShowComponent;
use App\Http\Livewire\Logistique\NonFongible\MaterielCategory\MaterielCategoryIndexComponent;
use App\Http\Livewire\Logistique\NonFongible\MaterielCategory\MaterielCategoryShowComponent;
use App\Http\Livewire\Logistique\NonFongible\Mouvement\MouvementIndexComponent;
use App\Http\Livewire\MainDashboardComponent;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Scolarite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('media/{media}', [MediaController::class, 'show'])->name('media.show');


Route::get('/', MainDashboardComponent::class)->name('home')->middleware('auth');
Route::get('dashboard', MainDashboardComponent::class)->name('dashboard')->middleware('auth');

Route::get('scolarite', Scolarite\DashboardComponent::class)->name('scolarite')->middleware('auth');
Route::get('finance', Finance\Dashboard\DashboardComponent::class)->name('finance')->middleware('auth');


Route::get('auth/{user}', [OtpController::class, 'showVerifyOtp'])->name('auth.verify');
Route::get('auth/success', function () {
    return "Success";
})->middleware(['auth'])->name('auth.success');
Route::post('auth/otp-send', [OtpController::class, 'sendOtp'])->name('auth.otp-send');
Route::post('auth/otp-verify', [OtpController::class, 'verifyOtp'])->name('auth.otp-verify');

//Users
Route::get('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.password.autoreset');
Route::resource('users', UserController::class);

//Scolarite
Route::prefix('scolarite')->middleware(['auth:web'])->as('scolarite.')->group(function () {

//Section
    Route::get('sections/{section}', Scolarite\Section\SectionShowComponent::class)->name('sections.show');
    Route::get('sections', Scolarite\Section\SectionIndexComponent::class)->name('sections');

    //Option
    Route::get('options/{option}', Scolarite\Option\OptionShowComponent::class)->name('options.show');
    Route::get('options', Scolarite\Option\OptionIndexComponent::class)->name('options');

//Filiere
    Route::get('filieres/{filiere}', Scolarite\Filiere\FiliereShowComponent::class)->name('filieres.show');
    Route::get('filieres', Scolarite\Filiere\FiliereIndexComponent::class)->name('filieres');

// Classe
    Route::get('classes/create', Scolarite\Classe\ClasseCreateComponent::class)->name('classes.create');
    Route::get('classes/{classe}/edit', Scolarite\Classe\ClasseEditComponent::class)->name('classes.edit');
    Route::get('classes/{classe}', Scolarite\Classe\ClasseShowComponent::class)->name('classes.show');
    Route::get('classes', Scolarite\Classe\ClasseIndexComponent::class)->name('classes');

    // cours
    Route::get('cours', Scolarite\Cours\CoursIndexComponent::class)->name('cours.index');
    Route::get('cours/create', Scolarite\Cours\CoursCreateComponent::class)->name('cours.create');
    Route::get('cours/{cours}/edit', Scolarite\Cours\CoursEditComponent::class)->name('cours.edit');
    Route::get('cours/{cours}', Scolarite\Classe\ClasseShowComponent::class)->name('cours.show');

    // devoirs
    Route::get('devoirs', Scolarite\Devoir\DevoirIndexComponent::class)->name('devoirs.index');
    Route::get('devoirs/create', Scolarite\Devoir\DevoirCreateComponent::class)->name('devoirs.create');
    Route::get('devoirs/{devoir}/edit', Scolarite\Devoir\DevoirEditComponent::class)->name('devoirs.edit');
    Route::get('devoirs/{devoir}', Scolarite\Devoir\DevoirShowComponent::class)->name('devoirs.show');

    // devoirs
    Route::get('resultats/classe/{classe}', Scolarite\Resultat\ResultatIndexComponent::class)->name('resultats.classe');

    // Enseignant
    Route::get('enseignants', Scolarite\Enseignant\EnseignantIndexComponent::class)->name('enseignants.index');
    Route::get('enseignants/create', Scolarite\Enseignant\EnseignantCreateComponent::class)->name('enseignants.create');
    Route::get('enseignants/{enseignant}/edit', Scolarite\Enseignant\EnseignantEditComponent::class)->name('enseignants.edit');
    Route::get('enseignants/{enseignant}', Scolarite\Enseignant\EnseignantShowComponent::class)->name('enseignants.show');

// Année
    Route::get('annees', Scolarite\Annee\AnneeComponent::class)->name('annees');

// Eleves
    Route::get('eleves/{eleve}', Scolarite\Eleve\EleveShowComponent::class)->name('eleves.show');
    Route::get('eleves/{eleve}/presence', Scolarite\Eleve\PresenceComponent::class)->name('eleves.presence');
    Route::get('eleves', Scolarite\Eleve\EleveIndexComponent::class)->name('eleves');
    Route::get('non-inscriptions', Scolarite\Eleve\ElevesNonInscritsComponent::class)->name('non-inscriptions');

    // Inscription
    Route::get('inscriptions/create', Scolarite\Inscription\InscriptionCreateComponent::class)->name('inscriptions.create');
    Route::get('inscriptions/{inscription}/edit', Scolarite\Inscription\InscriptionEditComponent::class)->name('inscriptions.edit');
    Route::get('inscriptions/tous', Scolarite\Inscription\InscriptionIndexComponent::class)->name('inscriptions.index');
    Route::get('inscriptions/status/{status}', Scolarite\Inscription\ByStatus\InscriptionStatusComponent::class)->name('inscriptions.status');
    Route::get('inscriptions', Scolarite\Inscription\InscriptionIndexComponent::class)->name('inscriptions');

    // Responsables
    Route::get('responsables/{responsable}', Scolarite\Responsable\ResponsableShowComponent::class)->name('responsables.show');
    Route::get('responsables', Scolarite\Responsable\ResponsableIndexComponent::class)->name('responsables');

    Route::get("audits", [AuditController::class, 'index'])->name("audits.index")->can('audits.viewAny');
    Route::get("audits/{audit}", [AuditController::class, 'show'])->name("audits.show")->can('audits.view');

    Route::resource('roles', Admin\RoleController::class);
});

# Finance
Route::prefix('finance')->middleware(['auth:web'])->as('finance.')->group(function () {

    // Rapport
    Route::get('rapports', Finance\Rapport\RapportIndexComponent::class)->name('rapports');

    //Revenu
    Route::get('revenus', Finance\Revenu\RevenuIndexComponent::class)->name('revenus');

    //Depense
    Route::get('depenses', Finance\Depense\DepenseIndexComponent::class)->name('depenses');

    Route::get('depenses-types', Finance\DepenseType\DepenseTypeIndexComponent::class)->name('depenses-types');
    Route::get('depenses-types/{depenseType}', Finance\DepenseType\DepenseTypeShowComponent::class)->name('depenses-types.show');

    //Frais
    Route::get('frais', Finance\Frais\FraisIndexComponent::class)->name('frais');

    //Perception
    Route::get('perceptions/create', Finance\Perception\PerceptionCreateComponent::class)->name('perceptions.create');
    Route::get('perceptions/{perception}/edit', Finance\Perception\PerceptionEditComponent::class)->name('perceptions.edit');
    Route::get('perceptions', Finance\Perception\PerceptionIndexComponent::class)->name('perceptions');
    Route::get('caisse', Finance\Perception\CaisseComponent::class)->name('caisse');

    //Perception
    Route::get('eleves', Finance\Eleve\EleveIndexComponent::class)->name('eleves');
    Route::get('eleves/{id}', Finance\Eleve\EleveShowComponent::class)->name('eleves.show');
});

# Logistique
Route::prefix('logistique')->middleware(['auth:web'])->as('logistique.')->group(function () {

    // materiel categories
    Route::get('categories', MaterielCategoryIndexComponent::class)->name('categories');
    Route::get('categories/{category}', MaterielCategoryShowComponent::class)->name('categories.show');

    // materiels
    Route::get('materiels', MaterielIndexComponent::class)->name('materiels');
    Route::get('materiels/{materiel}', MaterielShowComponent::class)->name('materiels.show');

    // materiels
    Route::get('mouvements', MouvementIndexComponent::class)->name('mouvements');
    Route::get('units', UnitIndexComponent::class)->name('units');

    // materiels
    Route::get('consommables', ConsommableIndexComponent::class)->name('consommables');
    Route::get('consommables/{consommable}', ConsommableShowComponent::class)->name('consommables.show');


});

# Bibliothèque
Route::prefix('bibliotheque')->middleware(['auth:web'])->as('bibliotheque.')->group(function () {

    // Étiquettes
    Route::get('etiquettes', EtiquetteIndexComponent::class)->name('etiquettes');

    // Auteurs
    Route::get('auteurs', AuteurIndexComponent::class)->name('auteurs');

    // Categories
    Route::get('categories', OuvrageCategoryIndexComponent::class)->name('categories');
    Route::get('categories/{category}', OuvrageCategoryShowComponent::class)->name('categories.show');

    // Ouvrages
    Route::get('ouvrages', OuvrageIndexComponent::class)->name('ouvrages');
    Route::get('ouvrages/{ouvrage}', OuvrageShowComponent::class)->name('ouvrages.show');

});

// parametres
Route::get('roles', Roles\IndexComponent::class)->name('roles');

// auth routes except register
Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false
]);
