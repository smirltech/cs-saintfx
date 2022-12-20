<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Livewire\Finance;
use App\Http\Livewire\MainDashboardComponent;
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

Route::get('/', MainDashboardComponent::class)->name('home');
Route::get('scolarite', Scolarite\DashboardComponent::class)->name('scolarite');
Route::redirect('dashboard', 'scolarite')->name('dashboard');


Route::get('auth/{user}', [OtpController::class, 'showVerifyOtp'])->name('auth.verify');
Route::get('auth/success', function () {
    return "Success";
})->middleware(['auth'])->name('auth.success');
Route::post('auth/otp-send', [OtpController::class, 'sendOtp'])->name('auth.otp-send');
Route::post('auth/otp-verify', [OtpController::class, 'verifyOtp'])->name('auth.otp-verify');

// add routes
//Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
//Route::get('home', [Admin\HomeController::class, 'index'])->name('home');

//Users
Route::resource('users', UserController::class);
Route::get('/', Scolarite\DashboardComponent::class)->name('scolarite');

Route::prefix('scolarite')->middleware(['auth:web'])->as('scolarite.')->group(function () {
    // Route::get('/', Scolarite\DashboardComponent::class)->name('scolarite');
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
    //  Route::get('devoirs', Scolarite\Devoir\DevoirIndexComponent::class)->name('devoirs.index');
    Route::get('devoirs/create', Scolarite\Devoir\DevoirCreateComponent::class)->name('devoirs.create');
    Route::get('devoirs/{devoir}/edit', Scolarite\Devoir\DevoirEditComponent::class)->name('devoirs.edit');
    Route::get('devoirs/{devoir}', Scolarite\Devoir\DevoirShowComponent::class)->name('devoirs.show');

    // Enseignant
    Route::get('enseignants', Scolarite\Enseignant\EnseignantIndexComponent::class)->name('enseignants.index');
    Route::get('enseignants/create', Scolarite\Enseignant\EnseignantCreateComponent::class)->name('enseignants.create');
    Route::get('enseignants/{enseignant}/edit', Scolarite\Enseignant\EnseignantEditComponent::class)->name('enseignants.edit');
    Route::get('enseignants/{enseignant}', Scolarite\Enseignant\EnseignantShowComponent::class)->name('enseignants.show');


// Année
    Route::get('annees', Scolarite\Annee\AnneeComponent::class)->name('annees');

// Eleves
    Route::get('eleves/{eleve}', Scolarite\Eleve\EleveShowComponent::class)->name('eleves.show');
    Route::get('eleves', Scolarite\Eleve\EleveIndexComponent::class)->name('eleves');

    // Inscription
    Route::get('inscriptions/create', Scolarite\Inscription\InscriptionCreateComponent::class)->name('inscriptions.create');
    Route::get('inscriptions/{inscription}/edit', Scolarite\Inscription\InscriptionEditComponent::class)->name('inscriptions.edit');
    Route::get('inscriptions/tous', Scolarite\Inscription\InscriptionIndexComponent::class)->name('inscriptions.index');
    Route::get('inscriptions/status/{status}', Scolarite\Inscription\ByStatus\InscriptionStatusComponent::class)->name('inscriptions.status');
    Route::get('inscriptions', Scolarite\Inscription\InscriptionIndexComponent::class)->name('inscriptions');

    // Responsables
    Route::get('responsables/{responsable}', Scolarite\Responsable\ResponsableShowComponent::class)->name('responsables.show');
    Route::get('responsables', Scolarite\Responsable\ResponsableIndexComponent::class)->name('responsables');


    //others
    Route::resource('users', UserController::class);
    // Route::resource('facultes', FaculteController::class);

    Route::get("audits", [AuditController::class, 'index'])->name("audits.index")->can('audits.viewAny');
    Route::get("audits/{audit}", [AuditController::class, 'show'])->name("audits.show")->can('audits.view');

    Route::resource('roles', Admin\RoleController::class);

    Route::get('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.password.autoreset');
    Route::resource('users', UserController::class);
});
# Finance
Route::prefix('finance')->middleware(['auth:web'])->as('finance.')->group(function () {
    // Admin
    Route::get('/', Finance\Dashboard\DashboardComponent::class)->name('finance');


    //Revenu
    Route::get('revenus', Finance\Revenu\RevenuIndexComponent::class)->name('revenus');

    //Revenu
    Route::get('depenses', Finance\Depense\DepenseIndexComponent::class)->name('depenses');

    //Frais
    Route::get('frais', Finance\Frais\FraisIndexComponent::class)->name('frais');

    //Perception
    Route::get('perceptions/create', Finance\Perception\PerceptionCreateComponent::class)->name('perceptions.create');
    Route::get('perceptions/{perception}/edit', Finance\Perception\PerceptionEditComponent::class)->name('perceptions.edit');
    Route::get('perceptions', Finance\Perception\PerceptionIndexComponent::class)->name('perceptions');

    //Perception
    Route::get('eleves', Finance\Eleve\EleveIndexComponent::class)->name('eleves');
    Route::get('eleves/{id}', Finance\Eleve\EleveShowComponent::class)->name('eleves.show');
});

Auth::routes();
