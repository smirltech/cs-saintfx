<?php

namespace App\Http\Livewire\Etudiant;

use App\Enum\EtudiantSexe;
use App\Enum\EtudiantStep;
use App\Enum\MediaType;
use App\Enum\PromotionGrade;
use App\Models\Annee;
use App\Models\Diplome;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Option;
use App\Models\Otp;
use App\Models\Promotion;
use App\Traits\HandleOtp;
use App\Traits\WithFileUploads;
use Illuminate\Validation\Rules\Enum;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class InscriptionEtudiant extends Component
{
    use HandleOtp, LivewireAlert, WithFileUploads;

    public $title = 'Adresse email';

    public Otp $otp;
    public Etudiant $etudiant;
    public Diplome $diplome;
    public $code = '';
    public $email;

    public $certificat_bvm;
    public $certificat_naissance;
    public $certificat_residence;
    public $diplome_docu;

    public $facultes = [];
    public $faculte_id;
    public $faculte2_id;
    public $filieres = [];
    public $filieres2 = [];
    public $filiere_id;
    public $filiere2_id;

    public $bordereau;


    // mount
    public function mount()
    {
        // email from session
        $this->email = session('email');
        if ($this->email) {
            $this->etudiant = $this->createEtudiant($this->email);
            $this->title = $this->etudiant->step->label();


            $this->facultes = Option::all();
        }

        $this->diplome = $this->etudiant->diplome ?? new Diplome();

    }

    private function createEtudiant(string $email)
    {

        $etudiant = Etudiant::where('email', $email)->first();

        if ($etudiant) {
            return $etudiant;
        } else {
            return Etudiant::create([
                'email' => $email,
                'step' => EtudiantStep::one->value,
            ]);
        }
    }

    public function render()
    {


        return view('livewire.etudiant.inscription-etudiant')->layout('layouts.app');
    }

    // send otp

    public function submitOtp()
    {

        $data = $this->validate([
            'email' => 'required|email',
        ]);

        $this->otp = $this->sendOtp(email: $data['email']);

        $this->alert(type: 'info', message: 'Un code de vefication a été envoyé à votre adresse email ' . $data['email'], options: ['timer' => 5000]);
    }

    // verify otp

    public function submitVerifyOtp()
    {
        $data = $this->validate([
            'code' => 'required|digits:4',
        ]);

        if ($this->verifyOtp(otp: $this->otp, code: $data['code'])) {
            $this->alert(message: 'Code valide');
            $this->etudiant = $this->createEtudiant($this->email);
            session()->put('email', $this->email);
        } else {
            $this->alert(type: 'error', message: 'Code invalide');
        }


    }

    public function submit1()
    {
        $this->validate([
            'etudiant.telephone' => 'required|unique:etudiants,telephone'
        ]);

        $this->etudiant->step = EtudiantStep::two->value;
        $this->etudiant->save();
        $this->title = $this->etudiant->step->label();

        $this->alert(message: 'Etape 1 terminée');
    }

    public function submit2()
    {
        $this->etudiant->step = EtudiantStep::three->value;
        $this->etudiant->save();
        $this->title = $this->etudiant->step->label();

        $this->alert(message: 'Etape 2 terminée');
    }

    // submit step one

    public function submit3()
    {
        if ($this->certificat_bvm)
            $this->upload(file: $this->certificat_bvm, entity: $this->etudiant, mediaType: MediaType::piece_identite);

        if ($this->certificat_naissance)
            $this->upload(file: $this->certificat_naissance, entity: $this->etudiant, mediaType: MediaType::piece_identite);

        if ($this->certificat_residence)
            $this->upload(file: $this->certificat_residence, entity: $this->etudiant, mediaType: MediaType::piece_identite);

        $this->etudiant->step = EtudiantStep::four->value;
        $this->title = $this->etudiant->step->label();
        $this->etudiant->save();

        $this->alert(message: 'Etape 3 terminée');
    }


    public function submit4()
    {
        $this->diplome->etudiant_id = $this->etudiant->id;
        $this->diplome->save();

        if ($this->diplome_docu)
            $this->upload(file: $this->diplome_docu, entity: $this->diplome, mediaType: MediaType::diplome);

        $this->etudiant->step = EtudiantStep::five->value;
        $this->title = $this->etudiant->step->label();
        $this->etudiant->save();

        $this->alert(message: 'Etape 4 terminée');
    }

    public function submit5()
    {

        $promotion = Promotion::where('filiere_id', $this->filiere_id)->where('grade', PromotionGrade::bac1->value)->first();
        $promotion2 = Promotion::where('filiere_id', $this->filiere2_id)->where('grade', PromotionGrade::bac1->value)->first();
        $annee = Annee::encours();

        $admission = $this->etudiant->admissions()->create([
            'promotion_id' => $promotion->id ?? null,
            'promotion2_id' => $promotion2->id ?? null,
            'annee_id' => $annee->id,
        ]);

        if ($this->bordereau)
            $this->upload(file: $this->bordereau, entity: $admission, mediaType: MediaType::bordereaux);

        $this->etudiant->step = EtudiantStep::complete;
        $this->title = $this->etudiant->step->label();
        $this->etudiant->save();

        //TODO: notify admin
        //TODO: notify etudiant

        $this->alert(message: 'Votre demande d\'admission a été enregistrée avec succès');
    }

    public function changeFaculte()
    {

        $this->filieres = Filiere::has('promotions')->where('faculte_id', $this->faculte_id)->get();
    }

    public function changeFaculte2()
    {

        $this->filieres2 = Filiere::has('promotions')->where('faculte_id', $this->faculte2_id)->get();
    }

    protected function rules()
    {
        return [
            'etudiant.nom' => 'required',
            'etudiant.postnom' => 'required',
            'etudiant.prenom' => 'required',
            'etudiant.telephone' => 'required|unique:etudiants,telephone',
            'etudiant.date_naissance' => 'required',
            'etudiant.lieu_naissance' => 'required',
            'etudiant.sexe' => ['required', new Enum(EtudiantSexe::class)],
            'etudiant.adresse' => 'required',
            'etudiant.pere' => 'required',
            'etudiant.mere' => 'required',
            'etudiant.tuteur' => 'required',
            'etudiant.contact_urgence' => 'required',
            'etudiant.adresse_urgence' => 'nullable',


            'diplome.numero' => 'nullable',
            'diplome.pourcentage' => 'required',
            'diplome.section' => 'required',
            'diplome.date_delivrance' => 'required',
            'diplome.lieu_delivrance' => 'required',
            'diplome.ecole' => 'required',
            'diplome.code_ecole' => 'required',
            'diplome.option' => 'nullable',
        ];


    }
}
