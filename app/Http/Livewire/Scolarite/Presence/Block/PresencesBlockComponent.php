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
        $this->current_date = $this->current_date ?? Carbon::now()->format('Y-m-d');
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

    public function selectPresence($presence_id)
    {
        $this->presence = Presence::find($presence_id);
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
        $this->initPresence();
        $this->loadData();
    }

    public function printIt()
    {
        $this->loadData();
        $this->dispatchBrowserEvent('printIt', ['elementId' => "presencesPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
