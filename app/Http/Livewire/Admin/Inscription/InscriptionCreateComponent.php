<?php

namespace App\Http\Livewire\Admin\Inscription;

use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Enums\ResponsableRelation;
use App\Enums\Sexe;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Option;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Models\Section;
use App\Traits\EleveUniqueCode;
use App\Traits\InscriptionUniqueCode;
use App\Traits\WithFileUploads;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class InscriptionCreateComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use EleveUniqueCode;
    use InscriptionUniqueCode;

    public $options = [];
    public $sections = [];
    public $filieres = [];
    public $classes = [];

    //inscription
    public $section_id;
    public $option_id;
    public $filiere_id;
    public $classe_id;

    public $categorie;
    public $montant;
    public $status;
    public $code;


    //eleve
    public $nom;
    public $postnom;
    public $prenom;
    public $lieu_naissance = "Lubumbashi";
    public $date_naissance;
    public $sexe;
    public $telephone;
    public $email;
    public $adresse;
    public $matricule;

    //responsable
    public $searchResponsable = '';
    public $chooseResponsable = false;

    public $responsable_id;
    public $responsable_nom;
    public $responsable_sexe;
    public $responsable_telephone;
    public $responsable_email;
    public $responsable_adresse;
    public $responsable_relation;

    public $responsable;
    public $responsables;

    public $annee_courante;

    protected $listeners = ['onModalClosed'];
    protected $rules = [
        'nom' => 'required|string',
        'postnom' => 'required|string',
        'prenom' => 'nullable|string',
        'lieu_naissance' => 'nullable',
        'date_naissance' => 'nullable|date',
        'sexe' => 'nullable',
        'telephone' => 'nullable|string',
        'email' => 'nullable',

        'classe_id' => 'required|numeric|min:1|not_in:0',
        'filiere_id' => 'nullable|numeric|min:1|not_in:0',
        'option_id' => 'nullable|numeric|min:1|not_in:0',
        'section_id' => 'required|numeric|min:1|not_in:0',

        'categorie' => 'required|string',
    ];
    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'postnom.required' => 'Ce postnom est obligatoire !',
        'section_id.required' => 'La section est obligatoire !',
        'classe_id.required' => 'La classe est obligatoire !',
        'categorie.required' => 'La categorie est obligatoire !',

    ];

    public function setChooseResponsable()
    {
        $this->chooseResponsable = !$this->chooseResponsable;
        if ($this->chooseResponsable) {
            $this->searchResponsable = '';
        } else {
            $this->responsable = null;
            $this->responsable_nom = null;
            $this->responsable_id = null;

        }
    }

    public function runSearch()
    {
        $this->responsables = Responsable::where('nom', 'LIKE', "%$this->searchResponsable%")->orderBy('nom')->get();
    }

    public function mount()
    {
        $this->responsables = Responsable::orderBy('nom')->get();

        $this->annee_courante = Annee::where('encours', true)->first();
        $this->date_naissance = Carbon::today()->subYears(3)->toDateString();
        $this->sections = Section::orderBy('nom')->get();
        $this->sexe = Sexe::m->value;
        $this->categorie = InscriptionCategorie::normal->value;
        $this->responsable_relation = ResponsableRelation::pere->value;
        $this->responsable_sexe = Sexe::m->value;
    }

    public function submit()
    {
        $this->validate();

        $ele = $this->submitEleve();
        if ($this->responsable != null) $res_ele = $this->submitResponsableEleve($this->responsable, $ele);
        $insc = $this->submitInscription($ele);
        $this->flash('success', 'Élève inscrit avec succès', [], route('admin.inscriptions'));


        //  $this->alert('error', "L'enregistrement de l'étudiant n'a pas aboutis, veuillez reéssayer !");

    }

    public function submitEleve()
    {
        $ucode = $this->getGeneratedUniqueCode();
        return Eleve::create([
            'nom' => $this->nom,
            'postnom' => $this->postnom,
            'prenom' => $this->prenom,
            'sexe' => $this->sexe,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'lieu_naissance' => $this->lieu_naissance,
            'date_naissance' => $this->date_naissance,
            'matricule' => $this->matricule,
            'code' => $ucode,
        ]);
    }

    public function submitResponsableEleve($responsable, $eleve)
    {
        return ResponsableEleve::create([
            'relation' => $this->responsable_relation,
            'eleve_id' => $eleve->id,
            'responsable_id' => $responsable->id,
        ]);
    }

    public function submitResponsable()
    {
        $this->validate([
            'responsable_nom' => 'required|string',

        ]);
        if (isset($this->responsable_nom)) {
            $this->responsable = Responsable::create([
                'nom' => $this->responsable_nom,
                'sexe' => $this->responsable_sexe,
                'telephone' => $this->responsable_telephone,
                'email' => $this->responsable_email,
                'adresse' => $this->responsable_adresse,
            ]);
            $this->responsable_id = $this->responsable->id;
            $this->responsable_nom = $this->responsable?->nom ?? null;

            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-responsable-modal']);
            $this->onModalClosed();
        }

    }

    public function onModalClosed()
    {
        $this->chooseResponsable = false;
        $this->searchResponsable = '';
    }

    public function render()
    {
        // $this->responsables = Responsable::orderBy('nom')->get();
        return view('livewire.admin.inscriptions.create')
            ->layout(AdminLayout::class, ['title' => 'Inscription Élève']);
    }

    public function changeSelectedResponsable()
    {
        $this->responsable = Responsable::find($this->responsable_id);
        $this->responsable_nom = $this->responsable?->nom ?? null;

        if ($this->responsable == null) {
            $this->responsable_nom = null;
            $this->responsable_id = null;
        }
    }

    public function changeSection()
    {
        if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->options = $section->options;
            if (count($this->options) > 0) {
                $this->option_id = null;
                $this->filiere_id = null;
            } else {
                $this->option_id = null;
                $this->options = [];

                $this->filiere_id = null;
                $this->filieres = [];
            }
        } else {
            $this->option_id = null;
            $this->options = [];

            $this->filiere_id = null;
            $this->filieres = [];
        }
        $this->loadAvailableClasses();
    }

    public function changeOption()
    {
        if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $this->filieres = $option->filieres;
            if (count($this->filieres) > 0) {
                $this->filiere_id = null;
            } else {
                $this->filiere_id = null;
                $this->filieres = [];
            }
        } else {
            $this->filiere_id = null;
            $this->filieres = [];
        }
        $this->loadAvailableClasses();
    }

    public function changeFiliere()
    {
        $this->loadAvailableClasses();
    }

    private function submitInscription($eleve)
    {
        $icode = $this->getGeneratedInscriptionUniqueCode();
        return Inscription::create([
            'eleve_id' => $eleve->id,
            'classe_id' => $this->classe_id,
            'annee_id' => $this->annee_courante->id,
            'categorie' => $this->categorie,
            'montant' => $this->montant,
            'status' => InscriptionStatus::pending->value,
            'code' => $icode,
        ]);
    }

    private function loadAvailableClasses()
    {
        if ($this->filiere_id > 0) {
            $filiere = Filiere::find($this->filiere_id);
            $this->classes = $filiere->classes;
        } else if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $this->classes = $option->classes;
        } else if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->classes = $section->classes;
        }
    }

}
