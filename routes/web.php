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
use App\Http\Livewire\Admin\Faculte\FaculteCreateComponent;
use App\Http\Livewire\Admin\Faculte\FaculteEditComponent;
use App\Http\Livewire\Admin\Faculte\FaculteIndexComponent;
use App\Http\Livewire\Admin\Faculte\FaculteShowComponent;
use App\Http\Livewire\Admin\Filiere\FiliereCreateComponent;
use App\Http\Livewire\Admin\Filiere\FiliereEditComponent;
use App\Http\Livewire\Admin\Filiere\FiliereIndexComponent;
use App\Http\Livewire\Admin\Filiere\FiliereShowComponent;
use App\Http\Livewire\Admin\Inscription\InscriptionEditComponent;
use App\Http\Livewire\Admin\Inscription\InscriptionIndexComponent;
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

Route::redirect('/', 'admin')->name('home');


Route::get('auth/{user}', [OtpController::class, 'showVerifyOtp'])->name('auth.verify');
Route::get('auth/success', function () {
    return "Success";
})->middleware(['auth'])->name('auth.success');
Route::post('auth/otp-send', [OtpController::class, 'sendOtp'])->name('auth.otp-send');
Route::post('auth/otp-verify', [OtpController::class, 'verifyOtp'])->name('auth.otp-verify');

Route::redirect('dashboard', 'admin')->name('dashboard');

//Route::get('inscription', InscriptionEtudiant::class)->name('inscription');

Route::prefix('admin')->middleware(['auth:web'])->as('admin.')->group(function () {

//Faculté
    Route::get('facultes/create', FaculteCreateComponent::class)->name('facultes.create');
    Route::get('facultes/{faculte}/edit', FaculteEditComponent::class)->name('facultes.edit');
    Route::get('facultes/{faculte}', FaculteShowComponent::class)->name('facultes.show');
    Route::get('facultes', FaculteIndexComponent::class)->name('facultes');

//Filiere
    Route::get('filieres/create', FiliereCreateComponent::class)->name('filieres.create');
    Route::get('filieres/{filiere}/edit', FiliereEditComponent::class)->name('filieres.edit');
    Route::get('filieres/{filiere}', FiliereShowComponent::class)->name('filieres.show');
    Route::get('filieres', FiliereIndexComponent::class)->name('filieres');

// Promotion
    Route::get('promotions/create', Classe\ClasseCreateComponent::class)->name('promotions.create');
    Route::get('promotions/{promotion}/edit', Classe\ClasseEditComponent::class)->name('promotions.edit');
    Route::get('promotions/{promotion}', Classe\ClasseShowComponent::class)->name('promotions.show');
    Route::get('promotions', Classe\ClasseIndexComponent::class)->name('promotions');

// Année
    Route::get('annees', AnneeComponent::class)->name('annees');

// Etudiant
    Route::get('etudiants/{etudiant}', EtudiantShowComponent::class)->name('etudiants.show');

    Route::get('admissions/create', EtudiantCreateComponent::class)->name('admissions.create');

    // Admission
    Route::get('admissions/{admission}/edit', InscriptionEditComponent::class)->name('admissions.edit');
    Route::get('admissions/tous', InscriptionIndexComponent::class)->name('admissions.index');
    Route::get('admissions', InscriptionIndexComponent::class)->name('admissions');


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
