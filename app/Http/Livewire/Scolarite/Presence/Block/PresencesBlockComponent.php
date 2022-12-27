<?php

namespace App\Http\Livewire\Scolarite\Presence\Block;

use App\Enums\ResultatType;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Presence;
use App\Models\Resultat;
use App\Traits\TopMenuPreview;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PresencesBlockComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;
    use WithPagination;


    public Classe $classe;
    public $presences = [];
    //public $resultats = [];
    public Presence $presence;
    public $current_date;

    protected $rules = [
        'presence.date' => 'required',
        'presence.status' => 'required',
        'presence.observation' => 'nullable',

    ];


    public function mount(Classe $classe)
    {
        $this->classe = $classe;
        $this->initPresence();
        $this->loadData();

    }


    private function initPresence()
    {
        $this->current_date = Carbon::now()->format('Y-m-d');
        $this->presence = new Presence();
    }


    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.presences.blocks.list');
    }

    public function loadData()
    {
        $this->presences = $this->classe->presences->where('date', $this->current_date)->where('annee_id', Annee::id());
       // dd($this->presences);
    }

    public function onModalClosing($modalId)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $modalId]);
        $this->initPresence();
        $this->loadData();
    }

    public function printIt()
    {
        $this->loadData();
        $this->dispatchBrowserEvent('printIt', ['elementId' => "presencesPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
