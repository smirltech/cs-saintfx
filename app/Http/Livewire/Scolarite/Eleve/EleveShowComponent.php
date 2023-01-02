<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Enums\ResponsableRelation;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Option;
use App\Models\Perception;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Models\Section;
use App\Traits\CanHandleEleveUniqueCode;
use App\Traits\FakeProfileImage;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;

class EleveShowComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;
    use FakeProfileImage;
    use CanHandleEleveUniqueCode;


    public $eleve;
    public $inscription, $inscription2;
    public $annee_courante;
    public $profile_url;

    public $responsable_relation;

    public $sections = [];
    public $options = [];
    public $filieres = [];
    public $classes = [];
    public $inscription_status;
    public $inscription2_categorie;
    public $inscription2_montant;
    public $inscription2_section_id;
    public $inscription2_option_id;
    public $inscription2_filiere_id;
    public $inscription2_classe_id;
    public $eleve_nom;
    public $eleve_postnom;
    public $eleve_prenom;
    public $eleve_sexe;
    public $eleve_lieu_naissance;
    public $eleve_date_naissance;
    public $eleve_adresse;
    public $eleve_email;
    public $eleve_telephone;
    public $numero_permanent;
    public $searchResponsable = '';

    //responsable
    public $responsable_id;
    public $responsable;
    public $responsables;
    public $responsable_relation2;

    protected $listeners = ['onModalClosed', 'refreshComponent' => '$refresh'];

    public function runSearchResponsables()
    {
        $this->responsables = Responsable::where('nom', 'LIKE', "%$this->searchResponsable%")->orderBy('nom')->get();
        if ($this->responsables->count() > 0) {
            $this->responsable_id = $this->responsables->first()->id;
        } else {
            $this->responsable_id = null;
        }
    }

    public function changeSelectedResponsable()
    {
        $this->responsable = Responsable::find($this->responsable_id);
        if ($this->responsable == null) {
            $this->responsable_id = null;
        } else {
            $this->responsable_id = $this->responsable->id;
        }
    }

    public function attachResponsable()
    {
        $done = ResponsableEleve::create([
            'relation' => $this->responsable_relation2,
            'eleve_id' => $this->eleve->id,
            'responsable_id' => $this->responsable_id,
        ]);

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Attachement au responsable avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'attach-responsable-modal']);
        } else {
            $this->alert('warning', "Echec d'attachement au responsable !");
        }
        $this->onModalClosed();

    }

    public function reloadData()
    {
        $this->eleve = Eleve::find($this->eleve->id);
        $this->inscription = Inscription::where(['eleve_id' => $this->eleve->id, 'annee_id' => $this->annee_courante->id])->first();
        $this->responsable_relation = $this->eleve->responsable_eleve?->relation;
        $this->preloadEleve();
        $this->setFakeProfileImageUrl();

        $this->emit('refreshComponent');
    }

    public function preloadEleve()
    {
        $this->eleve_nom = $this->eleve->nom;
        $this->eleve_postnom = $this->eleve->postnom;
        $this->eleve_prenom = $this->eleve->prenom;
        $this->eleve_sexe = $this->eleve->sexe;
        $this->eleve_lieu_naissance = $this->eleve->lieu_naissance;
        $this->eleve_date_naissance = $this->eleve->date_naissance->format('Y-m-d');
        $this->eleve_adresse = $this->eleve->adresse;
        $this->eleve_email = $this->eleve->email;
        $this->eleve_telephone = $this->eleve->telephone;
        $this->numero_permanent = $this->eleve->numero_permanent;
    }

    public function onModalClosed()
    {
        // $this->clearValidation();
        $this->reset(['inscription_status']);
    }

    public function mount(Eleve $eleve)
    {
        $this->eleve = $eleve;
        $this->annee_courante = Annee::where('encours', true)->first();
        $this->inscription = Inscription::where(['eleve_id' => $this->eleve->id, 'annee_id' => $this->annee_courante->id])->first();
        $this->responsable_relation = $this->eleve->responsable_eleve?->relation ?? null;
        $this->responsable_relation2 = ResponsableRelation::pere;
        // $this->profile_url =Helpers::fakePicsum($this->eleve->id, 120, 120);
        //  dd($this->profile_url);
        // $this->inscription_status = $this->inscription->status->value;

        $this->sections = Section::orderBy('nom')->get();
        $this->inscription2_categorie = InscriptionCategorie::normal;
        $this->preloadEleve();

        $this->responsables = Responsable::orderBy('nom')->get();
        if ($this->responsables->count() > 0) {
            $this->responsable_id = $this->responsables->first()->id;
        } else {
            $this->responsable_id = null;
        }

        $this->setFakeProfileImageUrl();
    }

    public function getSelectedInscription(Inscription $inscription)
    {
        $this->inscription2 = $inscription;
        $this->inscription2_categorie = $inscription->categorie;
        $this->inscription2_montant = $inscription->montant;

        $this->inscription_status = $this->inscription2->status->value;

        $classe = $inscription->classe;
        $this->inscription2_classe_id = $classe->id;
        $filierable = $classe->filierable;

        if ($filierable instanceof Filiere) {
            $this->inscription2_filiere_id = $filierable->id;

            $option = Option::find($filierable->option_id);
            $this->inscription2_option_id = $option->id;

            $section = Section::find($option->section_id);
            $this->inscription2_section_id = $section->id;

        } else if ($filierable instanceof Option) {
            $this->inscription2_option_id = $filierable->id;

            $section = Section::find($filierable->section_id);
            $this->inscription2_section_id = $section->id;

        } else if ($filierable instanceof Section) {
            $this->inscription2_section_id = $filierable->id;
        }

        $this->options = Option::where('section_id', $this->inscription2_section_id)->orderBy('nom')->get();
        $this->filieres = Filiere::where('option_id', $this->inscription2_option_id)->orderBy('nom')->get();
        // $this->classes = Classe::orderBy('grade')->get();
        $this->loadAvailableClasses();
        // dd($inscription);
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

    public function render()
    {
        return view('livewire.scolarite.eleves.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur l\'élève']);
    }

    public function editEleve()
    {
        $this->validate([
            'eleve_nom' => 'required',
            'eleve_postnom' => 'required',
        ]);
        $done = $this->eleve->update([
            'nom' => $this->eleve_nom,
            'postnom' => $this->eleve_postnom,
            'prenom' => $this->eleve_prenom,
            'sexe' => $this->eleve_sexe,
            'lieu_naissance' => $this->eleve_lieu_naissance,
            'date_naissance' => $this->eleve_date_naissance,
            'adresse' => $this->eleve_adresse,
            'email' => $this->eleve_email,
            'telephone' => $this->eleve_telephone,
            'numero_permanent' => $this->numero_permanent,
        ]);


        if ($done) {
            $this->reloadData();
            $this->alert('success', "Élève modifié avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-eleve-modal']);
        } else {
            $this->alert('warning', "Echec de modification d'élève !");
        }
        $this->onModalClosed();

    }

    public function editInscriptionCategorie()
    {
        $done = $this->validate(['inscription2_categorie' => 'required']);
        $this->inscription2->update([
            'categorie' => $this->inscription2_categorie,
        ]);

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Categorie inscription modifiée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-inscription-categorie-modal']);
        } else {
            $this->alert('warning', "Echec de modification de categorie inscription !");
        }
        $this->onModalClosed();

    }

    public function editInscriptionStatus()
    {
        $done = $this->validate(['inscription_status' => 'required']);
        $this->inscription2->update([
            'status' => $this->inscription_status,
        ]);

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Status inscription modifié avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-inscription-status-modal']);
        } else {
            $this->alert('warning', "Echec de modification de status inscription !");
        }
        $this->onModalClosed();

    }

    public function deleteEleve()
    {
        if (count($this->eleve->inscriptions) == 0) {
            ResponsableEleve::where('eleve_id', $this->eleve->id)->delete();
            if ($this->eleve->delete()) {
                $this->alert('success', "Élève supprimé avec succès !");
                $this->flash('success', 'Élève supprimé avec succès', [], route('scolarite.eleves'));
            }
        } else {

            $this->alert('warning', "Élève n'a pas été supprimé, il y a des inscriptions attachées !");
            $this->onModalClosed();
        }
    }

    public function editRelation()
    {

        $done = $this->eleve->responsable_eleve->update([
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

    public function deleteRelation()
    {

        $done = $this->eleve->responsable_eleve->delete();

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Relation supprimée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-relation-modal']);
        } else {
            $this->alert('warning', "Echec de suppression de relation !");
        }
        $this->onModalClosed();

    }

    public function addInscription()
    {
        $this->validate([
            'inscription2_classe_id' => 'required',
            'inscription2_categorie' => 'required',
        ]);

        try {
            $done = Inscription::create([
                'eleve_id' => $this->eleve->id,
                'classe_id' => $this->inscription2_classe_id,
                'annee_id' => $this->annee_courante->id,
                'categorie' => $this->inscription2_categorie,
                'montant' => $this->inscription2_montant,
                'code' => $this->getGeneratedUniqueCode(),
                'status' => InscriptionStatus::pending->value,
            ]);

            if ($done) {
                $this->reloadData();
                $this->alert('success', "Nouvelle inscription faite avec succès !");
                $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-inscription-modal']);
            } else {
                $this->alert('warning', "Echec d'ajout d'inscription,  !");
            }
            $this->onModalClosed();
        } catch (Throwable $e) {

            $this->alert('warning', "Une inscription pour cette année existe déjà !");

        }


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
