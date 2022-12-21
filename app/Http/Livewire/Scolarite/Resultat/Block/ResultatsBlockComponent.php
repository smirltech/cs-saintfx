<?php

namespace App\Http\Livewire\Scolarite\Resultat\Block;

use App\Enums\ResultatType;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Resultat;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ResultatsBlockComponent extends Component
{
    use LivewireAlert;
    use WithPagination;


    public Classe $classe;
    public $inscriptions = [];
    public $resultats = [];
    public ResultatType $resultatType;


    protected $listeners = ['onModalClosed'];

    public function mount(Classe $classe)
    {
        $this->classe = $classe;
        $this->loadData();

    }

    public function loadData()
    {
        $this->inscriptions = $this->classe->inscriptions;
    }

    public function selectResultatType($type)
    {
        $this->resultatType = ResultatType::from($type);
        $this->resultats = Resultat::with('eleve')
            ->where('classe_id', $this->classe->id)
            ->where('annee_id', Annee::id())
            ->where('custom_property', $this->resultatType)
            ->orderBy('place')->get();
        // dd($type);
    }

    public function render()
    {

        return view('livewire.scolarite.resultats.blocks.resultatsBlock');
    }

}
