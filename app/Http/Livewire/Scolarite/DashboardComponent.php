<?php

namespace App\Http\Livewire\Scolarite;

use App\Enums\InscriptionStatus;
use App\Models\Annee;
use App\Models\Inscription;
use App\Traits\TopMenuPreview;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DashboardComponent extends Component
{
    use TopMenuPreview;
    public $boxes = [];
    public $inscrits = [];
    public $annee_courante;

    public function mount()
    {
        // set user email vefied if not yet
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::user()->update(['email_verified_at' => now()]);
        }

        $moisCourrant = Carbon::today()->subMonth(1)->toDateString();


        $this->annee_courante = Annee::where('encours', true)->first();

        $this->inscrits = Inscription::where('annee_id', $this->annee_courante->id)->get();
        $inscritsValid = Inscription::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::approved->name)->get();
        $inscritsReject = Inscription::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::rejected->name)->get();
        $inscritsPending = Inscription::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::pending->name)->get();

        $moisInscrits = Inscription::where('annee_id', $this->annee_courante->id)->where('created_at', '>', $moisCourrant)->get();
        $moisInscritsValid = Inscription::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::approved->name)->where('created_at', '>', $moisCourrant)->get();
        $moisInscritsReject = Inscription::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::rejected->name)->where('created_at', '>', $moisCourrant)->get();
        $moisInscritspending = Inscription::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::pending->name)->where('created_at', '>', $moisCourrant)->get();


        $rateInscritsMois = $moisInscrits->count() > 0 ? intval(($moisInscrits->count() / $moisInscrits->count()) * 100) : 0;
        $rateInscritsMoisValid = $moisInscritsValid->count() > 0 ? intval(($moisInscritsValid->count() / $moisInscrits->count()) * 100) : 0;
        $rateInscritsMoisReject = $moisInscritsReject->count() > 0 ? intval(($moisInscritsReject->count() / $moisInscrits->count()) * 100) : 0;
        $rateInscritsMoisPending = $moisInscritspending->count() > 0 ? intval(($moisInscritspending->count() / $moisInscrits->count()) * 100) : 0;

        $this->boxes = [
            [
                'title' => count($moisInscrits),
                'text' => 'Inscrits',
                'icon' => 'far fa-bookmark',
                'url' => "#",
                'theme' => 'danger',
                'rate' => "$rateInscritsMois%",
                'subtitle' => "+{$rateInscritsMois}% en 1 mois",

            ],
            [
                'title' => count($moisInscritsValid),
                'text' => 'Validés',
                'icon' => 'far fa-bookmark',
                'url' => "scolarite/inscriptions/status/approved",
                'theme' => 'primary',
                'rate' => "$rateInscritsMoisValid%",
                'subtitle' => "+$rateInscritsMoisValid% en 1 mois",
            ],
            [
                'title' => count($moisInscritsReject),
                'text' => 'Rejetés',
                'icon' => 'far fa-bookmark',
                'url' => "scolarite/inscriptions/status/rejected",
                'theme' => 'warning',
                'rate' => "$rateInscritsMoisReject%",
                'subtitle' => "+$rateInscritsMoisReject% en 1 mois",
            ],
            [
                'title' => count($moisInscritspending),
                'text' => 'En Attente',
                'icon' => 'far fa-bookmark',
                'url' => "scolarite/inscriptions/status/pending",
                'theme' => 'success',
                'rate' => "$rateInscritsMoisPending%",
                'subtitle' => "+$rateInscritsMoisPending% en 1 mois",
            ]
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.dashboard');
    }

}
