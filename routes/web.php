<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Livewire\Admin\Annee\AnneeComponent;
use App\Http\Livewire\Admin\Classe;
use App\Http\Livewire\Admin\DashboardComponent;
use App\Http\Livewire\Admin\Etudiant\EtudiantCreateComponent;
use App\Http\Livewire\Admin\Etudiant\EtudiantShowComponent;

use App\Http\Livewire\Admin\Filiere\FiliereCreateComponent;
use App\Http\Livewire\Admin\Filiere\FiliereEditComponent;
use App\Http\Livewire\Admin\Filiere\FiliereIndexComponent;
use App\Http\Livewire\Admin\Filiere\FiliereShowComponent;
use App\Http\Livewire\Admin\Inscription\InscriptionCreateComponent;
use App\Http\Livewire\Admin\Inscription\InscriptionEditComponent;
use App\Http\Livewire\Admin\Inscription\InscriptionIndexComponent;

use App\Http\Livewire\Admin\Option\OptionCreateComponent;
use App\Http\Livewire\Admin\Option\OptionEditComponent;
use App\Http\Livewire\Admin\Option\OptionIndexComponent;
use App\Http\Livewire\Admin\Option\OptionShowComponent;
use App\Http\Livewire\Admin\Section\SectionCreateComponent;
use App\Http\Livewire\Admin\Section\SectionEditComponent;
use App\Http\Livewire\Admin\Section\SectionIndexComponent;
use App\Http\Livewire\Admin\Section\SectionShowComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
    Route::get('sections/create', SectionCreateComponent::class)->name('sections.create');
    Route::get('sections/{section}/edit', SectionEditComponent::class)->name('sections.edit');
    Route::get('sections/{section}', SectionShowComponent::class)->name('sections.show');
    Route::get('sections', SectionIndexComponent::class)->name('sections');

    //Option
    Route::get('options/create', OptionCreateComponent::class)->name('options.create');
    Route::get('options/{option}/edit', OptionEditComponent::class)->name('options.edit');
    Route::get('options/{option}', OptionShowComponent::class)->name('options.show');
    Route::get('options', OptionIndexComponent::class)->name('options');


//Filiere
    Route::get('filieres/create', FiliereCreateComponent::class)->name('filieres.create');
    Route::get('filieres/{filiere}/edit', FiliereEditComponent::class)->name('filieres.edit');
    Route::get('filieres/{filiere}', FiliereShowComponent::class)->name('filieres.show');
    Route::get('filieres', FiliereIndexComponent::class)->name('filieres');

// Classe
    Route::get('classes/create', Classe\ClasseCreateComponent::class)->name('classes.create');
    Route::get('classes/{classe}/edit', Classe\ClasseEditComponent::class)->name('classes.edit');
    Route::get('classes/{classe}', Classe\ClasseShowComponent::class)->name('classes.show');
    Route::get('classes', Classe\ClasseIndexComponent::class)->name('classes');

// Année
    Route::get('annees', AnneeComponent::class)->name('annees');

// Etudiant
    Route::get('eleves/{eleve}', EtudiantShowComponent::class)->name('eleves.show');

    // Inscription
    Route::get('inscriptions/create', InscriptionCreateComponent::class)->name('inscriptions.create');
    Route::get('inscriptions/{inscription}/edit', InscriptionEditComponent::class)->name('inscriptions.edit');
    Route::get('inscriptions/tous', InscriptionIndexComponent::class)->name('inscriptions.index');
    Route::get('inscriptions', InscriptionIndexComponent::class)->name('inscriptions');


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


// sagenet test
Route::get('sagenet/{resource}', function ($resource) {
    return Http::get(config('services.sagenet.url') . "/{$resource}")->body();
});


Auth::routes();

Route::get('home', [Admin\HomeController::class, 'index'])->name('home');
