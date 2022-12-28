<?php

namespace App\Http\Livewire\Finance\Rapport;


use App\Models\Annee;
use App\Models\Depense;
use App\Models\Frais;
use App\Models\Perception;
use App\Models\Revenu;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RapportIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public $ddebut;
    public $dfin;

    public $revenuAuxiliaire = 0;
    public $perception = 0;
    public $frais = [];
    public $depenses = 0;
    public $categories = [];
    public $annee_id;
    public $anneeNom;
    protected $rules = [
        'ddebut' => 'nullable',
        'dfin' => 'nullable',
    ];
    private $annee;

    public function mount()
    {
        $this->annee = Annee::encours();
        $this->annee_id = $this->annee->id;
        $this->anneeNom = $this->annee->nom;
        $this->ddebut = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dfin = Carbon::now()->format('Y-m-d');

    }

    public function render()
    {
        $this->loadData();
        return view('livewire.finance.rapports.index', ['annee' => $this->annee])
            ->layout(AdminLayout::class, ['title' => 'Liste de Revenus']);
    }

    public function loadData()
    {
        $this->revenuAuxiliaire = Revenu::sommeBetween(annee_id: $this->annee_id, ddebut: $this->ddebut, dfin: $this->dfin);
        $this->perception = Perception::sommeBetween(annee_id: $this->annee_id, ddebut: $this->ddebut, dfin: $this->dfin);
        $this->frais = Frais::sommeFraisByTypeBetween(annee_id: $this->annee_id, ddebut: $this->ddebut, dfin: $this->dfin);

        $this->depenses = Depense::sommeBetween(annee_id: $this->annee_id, ddebut: $this->ddebut, dfin: $this->dfin);
        $this->categories = Depense::sommeDepensesByCategoryBetween(annee_id: $this->annee_id, ddebut: $this->ddebut, dfin: $this->dfin);

    }

    public function updateReport()
    {

    }

    public function printIt()
    {
        $this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
