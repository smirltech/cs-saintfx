<?php

namespace App\Http\Livewire\Admin\Etudiant;

use App\Enum\AdmissionStatus;
use App\Enum\EtatCivil;
use App\Enum\EtudiantSexe;
use App\Enum\EtudiantStep;
use App\Enum\MediaType;
use App\Models\Admission;
use App\Models\Annee;
use App\Models\Diplome;
use App\Models\Etudiant;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Traits\WithFileUploads;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EtudiantCreateComponent extends Component
{
    use WithFileUploads;
    use LivewireAlert;


    public $bordereau;
    public $piece;
    public $fiche;
    // public $profile;

    public $nom;
    public $postnom;
    public $prenom;
    public $lieu_naissance = "Lubumbashi";
    public $date_naissance;
    public $sexe;
    public $telephone;
    public $email;
    public $etat_civil;
    public $pere;
    public $mere;
    public $tuteur;
    public $origine;
    public $adresse_urgence;
    public $contact_urgence;
    public $adresse;

    public $facultes = [];
    public $filieres = [];
    public $promotions = [];

    public $facultes2 = [];
    public $filieres2 = [];
    public $promotions2 = [];

    public $faculte_id = -1;
    public $filiere_id = -1;
    public $promotion_id = -1;

    public $faculte2_id = -1;
    public $filiere2_id = -1;
    public $promotion2_id = -1;

    public $annee_courante;


    // About the last diploma
    public $numero;
    public $pourcentage;
    public $section;
    public $option;
    public $date_delivrance;
    public $ecole;
    public $code_ecole;
    public $province_ecole;


    protected $rules = [
        'nom' => 'required|string',
        'postnom' => 'required|string',
        'prenom' => 'nullable|string',
        'lieu_naissance' => 'required',
        'date_naissance' => 'required|date',
        'sexe' => 'required',
        'telephone' => 'nullable|string|unique:etudiants',
        'email' => 'required|unique:etudiants',
        'filiere_id' => 'required|numeric|min:1|not_in:0',
        'promotion_id' => 'required|numeric|min:1|not_in:0',
        'faculte_id' => 'required|numeric|min:1|not_in:0',

        'filiere2_id' => 'nullable|numeric|min:1|not_in:0',
        'promotion2_id' => 'nullable|numeric|min:1|not_in:0',
        'faculte2_id' => 'nullable|numeric|min:1|not_in:0',

        'bordereau' => 'nullable|mimes:pdf|max:3000',
        'piece' => 'nullable|mimes:pdf|max:3000',
        'fiche' => 'nullable|mimes:pdf|max:3000',
    ];
    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'postnom.required' => 'Ce postnom est obligatoire !',
        'lieu_naissance.required' => 'Ce lieu de naissance est obligatoire !',
        'date_naissance.required' => 'Cette date de naissance est obligatoire !',
        'sexe.required' => 'Choisir le sexe !',
        'email.required' => 'Cette adresse e-mail est obligatoire !',
        'faculte_id.min' => 'Choisir une faculté',
        'filiere_id.min' => 'Choisir une filière',
        'promotion_id.min' => 'Choisir une promotion',
    ];

    public function mount()
    {
        $this->annee_courante = Annee::where('encours', true)->first();
        $this->date_naissance = Carbon::today()->subYears(16)->toDateString();
        //$this->date_delivrance = Carbon::today()->subYears(1)->toDateString();
        $this->facultes = Faculte::orderBy('nom')->get();
        $this->facultes2 = Faculte::orderBy('nom')->get();
        $this->sexe = EtudiantSexe::m->value;

        $this->etat_civil = EtatCivil::single->value;
    }

    public function submit()
    {
        $this->validate();
        $student = Etudiant::create([
            'nom' => $this->nom,
            'postnom' => $this->postnom,
            'prenom' => $this->prenom,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'sexe' => $this->sexe,
            'etat_civil' => $this->etat_civil,
            'date_naissance' => $this->date_naissance,
            'lieu_naissance' => $this->lieu_naissance,
            'adresse' => $this->adresse,
            'mere' => $this->mere,
            'pere' => $this->pere,
            'tuteur' => $this->tuteur ?? $this->pere,
            'origine' => $this->origine,
            'adresse_urgence' => $this->adresse_urgence,
            'contact_urgence' => $this->contact_urgence,
            'step' => EtudiantStep::complete->value,
        ]);

        if ($student) {
            $this->submitDiplome($student->id);
            $done = $this->submitAdmission($student->id);
            $this->uploadDocuments($student);
            if ($done) {
                $this->reset(
                    [
                        'nom',
                        'postnom',
                        'prenom',
                        'telephone',
                        'email',
                        'sexe',
                        'etat_civil',
                        'date_naissance',
                        'lieu_naissance',
                        'adresse',
                        'mere',
                        'pere',
                        'tuteur',
                        'origine',
                        'contact_urgence',
                    ]
                );

                // upload media
                //$this->upload(null, $student->id, MediaType::bordereaux);

                $this->flash('success', "Etudiant $this->nom inscrit avec succès !", [], route('admin.admissions.index'));

            } else {
                $this->alert('error', "L'inscription de l'étudiant n'a pas aboutis, veuillez reéssayer !");
            }

        } else {
            $this->alert('error', "L'enregistrement de l'étudiant n'a pas aboutis, veuillez reéssayer !");
        }
    }

    public function submitDiplome($etudiant_id)
    {
        return Diplome::create([
            'etudiant_id' => $etudiant_id,
            'numero' => $this->numero,
            'pourcentage' => $this->pourcentage,
            'section' => $this->section,
            'option' => $this->option,
            'date_delivrance' => $this->date_delivrance,
            'ecole' => $this->ecole,
            'code_ecole' => $this->code_ecole,
            'province_ecole' => $this->province_ecole,
        ]);
    }

    private function submitAdmission($etudiant_id)
    {
        $done = Admission::create([
            'etudiant_id' => $etudiant_id,
            'promotion_id' => $this->promotion_id,
            'promotion2_id' => $this->promotion2_id,
            'annee_id' => $this->annee_courante->id,
            'status' => AdmissionStatus::pending->value,
        ]);

        return $done;
    }

    public function uploadDocuments($etudiant)
    {
        if ($this->bordereau)
            $this->upload(file: $this->bordereau, entity: $etudiant, mediaType: MediaType::bordereaux);

        if ($this->piece)
            $this->upload(file: $this->piece, entity: $etudiant, mediaType: MediaType::diplome);

        if ($this->fiche)
            $this->upload(file: $this->fiche, entity: $etudiant, mediaType: MediaType::fiche_inscription);
    }

    public function render()
    {

        return view('livewire.admin.etudiant-academique.create')
            ->layout(AdminLayout::class, ['title' => 'Admission Etudiant']);
    }

    public function changeFaculte()
    {
        if ($this->faculte_id > 0) {
            $faculte = Faculte::find($this->faculte_id);
            $this->filieres = $faculte->filieres;
            if (count($this->filieres) > 0) {
                $filiere = $this->filieres[0];
                $this->filiere_id = $filiere->id;
                $this->promotions = $filiere->promotions;
                if (count($this->promotions) > 0) {
                    $this->promotion_id = $this->promotions[0]->id;
                } else {
                    $this->promotion_id = -1;
                    $this->promotion2_id = -1;
                }
            } else {
                $this->filiere_id = -1;
                $this->promotions = [];
                $this->promotion_id = -1;

                $this->filiere2_id = -1;
                $this->promotions2 = [];
                $this->promotion2_id = -1;
                $this->faculte2_id = -1;
            }
        } else {
            $this->filieres = [];
            $this->filiere_id = -1;
            $this->promotions = [];
            $this->promotion_id = -1;

            $this->filieres2 = [];
            $this->filiere2_id = -1;
            $this->promotions2 = [];
            $this->promotion2_id = -1;
            $this->faculte2_id = -1;
        }
    }

    public function changeFiliere()
    {
        if ($this->filiere_id > 0) {
            $filiere = Filiere::find($this->filiere_id);
            $this->promotions = $filiere->promotions;
            if (count($this->promotions) > 0) {
                $this->promotion_id = $this->promotions[0]->id;
            } else {
                $this->promotion_id = -1;

                $this->promotion2_id = -1;
                $this->faculte2_id = -1;
            }
        } else {
            $this->promotions = [];
            $this->promotion_id = -1;

            $this->promotions2 = [];
            $this->promotion2_id = -1;
            $this->faculte2_id = -1;
        }
    }

    public function changeFaculte2()
    {
        if ($this->faculte2_id > 0) {
            $faculte = Faculte::find($this->faculte2_id);
            $this->filieres2 = $faculte->filieres;
            if (count($this->filieres2) > 0) {
                $filiere = $this->filieres2[0];
                $this->filiere2_id = $filiere->id;
                $this->promotions2 = $filiere->promotions;
                if (count($this->promotions2) > 0) {
                    $this->promotion2_id = $this->promotions2[0]->id;
                } else {
                    $this->promotion2_id = -1;
                }
            } else {
                $this->filiere2_id = -1;
                $this->promotions2 = [];
                $this->promotion2_id = -1;
            }
        } else {
            $this->filieres2 = [];
            $this->filiere2_id = -1;
            $this->promotions2 = [];
            $this->promotion2_id = -1;
        }
    }

    public function changeFiliere2()
    {
        if ($this->filiere2_id > 0) {
            $filiere = Filiere::find($this->filiere2_id);
            $this->promotions2 = $filiere->promotions;
            if (count($this->promotions2) > 0) {
                $this->promotion2_id = $this->promotions2[0]->id;
            } else {
                $this->promotion2_id = -1;
            }
        } else {
            $this->promotions2 = [];
            $this->promotion2_id = -1;
        }
    }
}
