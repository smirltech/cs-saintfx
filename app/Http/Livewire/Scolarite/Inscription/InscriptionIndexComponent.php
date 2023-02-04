<?php

namespace App\Http\Livewire\Scolarite\Inscription;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Inscription;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class InscriptionIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;
    use WithPagination;

    public Annee $annee_courante;
    public $inscriptions = [];

    public function mount(){
        $this->authorize("viewAny", Inscription::class);
        $this->annee_courante = Annee::encours();
    }

    //public string $search = '';

    //protected $queryString = ['search'];

    public function render()
    {
       // $this->annee_courante = Annee::where('encours', true)->first();

        $this->loadData();

        return view('livewire.scolarite.inscriptions.index', [
            'inscriptions' => $this->inscriptions,
        ])
            ->layout(AdminLayout::class, ['title' => "Liste d'inscriptions"]);
    }

    public function loadData()
    {
        $this->inscriptions = Inscription::where('annee_id', Annee::id())->orderBy('status', 'ASC')->get();
    }

    public function deleteInscription($id)
    {
        $this->alert('info', "Cette fonctionnalité n'est pas encore implémentée !");
    }
}
