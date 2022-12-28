<?php

namespace App\Http\Livewire\Scolarite\Presence\Block;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Presence;
use App\Traits\TopMenuPreview;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\Rule;
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
    public $nonInscriptions = [];
    //public $resultats = [];
    public Presence $presence;
    public $current_date;

    protected $rules = [
        'presence.inscription_id' => 'required',
        'presence.date' => 'nullable',
        'presence.status' => 'required',
        'presence.observation' => 'nullable',

    ];


    public function mount(Classe $classe)
    {
        $this->classe = $classe;
        $this->loadData();
        $this->initPresence();

    }


    public function initPresence()
    {
        $this->current_date = $this->current_date ?? Carbon::now()->format('Y-m-d');
        $this->presence = new Presence();
    }


    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.presences.blocks.list',
            [
                'presences' => $this->presences,
                'nonInscriptions' => $this->nonInscriptions,
            ]
        );
    }

    public function loadData()
    {
        $this->presences = $this->classe->presences->where('date', $this->current_date)->where('annee_id', Annee::id());
        $this->nonInscriptions = $this->classe->nonInscriptions($this->current_date);
        // dd($this->presences);
    }

    public function selectPresence($presence_id)
    {
        $this->presence = Presence::find($presence_id);
    }

    public function addPresence($status)
    {
        $this->presence->status = $status;
        $this->presence->date = $this->current_date;
        $this->presence->annee_id = Annee::id();
        $this->validate([
            'presence.inscription_id' => 'required',
            'presence.date' => 'required',
            'presence.status' => 'required',
            'presence.observation' => 'nullable',
        ]);
        //dd($this->presence);
        try {
            $done = $this->presence->save();
            if ($done) {
                $this->classe->refresh();
                $this->loadData();
                $this->initPresence();
                $this->alert('success', "Présence ajoutée avec succès !");

            } else {
                $this->alert('warning', "Echec d'ajout de présence !");
            }
        } catch (Exception $exception) {
              dd($exception);
            $this->alert('error', "Echec de d'ajout de présence qui existe sur cette date déjà !");
        }
    }

    public function updatePresence()
    {
        $this->validate([
            'presence.date' => ['required', Rule::unique('presences', 'date')->ignore($this->presence, 'date'),],
            'presence.observation' => 'nullable',
        ]);

        try {
            $done = $this->presence->update();
            if ($done) {
                $this->onModalClosed('update-presence');
                $this->alert('success', "Présence modifiée avec succès !");

            } else {
                $this->alert('warning', "Echec de modification de présence !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Echec de modification de présence qui existe sur cette date déjà !");
        }
    }

    public function deletePresence()
    {
        $done = $this->presence->delete();
        if ($done) {
            $this->onModalClosed('delete-presence');
            $this->alert('success', "Présence supprimée avec succès !");

        } else {
            $this->alert('warning', "Echec de suppression de présence !");
        }
    }

    public function onModalClosed($modalId)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $modalId]);
        $this->classe->refresh();
        $this->loadData();
        $this->initPresence();
    }

    public function printIt()
    {
        $this->loadData();
        $this->dispatchBrowserEvent('printIt', ['elementId' => "presencesPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
