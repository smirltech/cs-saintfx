<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\FraisType;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Option;
use App\Models\Perception;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use URL;

class PerceptionClasseCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public $annee_id;
    public $user_id;
    public $raisons = [];
    public $fee_id;
    public $fee;
    public $montant;
    public $custom_property;
    public $eleveNbr = 0;
    public $classes = [];
    public $classe_id;
    public $due_date;
    protected $rules = [
        'classe_id' => 'required',
        'fee_id' => 'required',
        'custom_property' => 'required',
        'due_date' => 'required',
        'montant' => 'required',
    ];
    private Classe|null $classe;
    private $frais = [];
    private $inscriptions = [];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize('create', Perception::class);
        $this->user_id = Auth::id();
        $this->annee_id = Annee::id();
        $this->due_date = Carbon::now()->format('Y-m-d');
        $this->frais = Frais::where('annee_id', $this->annee_id)->get();
        $this->loadClasses();

    }

    private function loadClasses(): void
    {
        $this->classes = Classe::all();
    }

    //updatedFeeId
    public function updatedFeeId($value): void
    {
        $this->feeSelected();
    }

    public function feeSelected(): void
    {
        $this->fee = Frais::find($this->fee_id);
        $this->montant = $this->fee->montant ?? null;
        $this->raisons = $this->fee != null ? $this->fee->frequence->children() : [];

    }

    public function render(): Factory|View|Application
    {
        $this->reloadData();
        return view('livewire.finance.perceptions.classe_create',
            ['inscriptions' => $this->inscriptions, 'frais' => $this->frais])
            ->layout(AdminLayout::class, ['title' => 'Nouvelle Perception']);
    }

    // uptadedClasseId

    private function reloadData(): void
    {
        $this->loadClasses();
        $this->chooseSuitableFrais();
    }

    private function chooseSuitableFrais(): void
    {
        if ($this->classe_id != null) {
            $this->classe = Classe::find($this->classe_id);
            $this->frais = Frais::
            where('annee_id', $this->annee_id)
                ->whereNot('type', FraisType::inscription)
                ->where('classable_type', 'like', '%Classe')
                ->where('classable_id', $this->classe_id)
                ->orderBy('nom')
                ->get();

            if (str_ends_with($this->classe->filierable_type, 'Filiere')) {
                $filiere_id = $this->classe->filierable->id;
                $frais2 = Frais::
                where('annee_id', $this->annee_id)
                    ->whereNot('type', FraisType::inscription)
                    ->where('classable_type', 'like', '%Filiere')
                    ->where('classable_id', $filiere_id)
                    ->orderBy('nom')
                    ->get();

                $this->frais = $this->frais->merge($frais2);

                $filiere2 = Filiere::find($filiere_id);
                if ($filiere2) {
                    $option_id = $filiere2->option_id;
                    $frais3 = Frais::
                    where('annee_id', $this->annee_id)
                        ->whereNot('type', FraisType::inscription)
                        ->where('classable_type', 'like', '%Option')
                        ->where('classable_id', $option_id)
                        ->orderBy('nom')
                        ->get();

                    $this->frais = $this->frais->merge($frais3);

                    $option2 = Option::find($option_id);
                    if ($option2) {
                        $section_id = $option2->section_id;

                        $frais4 = Frais::
                        where('annee_id', $this->annee_id)
                            ->whereNot('type', FraisType::inscription)
                            ->where('classable_type', 'like', '%Section')
                            ->where('classable_id', $section_id)
                            ->orderBy('nom')
                            ->get();

                        $this->frais = $this->frais->merge($frais4);
                    }
                }
            }

            if (str_ends_with($this->classe->filierable_type, 'Option')) {
                $option_id = $this->classe->filierable->id;
                $frais2 = Frais::
                where('annee_id', $this->annee_id)
                    ->whereNot('type', FraisType::inscription)
                    ->where('classable_type', 'like', '%Option')
                    ->where('classable_id', $option_id)
                    ->orderBy('nom')
                    ->get();

                $this->frais = $this->frais->merge($frais2);

                $option2 = Option::find($option_id);
                if ($option2) {
                    $section_id = $option2->section_id;

                    $frais4 = Frais::
                    where('annee_id', $this->annee_id)
                        ->whereNot('type', FraisType::inscription)
                        ->where('classable_type', 'like', '%Section')
                        ->where('classable_id', $section_id)
                        ->orderBy('nom')
                        ->get();

                    $this->frais = $this->frais->merge($frais4);
                }
            }

            if (str_ends_with($this->classe->filierable_type, 'Section')) {
                $section_id = $this->classe->filierable->id;
                //   dd($section_id);
                $frais2 = Frais::
                where('annee_id', $this->annee_id)
                    ->whereNot('type', FraisType::inscription)
                    ->where('classable_type', 'like', '%Section')
                    ->where('classable_id', $section_id)
                    ->orderBy('nom')
                    ->get();

                $this->frais = $this->frais->merge($frais2);
            }
        }
    }

    public function updatedClasseId(): void
    {
        $this->changeClasse();
    }

    public function changeClasse(): void
    {
        $this->classe = Classe::find($this->classe_id);
        if ($this->classe) {
            $this->inscriptions = Inscription::where(['classe_id' => $this->classe_id, 'annee_id' => $this->annee_id])->get();
            $this->eleveNbr = $this->inscriptions->count();
        } else {
            $this->inscriptions = [];
            $this->eleveNbr = 0;
        }
        $this->fee_id = null;
        $this->fee = null;
        $this->montant = null;
        $this->custom_property = null;
        $this->raisons = [];
    }

    public function addPerceptionsAndClose(): void
    {
        $this->addPerceptions();
        $this->flash('success', "Classe facturée avec succès !", [], route('finance.perceptions'));

    }

    public function addPerceptions(): void
    {
        $this->validate();

        $this->inscriptions = Inscription::where(['classe_id' => $this->classe_id, 'annee_id' => $this->annee_id])->get();
        $this->inscriptions->each(fn($inscription) => $this->addPerceptionForInscription($inscription));

        $this->flashSuccess("Classe facturée avec succès !", URL::previous());
    }

    private function addPerceptionForInscription(Inscription $inscription): void
    {
        try {
            Perception::updateOrCreate(
                [
                    'frais_id' => $this->fee_id,
                    'inscription_id' => $inscription->id,
                    'custom_property' => $this->custom_property,
                    'annee_id' => $this->annee_id,
                ], [
                    'frequence' => $this->fee->frequence->name,
                    'user_id' => $this->user_id,
                    'montant' => $this->montant,
                    'due_date' => $this->due_date,
                ]
            );
        } catch (Exception $exception) {
            $this->error(local: $exception->getMessage());
        }
    }

}
