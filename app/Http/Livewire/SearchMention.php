<?php

namespace App\Http\Livewire;

use App\Enum\DemandeStatus;
use App\Enum\RejectRaison;
use App\Notifications\DemandeApprovedNotification;
use App\Services\Sagenet\SagenetService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SearchMention extends Component
{
    public string $matricule = '';
    public $etudiant;
    public $mentions;
    public $demandes;


    public function mount(SagenetService $service, string $matricule)
    {

        if (!empty($matricule)) {
            $this->etudiant = $service->etudiant()->show($matricule)->json('data');
        }
    }


    public function render(): Factory|View|Application
    {

        return view('livewire.search-mention');
    }

    // set reject comment
    public function setRejectComment()
    {
        $this->reject_comment = RejectRaison::tryFrom($this->reject_reason)->message();
    }

    // submit
    public function submit()
    {

        $this->validate([
            'status' => 'required',
            'reject_reason' => 'required_if:status,' . DemandeStatus::rejected->value,
            'reject_comment' => 'required_if:status,' . DemandeStatus::rejected->value,
        ]);


        $this->demande->status = $this->status;
        if ($this->status == DemandeStatus::rejected->value) {
            $this->demande->reject_reason = $this->reject_reason;
            $this->demande->note = $this->reject_comment;
        }
        $this->demande->save();


        $this->demande->user->notify(new DemandeApprovedNotification($this->demande));


        $this->resetForm();
    }

    private function resetForm()
    {
        $this->validate = false;
        $this->status = DemandeStatus::accepted->value;
        $this->reject_reason = RejectRaison::bordereau_absent->value;
        $this->reject_comment = RejectRaison::bordereau_absent->message();
        $this->emit('demandeValidated');
    }
}
