<?php

namespace App\Http\Livewire\Admin\Inscription;

use App\Enum\EleveSexe;
use App\Enum\EtudiantStep;
use App\Enum\InscriptionStatus;
use App\Enum\MediaType;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Option;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Models\Section;
use App\Traits\WithFileUploads;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class InscriptionCreateComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;

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
    public $responsable_nom;
    public $responsable_sexe;
    public $responsable_telephone;
    public $responsable_email;
    public $responsable_adresse;
    public $responsable_relation;

    public $annee_courante;


    protected $rules = [
        'nom' => 'required|string',
        'postnom' => 'required|string',
        'prenom' => 'nullable|string',
        'lieu_naissance' => 'nullable',
        'date_naissance' => 'nullable|date',
        'sexe' => 'nullable',
        'telephone' => 'nullable|string|unique:etudiants',
        'email' => 'required|unique:etudiants',

        'classe_id' => 'required|numeric|min:1|not_in:0',
        'filiere_id' => 'nullable|numeric|min:1|not_in:0',
        'option_id' => 'nullable|numeric|min:1|not_in:0',
        'section_id' => 'required|numeric|min:1|not_in:0',

    ];
    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'postnom.required' => 'Ce postnom est obligatoire !',

    ];

    public function mount()
    {
        $this->annee_courante = Annee::where('encours', true)->first();
        $this->date_naissance = Carbon::today()->subYears(3)->toDateString();
        //$this->date_delivrance = Carbon::today()->subYears(1)->toDateString();
        $this->sections = Section::orderBy('nom')->get();

        $this->sexe = EleveSexe::m->value;
    }

    public function submit()
    {
        $this->validate();

        $resp = $this->submitResponsable();
        $ele = $this->submitEleve($resp);
        $res_ele = $this->submitResponsableEleve($resp, $ele);
        $insc = $this->submitInscription($ele);
        $this->flash('success', 'Élève inscrit avec succès', [], route('admin.eleves'));


        //  $this->alert('error', "L'enregistrement de l'étudiant n'a pas aboutis, veuillez reéssayer !");

    }

    public function submitResponsable()
    {
        return Responsable::create([
            'nom' => $this->responsable_nom,
            'sexe' => $this->responsable_sexe,
            'telephone' => $this->responsable_telephone,
            'email' => $this->responsable_email,
            'adresse' => $this->responsable_adresse,
        ]);
    }

    public function submitEleve($responsable)
    {
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
            'responsable_id' => $responsable->id,
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

    private function submitInscription($eleve)
    {
        return Inscription::create([
            'eleve_id' => $eleve->id,
            'classe_id' => $this->classe_id,
            'annee_id' => $this->annee_courante->id,
            'categorie' => $this->categorie,
            'montant' => $this->montant,
            'status' => InscriptionStatus::pending->value,
            'code' => $this->code,
        ]);
    }


    public function render()
    {

        return view('livewire.admin.inscriptions.create')
            ->layout(AdminLayout::class, ['title' => 'Inscription Élève']);
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
