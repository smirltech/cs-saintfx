<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\FraisType;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Option;
use App\Models\Perception;
use App\Models\Section;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PerceptionEditComponent extends Component
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public $perception;
    public $annee_id;
    public $user_id;
    public $raisons = [];
    public $fee;

    public $eleveNom;
    public $classe_id;
    public $annee_nom;
    protected $rules = [
        'perception.custom_property' => 'nullable',
        'perception.inscription_id' => 'nullable',
        'perception.frais_id' => 'nullable',
        'perception.due_date' => 'nullable',
        'perception.montant' => 'required',
        'perception.inscription.classe_id' => 'nullable',
        'perception.paid' => 'nullable',
        'perception.paid_by' => 'nullable',
    ];
    private $annee;
    private $frais;
    private $inscriptions = [];
    private $inscription;

    public function mount(Perception $perception)
    {
        //dd($perception->inscription->eleve);
        $this->user_id = Auth::id();
        $this->annee = Annee::encours();
        $this->annee_id = $this->annee->id;
        $this->annee_nom = $this->annee->nom;
        $this->perception = $perception;


        /* if ($this->perception->inscription_id) {
             $this->inscription = Inscription::find($this->perception->inscription_id);
             //  dd($this->inscription);
             $this->eleveNom = $this->inscription->eleve?->nomComplet;

             $this->classe_id = $this->inscription->classe->id;
         }*/


        $this->fee = $this->perception->frais;
        //dd($this->fee);
        $this->raisons = $this->fee != null ? $this->fee->frequence->children() : [];


        $this->chooseSuitableFrais();
    }

    private function chooseSuitableFrais()
    {
        // $this->loadInscriptionFrais();

        $this->inscription = $this->perception->inscription;//Inscription::find($this->inscription_id);
        $cclasse = Classe::find($this->inscription->classe_id);
        $fofo = Frais::
        where('annee_id', $this->annee_id)
            ->where('classable_type', 'like', '%Classe')
            ->where('classable_id', $cclasse->id)
            ->orderBy('nom')
            ->get();

        $this->frais = $fofo;

        $cfiliere = Filiere::find($cclasse->filierable_id);

        if ($cfiliere) {
            $frais2 = Frais::
            where('annee_id', $this->annee_id)
                ->where('classable_type', 'like', '%Filiere')
                ->where('classable_id', $cfiliere->id)
                ->orderBy('nom')
                ->get();
            $this->frais = $this->frais->merge($frais2);

            $foption = Option::find($cfiliere->option_id);

            if ($foption) {
                $frais2f = Frais::
                where('annee_id', $this->annee_id)
                    ->where('classable_type', 'like', '%Option')
                    ->where('classable_id', $foption->id)
                    ->orderBy('nom')
                    ->get();
                $this->frais = $this->frais->merge($frais2f);
            }

            $fsection = Section::find($cfiliere->section_id);

            if ($fsection) {
                $frais3f = Frais::
                where('annee_id', $this->annee_id)
                    ->where('classable_type', 'like', '%Section')
                    ->where('classable_id', $fsection->id)
                    ->orderBy('nom')
                    ->get();
                $this->frais = $this->frais->merge($frais3f);
            }
        }

        $coption = Option::find($cclasse->filierable_id);

        if ($coption) {
            $frais3 = Frais::
            where('annee_id', $this->annee_id)
                ->where('classable_type', 'like', '%Option')
                ->where('classable_id', $coption->id)
                ->orderBy('nom')
                ->get();
            $this->frais = $this->frais->merge($frais3);

            $osection = Section::find($coption->section_id);

            if ($osection) {
                $frais3o = Frais::
                where('annee_id', $this->annee_id)
                    ->where('classable_type', 'like', '%Section')
                    ->where('classable_id', $osection->id)
                    ->orderBy('nom')
                    ->get();
                $this->frais = $this->frais->merge($frais3o);
            }
        }

        $csection = Section::find($cclasse->filierable_id);
        if ($csection) {
            $frais4 = Frais::
            where('annee_id', $this->annee_id)
                ->where('classable_type', 'like', '%Section')
                ->where('classable_id', $csection->id)
                ->orderBy('nom')
                ->get();
            $this->frais = $this->frais->merge($frais4);
        }
    }

    public function render()
    {
        $this->reloadData();
        return view('livewire.finance.perceptions.edit',
            ['perception' => $this->perception, 'annee' => $this->annee, 'inscription' => $this->inscription, 'inscriptions' => $this->inscriptions, 'frais' => $this->frais])
            ->layout(AdminLayout::class, ['title' => 'Modifier Perception']);
    }

    private function reloadData()
    {
        $this->inscriptions = Inscription::where('annee_id', Annee::id())->get();

        /*if ($this->perception->inscription_id) {
            $this->inscription = Inscription::find($this->inscription_id);
            $this->eleveNom = $this->inscription?->eleve?->fullName;
            $this->classe_id = $this->inscription?->classe->id;
        }*/

        $this->chooseSuitableFrais();
    }

    public function feeSelected()
    {
        $this->fee = Frais::find($this->perception->frais_id);
        $this->perception->montant = $this->fee->montant ?? null;
        $this->raisons = $this->fee != null ? $this->fee->frequence->children() : [];
    }

    public function editAndPrintPerception()
    {

        $this->editPerception();
    }

    public function editPerception()
    {

        try {
            $done = $this->doTheEdit();


            if ($done) {
                // $this->alert('success', "Facture modifiée avec succès !");
                $this->flash('success', "Facture modifiée avec succès !", [], route('finance.perceptions'));

            } else {
                $this->alert('warning', "Echec de modification de facture !");
            }
        } catch (Exception $exception) {
            // dd($exception);
            $this->alert('error', "Echec de modification de facture pour la fréquence déjà existante !");
        }
    }

    private function doTheEdit()
    {
        // dd($this->fee_id);
        // dd($this->perception);
        $this->validate([
            'perception.inscription_id' => ['required', Rule::unique('perceptions', 'inscription_id')->ignore($this->perception, 'inscription_id'),],
            'perception.frais_id' => ['required', Rule::unique('perceptions', 'frais_id')->ignore($this->perception, 'frais_id')],
            'perception.user_id' => 'required',
            'perception.due_date' => 'required',
            'perception.paid' => 'nullable',
            'perception.paid_by' => 'nullable',
            'perception.custom_property' => Rule::unique((new Perception())->getTable(), "custom_property")->ignore($this->perception, 'custom_property'),
            // 'custom_property' => ['required', Rule::unique('perceptions', 'custom_property')->ignore($this->perception->id),],
        ]);
        // dd($this->perception);
        return $this->perception->update(
            [
                'frais_id' => $this->perception->frais_id,
                'inscription_id' => $this->perception->inscription_id,
                'frequence' => $this->fee->frequence->name,
                'custom_property' => $this->perception->custom_property,
                'montant' => $this->perception->montant,
                'due_date' => $this->perception->due_date,
                'paid' => $this->perception->paid,
                // 'paid' => ($this->fee->type == FraisType::inscription and $this->paid == null) ? $this->montant : $this->paid,
                'paid_by' => $this->perception->paid_by,
            ]
        );

    }

    public function printIt()
    {
        /*  try {
              $this->doTheEdit();
          } catch (Exception $ex) {
              $this->error($ex->getMessage(), "Echec de modification de facture pour la fréquence déjà existante !");
          }
          $this->dispatchBrowserEvent('closeModal', ['modal' => 'recu-modal']);
          $this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => 301]);
      */
    }

    private function loadInscriptionFrais()
    {
        $this->frais = Frais::where(['annee_id' => $this->annee_id, 'type' => FraisType::inscription])->orderBy('nom')->get();
    }
}
