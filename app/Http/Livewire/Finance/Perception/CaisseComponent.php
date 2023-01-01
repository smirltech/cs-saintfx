<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Models\Annee;
use App\Models\Inscription;
use App\Models\Perception;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Str;

class CaisseComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;

    public $perceptions = [];
    public $inscriptions = [];
    public $inscription;
    public $perception;
    public $searchTerm = '';
    public $annee_id;

    public function mount()
    {
        $this->annee_id = Annee::id();
    }

    public function render()
    {

        return view('livewire.finance.perceptions.caisse.caisse')
            ->layout(AdminLayout::class);
    }

    public function getSelectedInscription($id)
    {
        $this->inscription = Inscription::find($id);
        $this->perceptions = $this->inscription->perceptions;
    }

    public function getSelectedPerception($id)
    {
        $this->perception = Perception::find($id);
    }

    public function clearSelection()
    {
        $this->inscription = null;
        $this->perceptions = [];
        $this->perception = null;
    }

    public function searchInscription()
    {
        $terms = trim($this->searchTerm);

        if ($terms != null && Str::length($terms) > 1) {
            $this->inscriptions = Inscription::where('annee_id', $this->annee_id)
                ->whereHas('eleve', function ($q) use ($terms) {
                     $q->where('nom' , 'like', '%'.$terms.'%')
                         ->orWhere('postnom' , 'like', '%'.$terms.'%')
                         ->orWhere('prenom' , 'like', '%'.$terms.'%')
                         ->orWhere('matricule' , 'like', '%'.$terms.'%')
                     ;

                })
                ->get();
        } else {
            $this->inscriptions = [];
        }


    }

}
