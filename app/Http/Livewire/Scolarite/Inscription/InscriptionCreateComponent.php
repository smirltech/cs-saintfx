<?php

namespace App\Http\Livewire\Scolarite\Inscription;

use App\Enums\FraisFrequence;
use App\Enums\FraisType;
use App\Enums\InscriptionStatus;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Perception;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Traits\CanHandleEleveUniqueCode;
use App\Traits\InscriptionUniqueCode;
use App\Traits\TopMenuPreview;
use App\Traits\WithFileUploads;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InscriptionCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use WithFileUploads;
    use LivewireAlert;
    use CanHandleEleveUniqueCode;
    use InscriptionUniqueCode;


    public Collection $classes;

    public $has_paid = true;
    public Perception $perception;
    public Eleve $eleve;
    public Inscription $inscription;
    public ResponsableEleve $responsableEleve;

    public Collection $responsables;
    protected $listeners = ['onModalClosed'];
    protected $rules = [
        'eleve.nom' => 'required|string',
        'eleve.lieu_naissance' => 'nullable',
        'eleve.date_naissance' => 'nullable|date',
        'eleve.sexe' => 'nullable',
        'eleve.telephone' => 'nullable|string',
        'eleve.email' => 'nullable',
        'eleve.adresse' => 'nullable',
        'eleve.pere' => 'nullable',
        'eleve.mere' => 'nullable',

        'inscription.classe_id' => 'required|numeric|min:1|not_in:0',

        'responsableEleve.responsable_id' => 'nullable',
        'responsableEleve.relation' => 'nullable',

        'inscription.categorie' => 'required|string',
        'perception.fee_id' => 'nullable',
        'perception.fee_montant' => 'nullable',
    ];
    protected $messages = [

        'eleve.nom.required' => 'Ce nom est obligatoire !',
        'inscription.classe_id.required' => 'La classe est obligatoire !',
        'inscription.categorie.required' => 'La categorie est obligatoire !',

    ];

    /**
     * @throws AuthorizationException
     */
    public function mount(Inscription $inscription): void
    {
        $this->authorize("create", Inscription::class);
        $this->inscription = $inscription;
        $this->eleve = $inscription->id ? $inscription->eleve : new Eleve();
        $this->perception = new Perception();
        $this->responsableEleve = new ResponsableEleve();
        $this->responsables = Responsable::orderBy('nom')->get();
        $this->classes = Classe::all();
    }

    public function submit(): void
    {
        $this->validate();

        $ele = $this->submitEleve();
        /*  if ($this->responsable != null)
              $res_ele = $this->submitResponsableEleve($this->responsable, $ele);*/
        $insc = $this->submitInscription($ele);


        // Todo: uncomment block below to enable the printing of the inscription form
        /* $this->printIt();
         $this->alert('success', "Élève inscrit avec succès !");*/

        // Todo: Comment line below when the printing above is to be considered
        $this->flash('success', 'Élève inscrit avec succès', [], route('scolarite.inscriptions'));


        //  $this->alert('error', "L'enregistrement de l'étudiant n'a pas aboutis, veuillez reéssayer !");

    }

    public function submitEleve(): bool
    {
        // $ucode = $this->getGeneratedUniqueCode();
        return $this->eleve->save();
    }

    private function submitInscription($eleve): bool
    {
        return $this->inscription->fill([
            'eleve_id' => $eleve->id,
            'annee_id' => Annee::id(),
            'montant' => $this->montant,
            'status' => InscriptionStatus::approved->value,
        ])->save();
    }

    public function addPerception($inscription_id): void
    {
        if ($this->has_paid) {
            $this->validate([
                'perception.fee_id' => 'required',
                'perception.fee_montant' => 'required',
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

    public function render(): Factory|View|Application
    {
        // $this->responsables = Responsable::orderBy('nom')->get();
        return view('livewire.scolarite.inscriptions.create')
            ->layout(AdminLayout::class, ['title' => 'Inscription Élève']);
    }


    //updatedClasseId
    public function updatedClasseId(): void
    {

    }

    private function getAvailableFrais(): void
    {
        $ff = null;
        if ($this->classe_id != null) {
            $ff = Frais::where('annee_id', $this->annee_courante->id)
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

    }
}
