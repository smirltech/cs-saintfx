<?php

namespace App\Http\Livewire\Scolarite\Inscription;

use App\Enums\FraisFrequence;
use App\Enums\FraisType;
use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Enums\ResponsableRelation;
use App\Enums\Sexe;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Filiere;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Option;
use App\Models\Perception;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Models\Section;
use App\Traits\CanHandleEleveUniqueCode;
use App\Traits\InscriptionUniqueCode;
use App\Traits\TopMenuPreview;
use App\Traits\WithFileUploads;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InscriptionCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use WithFileUploads;
    use LivewireAlert;
    use CanHandleEleveUniqueCode;
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
    public $paid_by;
    public $status;
    public $code;
    public $fee_id;
    public $fee_montant;
    public $frequence;


    //eleve
    public $nom;
    public $lieu_naissance = "Lubumbashi";
    public $date_naissance;
    public $sexe;
    public $telephone;
    public $email;
    public $adresse;
    public $pere;
    public $mere;
    public $numero_permanent;

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
    public $has_paid = true;
    public Perception $perception;

    protected $listeners = ['onModalClosed'];
    protected $rules = [
        'nom' => 'required|string',
        'lieu_naissance' => 'nullable',
        'date_naissance' => 'nullable|date',
        'sexe' => 'nullable',
        'telephone' => 'nullable|string',
        'email' => 'nullable',
        'pere' => 'nullable',
        'mere' => 'nullable',

        'classe_id' => 'required|numeric|min:1|not_in:0',
        'filiere_id' => 'nullable|numeric|min:1|not_in:0',
        'option_id' => 'nullable|numeric|min:1|not_in:0',
        'section_id' => 'required|numeric|min:1|not_in:0',

        'categorie' => 'required|string',
        'fee_id' => 'nullable',
        'fee_montant' => 'nullable',
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
        $this->authorize("create", Inscription::class);
        $this->perception = new Perception();
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
        $this->addPerception($insc->id);

        // Todo: uncomment block below to enable the printing of the inscription form
        /* $this->printIt();
         $this->alert('success', "Élève inscrit avec succès !");*/

        // Todo: Comment line below when the printing above is to be considered
        $this->flash('success', 'Élève inscrit avec succès', [], route('scolarite.inscriptions'));


        //  $this->alert('error', "L'enregistrement de l'étudiant n'a pas aboutis, veuillez reéssayer !");

    }

    public function submitEleve(): Eleve
    {
        // $ucode = $this->getGeneratedUniqueCode();
        return Eleve::create([
            'nom' => $this->nom,
            'sexe' => $this->sexe,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'lieu_naissance' => $this->lieu_naissance,
            'date_naissance' => $this->date_naissance,
            'numero_permanent' => $this->numero_permanent,
            'section_id' => $this->section_id,
            'pere' => $this->pere,
            'mere' => $this->mere,
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
            'status' => InscriptionStatus::approved->value,
        ]);
    }

    public function addPerception($inscription_id)
    {
        if ($this->has_paid) {
            $this->validate([
                'fee_id' => 'required',
                'fee_montant' => 'required',
                'paid_by' => 'nullable',
            ]);

            try {
                $this->perception = Perception::create(
                    [
                        'user_id' => Auth::id(),
                        'frais_id' => $this->fee_id,
                        'inscription_id' => $inscription_id,
                        'frequence' => $this->frequence->name,
                        'custom_property' => FraisFrequence::annuel,
                        'annee_id' => $this->annee_courante->id,
                        'montant' => $this->fee_montant,
                        'due_date' => Carbon::now()->format('Y-m-d'),
                        'paid' => $this->fee_montant,
                        //'paid' => ($this->fee->type == FraisType::inscription and $this->paid == null) ? $this->montant : $this->paid,
                        'paid_by' => $this->paid_by,
                    ]
                );

                // $this->flash('success', "Frais imputé avec succès !", [], route('finance.perceptions'));

            } catch (Exception $exception) {
                $this->error(local: $exception->getMessage(), production: "Echec d'imputation de frais déjà existante !");
            }
        }
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
        return view('livewire.scolarite.inscriptions.create')
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

    function updatedSectionId(): void
    {
       $this->changeSection();
    }

    public function changeSection()
    {
        $this->options = [];
        $this->filieres = [];
        if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->options = $section?->options ?? [];
        }

        $this->option_id = null;
        $this->filiere_id = null;
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }

    private function loadAvailableClasses()
    {
        if ($this->filiere_id > 0) {
            $filiere = Filiere::find($this->filiere_id);
            $this->classes = $filiere?->classes ?? [];
        } else if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $this->classes = $option?->classes ?? [];
        } else if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->classes = $section?->classes ?? [];
        }
        $this->getAvailableFrais();
    }

    private function getAvailableFrais()
    {
        $ff = null;
        if ($this->classe_id != null) {
            $ff = Frais::
            where('annee_id', $this->annee_courante->id)
                ->where('type', FraisType::inscription)
                ->where('classable_type', 'like', '%Classe')
                ->where('classable_id', $this->classe_id)
                ->orderBy('nom')
                ->first();
            if ($ff != null) {
                $this->fee_id = $ff->id;
                $this->fee_montant = $ff->montant;
                $this->frequence = $ff->frequence;
            }
        }
        if ($ff == null && $this->filiere_id != null) {
            $ff = Frais::
            where('annee_id', $this->annee_courante->id)
                ->where('type', FraisType::inscription)
                ->where('classable_type', 'like', '%Filiere')
                ->where('classable_id', $this->filiere_id)
                ->orderBy('nom')
                ->first();
            if ($ff != null) {
                $this->fee_id = $ff->id;
                $this->fee_montant = $ff->montant;
                $this->frequence = $ff->frequence;
            }
        }
        if ($ff == null && $this->option_id != null) {
            $ff = Frais::
            where('annee_id', $this->annee_courante->id)
                ->where('type', FraisType::inscription)
                ->where('classable_type', 'like', '%Option')
                ->where('classable_id', $this->option_id)
                ->orderBy('nom')
                ->first();
            if ($ff != null) {
                $this->fee_id = $ff->id;
                $this->fee_montant = $ff->montant;
                $this->frequence = $ff->frequence;
            }
        }
        if ($ff == null && $this->section_id != null) {
            $ff = Frais::
            where('annee_id', $this->annee_courante->id)
                ->where('type', FraisType::inscription)
                ->where('classable_type', 'like', '%Section')
                ->where('classable_id', $this->section_id)
                ->orderBy('nom')
                ->first();
            if ($ff != null) {
                $this->fee_id = $ff->id;
                $this->fee_montant = $ff->montant;
                $this->frequence = $ff->frequence;
            }
        }
        if ($ff == null) {
            $this->fee_id = null;
            $this->fee_montant = null;
            $this->frequence = null;
        }

    }

    public function changeOption()
    {
        $this->filieres = [];
        if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $this->filieres = $option?->filieres ?? [];
        }
        $this->filiere_id = null;
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }

    public function changeFiliere()
    {
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }


    // Perception add for inscription

    public function changeClasse()
    {
        $this->loadAvailableClasses();
    }

    private function printIt()
    {

        $this->dispatchBrowserEvent('printIt', ['elementId' => "inscriptionPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
