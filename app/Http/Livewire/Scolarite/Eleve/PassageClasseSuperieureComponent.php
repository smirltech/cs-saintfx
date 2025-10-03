<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Http\Livewire\BaseComponent;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Annee;

class PassageClasseSuperieureComponent extends BaseComponent
{
    public $classes = [];
    public $eleves = [];
    public $search = '';
    public $eleve;
    public $nouvelleClasseId;
    public $annee;
    public $eleve_id;

    public function mount($id = null): void
    {
        $this->eleve   = $id ? Eleve::find($id) : null;
        $this->eleves  = Eleve::all();
        $this->classes = Classe::all();
    }

    public function updatedEleveId(string $eleve_id){
        $this->eleve = Eleve::find($eleve_id);
    }

//    {
//        if ($this->search) {
//            $this->eleve = Eleve::where('nom', 'like', '%' . $this->search . '%')
//                ->orWhere('matricule', 'like', '%' . $this->search . '%')
//                ->first();
//        } else {
//            $this->eleve = null;
//        }



    public function passerClasse()
    {
        if (!$this->eleve) {
            session()->flash('error', "Veuillez sélectionner un élève !");
            return;
        }


        $annee = Annee::where('encours', 1)->first();
        if (!$annee) {
            session()->flash('error', "Aucune année scolaire active !");
            return;
        }



        try {
            Inscription::updateOrCreate(
                ['eleve_id' => $this->eleve->id, 'annee_id' => $annee->id],
                [
                    'classe_id' => $this->nouvelleClasseId,
                    'status'    => 'approved',
                ]
            );


            session()->flash('success',  "L'élève {$this->eleve->nom} a été inscrit !");
            $this->reset(['eleve', 'search', 'nouvelleClasseId']);
        } catch (\Illuminate\Database\QueryException $e) {
            session()->flash('error', "Erreur SQL : " . $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', "Erreur : " . $e->getMessage());
        }
    }
    public function render()
    {

        return view('livewire.scolarite.eleves.passage-classe-superieure-component', [
            'classes' => $this->classes,
            'eleve'   => $this->eleve,
            'eleves'  => $this->eleves,
        ]);
    }
}
