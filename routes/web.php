<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Livewire\Admin\Annee\AnneeComponent;
use App\Http\Livewire\Admin\Classe;
use App\Http\Livewire\Admin\DashboardComponent;
use App\Http\Livewire\Admin\Eleve\EleveIndexComponent;
use App\Http\Livewire\Admin\Eleve\EleveShowComponent;
use App\Http\Livewire\Admin\Filiere\FiliereIndexComponent;
use App\Http\Livewire\Admin\Filiere\FiliereShowComponent;
use App\Http\Livewire\Admin\Inscription\InscriptionCreateComponent;
use App\Http\Livewire\Admin\Inscription\InscriptionEditComponent;
use App\Http\Livewire\Admin\Inscription\InscriptionIndexComponent;
use App\Http\Livewire\Admin\Option\OptionIndexComponent;
use App\Http\Livewire\Admin\Option\OptionShowComponent;
use App\Http\Livewire\Admin\Responsable\ResponsableIndexComponent;
use App\Http\Livewire\Admin\Responsable\ResponsableShowComponent;
use App\Http\Livewire\Admin\Section\SectionIndexComponent;
use App\Http\Livewire\Admin\Section\SectionShowComponent;
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

Route::redirect('/', 'admin')->name('admin');


Route::get('auth/{user}', [OtpController::class, 'showVerifyOtp'])->name('auth.verify');
Route::get('auth/success', function () {
    return "Success";
})->middleware(['auth'])->name('auth.success');
Route::post('auth/otp-send', [OtpController::class, 'sendOtp'])->name('auth.otp-send');
Route::post('auth/otp-verify', [OtpController::class, 'verifyOtp'])->name('auth.otp-verify');

Route::redirect('dashboard', 'admin')->name('dashboard');

//Route::get('inscription', InscriptionEtudiant::class)->name('inscription');

Route::prefix('admin')->middleware(['auth:web'])->as('admin.')->group(function () {

//Section
    Route::get('sections/{section}', SectionShowComponent::class)->name('sections.show');
    Route::get('sections', SectionIndexComponent::class)->name('sections');

    //Option
    Route::get('options/{option}', OptionShowComponent::class)->name('options.show');
    Route::get('options', OptionIndexComponent::class)->name('options');


//Filiere
    Route::get('filieres/{filiere}', FiliereShowComponent::class)->name('filieres.show');
    Route::get('filieres', FiliereIndexComponent::class)->name('filieres');

// Classe
    Route::get('classes/create', Classe\ClasseCreateComponent::class)->name('classes.create');
    Route::get('classes/{classe}/edit', Classe\ClasseEditComponent::class)->name('classes.edit');
    Route::get('classes/{classe}', Classe\ClasseShowComponent::class)->name('classes.show');
    Route::get('classes', Classe\ClasseIndexComponent::class)->name('classes');

// Année
    Route::get('annees', AnneeComponent::class)->name('annees');

// Eleves
    Route::get('eleves/{eleve}', EleveShowComponent::class)->name('eleves.show');
    Route::get('eleves', EleveIndexComponent::class)->name('eleves');

    // Inscription
    Route::get('inscriptions/create', InscriptionCreateComponent::class)->name('inscriptions.create');
    Route::get('inscriptions/{inscription}/edit', InscriptionEditComponent::class)->name('inscriptions.edit');
    Route::get('inscriptions/tous', InscriptionIndexComponent::class)->name('inscriptions.index');
    Route::get('inscriptions', InscriptionIndexComponent::class)->name('inscriptions');

    // Responsables
    Route::get('responsables/{responsable}', ResponsableShowComponent::class)->name('responsables.show');
    Route::get('responsables', ResponsableIndexComponent::class)->name('responsables');

    Route::get('/', DashboardComponent::class)->name('admin');

    //others
    Route::resource('users', UserController::class);
    // Route::resource('facultes', FaculteController::class);

    Route::get("audits", [AuditController::class, 'index'])->name("audits.index")->can('audits.viewAny');
    Route::get("audits/{audit}", [AuditController::class, 'show'])->name("audits.show")->can('audits.view');

    Route::resource('roles', RoleController::class);

    Route::get('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.password.autoreset');
    Route::resource('users', UserController::class);
});


Auth::routes();

Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
