<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\DarkmodeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Livewire\Bibliotheque\Etiquette\EtiquetteIndexComponent;
use App\Http\Livewire\Finance;
use App\Http\Livewire\MainDashboardComponent;
use App\Http\Livewire\Profile\UserEditComponent;
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

Route::get('/', MainDashboardComponent::class)->name('home')->middleware('auth');


Route::get('scolarite', Scolarite\DashboardComponent::class)->name('scolarite')->middleware('auth');
Route::get('finance', Finance\Dashboard\DashboardComponent::class)->name('finance')->middleware('auth');


Route::get('darkmode/toggle', [DarkmodeController::class, 'toggle'])
    ->name('darkmode.toggle');


//Scolarite
require __DIR__ . '/scolarite.php';
# Finance
require __DIR__ . '/finance.php';
# Logistique
require __DIR__ . '/logistique.php';
# Bibliothèque
require __DIR__ . '/bibliotheque.php';

// parametres
Route::get('roles', Roles\IndexComponent::class)->name('roles.index');
Route::get('roles/create', Roles\RoleModal::class)->name('roles.create');
Route::get('roles/{role}', Roles\RoleModal::class)->name('roles.show');

Route::get("audits", [AuditController::class, 'index'])->name("audits.index")->can('audits.viewAny');
Route::get("audits/{audit}", [AuditController::class, 'show'])->name("audits.show")->can('audits.view');

//Users
Route::get('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.password.autoreset');
Route::resource('users', UserController::class)->except(['show', 'edit']);
Route::get('users/{user}/edit', UserEditComponent::class)->name('users.edit');
// auth routes except register
Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false,
    'verify' => false
]);
