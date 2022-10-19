<?php

namespace App\Http\Livewire\Admin\Eleve;

use App\Enum\InscriptionStatus;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Option;
use App\Models\Section;
use App\Traits\FakeProfileImage;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EleveShowComponent extends Component
{
    use LivewireAlert;
    use FakeProfileImage;

    public $eleve;
    public $inscription, $inscription2;
    public $annee_courante;
    public $profile_url;

    public $responsable_relation;

    public $sections = [];
    public $options = [];
    public $filieres = [];
    public $classes = [];

    protected $listeners = [ 'onModalClosed'];

    public $inscription2_categorie;
    public $inscription2_montant;
    public $inscription2_section_id;
    public $inscription2_option_id;
    public $inscription2_filiere_id;
    public $inscription2_classe_id;

    public function onModalClosed()
    {
       // $this->clearValidation();
       // $this->reset(['nom', 'code']);
    }

    public function mount(Eleve $eleve)
    {
        $this->annee_courante = Annee::where('encours', true)->first();
        $this->inscription = Inscription::where(['eleve_id'=>$this->eleve->id,'annee_id'=>$this->annee_courante->id])->first();
        $this->eleve = $eleve;
        $this->responsable_relation = $this->eleve->responsable_eleve->relation;
       // $this->profile_url =Helpers::fakePicsum($this->eleve->id, 120, 120);
      //  dd($this->profile_url);

        $this->sections = Section::orderBy('nom')->get();


        $this->setFakeProfileImageUrl();
    }

    public function getSelectedInscription(Inscription $inscription)
    {
        $this->inscription2 = $inscription;
        $this->inscription2_categorie = $inscription->categorie;
        $this->inscription2_montant = $inscription->montant;

        $classe = $inscription->classe;
        $this->inscription2_classe_id = $classe->id;
        $filierable = $classe->filierable;

        if($filierable instanceof \App\Models\Filiere){
            $this->inscription2_filiere_id = $filierable->id;

            $option = Option::find($filierable->option_id);
            $this->inscription2_option_id = $option->id;

            $section = Section::find($option->section_id);
            $this->inscription2_section_id = $section->id;

        }else  if($filierable instanceof \App\Models\Option){
            $this->inscription2_option_id = $filierable->id;

            $section = Section::find($filierable->section_id);
            $this->inscription2_section_id = $section->id;

        }else  if($filierable instanceof \App\Models\Section){
            $this->inscription2_section_id = $filierable->id;
        }

        $this->options = Option::where('section_id', $this->inscription2_section_id)->orderBy('nom')->get();
        $this->filieres = Filiere::where('option_id', $this->inscription2_option_id)->orderBy('nom')->get();
       // $this->classes = Classe::orderBy('grade')->get();
        $this->loadAvailableClasses();
        // dd($inscription);
    }


    public function reloadData(){
        $this->eleve = Eleve::find($this->eleve->id);
        $this->inscription = Inscription::where(['eleve_id'=>$this->eleve->id,'annee_id'=>$this->annee_courante->id])->first();
        $this->responsable_relation = $this->eleve->responsable_eleve->relation;

        $this->setFakeProfileImageUrl();
    }

    public function render()
    {
        return view('livewire.admin.eleves.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur l\'élève']);
    }

    public function editRelation(){

        $done =$this->eleve->responsable_eleve->update([
            'relation' => $this->responsable_relation,
        ]);

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Relation modifiée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-relation-modal']);
        } else {
            $this->alert('warning', "Echec de modification de relation !");
        }
        $this->onModalClosed();

    }

    public function editInscription()
    {
        $done = $this->inscription2->update([
            'classe_id' => $this->inscription2_classe_id,
            'categorie' => $this->inscription2_categorie,
            'montant' => $this->inscription2_montant,
            //  'status' => InscriptionStatus::pending->value,
        ]);


        if ($done) {
            $this->reloadData();
            $this->alert('success', "Inscription modifiée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-inscription-modal']);
        } else {
            $this->alert('warning', "Echec de modification d'inscription !");
        }
        $this->onModalClosed();

    }


    public function deleteInscription()
    {
        $done = $this->inscription2->delete();

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Inscription supprimée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-inscription-modal']);
        } else {
            $this->alert('warning', "Echec de suppression d'inscription !");
        }
        $this->onModalClosed();

    }


    public function changeSection()
    {
        if ($this->inscription2_section_id > 0) {
            $section = Section::find($this->inscription2_section_id);
            $this->options = $section->options;
            if (count($this->options) > 0) {
                $this->inscription2_option_id = null;
                $this->inscription2_filiere_id = null;
            } else {
                $this->inscription2_option_id = null;
                $this->options = [];

                $this->inscription2_filiere_id = null;
                $this->filieres = [];
            }
        } else {
            $this->inscription2_option_id = null;
            $this->options = [];

            $this->inscription2_filiere_id = null;
            $this->filieres = [];
        }
        $this->loadAvailableClasses();
    }

    private function loadAvailableClasses()
    {
        if ($this->inscription2_filiere_id > 0) {
            $filiere = Filiere::find($this->inscription2_filiere_id);
            $this->classes = $filiere->classes;
        } else if ($this->inscription2_option_id > 0) {
            $option = Option::find($this->inscription2_option_id);
            $this->classes = $option->classes;
        } else if ($this->inscription2_section_id > 0) {
            $section = Section::find($this->inscription2_section_id);
            $this->classes = $section->classes;
        }
    }

    public function changeOption()
    {
        if ($this->inscription2_option_id > 0) {
            $option = Option::find($this->inscription2_option_id);
            $this->filieres = $option->filieres;
            if (count($this->filieres) > 0) {
                $this->inscription2_filiere_id = null;
            } else {
                $this->inscription2_filiere_id = null;
                $this->filieres = [];
            }
        } else {
            $this->inscription2_filiere_id = null;
            $this->filieres = [];
        }
        $this->loadAvailableClasses();
    }

    public function changeFiliere()
    {
        $this->loadAvailableClasses();
    }


}
