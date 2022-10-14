<?php

namespace App\Http\Livewire\Admin;

use App\Enum\InscriptionStatus;
use App\Models\Admission;
use App\Models\Annee;
use App\View\Components\AdminLayout;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class DashboardComponent extends Component
{
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
        $this->inscrits = Admission::where('annee_id', $this->annee_courante->id)->get();
        $inscritsValid = Admission::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::approved->name)->get();
        $inscritsReject = Admission::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::rejected->name)->get();
        $inscritsPending = Admission::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::pending->name)->get();

        $moisInscrits = Admission::where('annee_id', $this->annee_courante->id)->where('created_at', '>', $moisCourrant)->get();
        $moisInscritsValid = Admission::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::approved->name)->where('created_at', '>', $moisCourrant)->get();
        $moisInscritsReject = Admission::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::rejected->name)->where('created_at', '>', $moisCourrant)->get();
        $moisInscritspending = Admission::where('annee_id', $this->annee_courante->id)->where('status', InscriptionStatus::pending->name)->where('created_at', '>', $moisCourrant)->get();


        $rateInscritsMois = $moisInscrits->count() > 0 ? ($moisInscrits->count() / $moisInscrits->count()) * 100 : 0;
        $rateInscritsMoisValid = $moisInscritsValid->count() > 0 ? ($moisInscritsValid->count() / $moisInscrits->count()) * 100 : 0;
        $rateInscritsMoisReject = $moisInscritsReject->count() > 0 ? ($moisInscritsReject->count() / $moisInscrits->count()) * 100 : 0;
        $rateInscritsMoisPending = $moisInscritspending->count() > 0 ? ($moisInscritspending->count() / $moisInscrits->count()) * 100 : 0;

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
                'url' => "#",
                'theme' => 'primary',
                'rate' => "$rateInscritsMoisValid%",
                'subtitle' => "+$rateInscritsMoisValid% en 1 mois",
            ],
            [
                'title' => count($moisInscritsReject),
                'text' => 'Rejetés',
                'icon' => 'far fa-bookmark',
                'url' => "#",
                'theme' => 'warning',
                'rate' => "$rateInscritsMoisReject%",
                'subtitle' => "+$rateInscritsMoisReject% en 1 mois",
            ],
            [
                'title' => count($moisInscritspending),
                'text' => 'En Attente',
                'icon' => 'far fa-bookmark',
                'url' => "#",
                'theme' => 'success',
                'rate' => "$rateInscritsMoisPending%",
                'subtitle' => "+$rateInscritsMoisPending% en 1 mois",
            ]
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout(AdminLayout::class, ['title' => 'Admin Dashboard']);
    }

}
