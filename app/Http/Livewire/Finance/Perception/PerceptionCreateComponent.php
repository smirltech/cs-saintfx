<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Perception;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use URL;

class PerceptionCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public $searchCode;

    public $annee_id;
    public $user_id;
    public $fee_id;
    public $fee;
    public $montant;
    public $paid;
    public $paid_by;
    public $inscription_id;
    public $eleveNom;
    public $classe_id;
    public $due_date;
    public $inscription;
    protected $rules = [
        'inscription_id' => 'nullable',
        'inscription.full_name' => 'nullable',
    ];
    private $frais = [];
    private $inscriptions = [];

    public function mount(): void
    {
        $this->authorize('create', Perception::class);
        $this->user_id = Auth::id();
        $this->annee_id = Annee::id();
        $this->due_date = Carbon::now()->format('Y-m-d');
        $this->inscription = new Inscription();
        $this->frais = Frais::where(['annee_id' => $this->annee_id])->orderBy('nom')->get();
        $this->inscriptions = Inscription::getCurrentInscriptions();

    }


    //updatedFeeId
    public function updatedFeeId($value): void
    {
        $this->feeSelected($value);
    }

    public function feeSelected($value): void
    {
        $this->fee = Frais::find($value);
        $this->montant = $this->fee->montant ?? null;

    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.perceptions.create',
            ['inscriptions' => $this->inscriptions, 'frais' => $this->frais])
            ->layout(AdminLayout::class, ['title' => 'Nouvelle Perception']);

    }

    public function addPerceptionAndClose(): void
    {
        $this->addPerception();
        $this->flashSuccess("Frais imputé avec succès !", URL::previous());

    }

    public function addPerception(): void
    {
        $this->validate([
            'fee_id' => 'required',
            'user_id' => 'required',
            'annee_id' => 'required',
            'due_date' => 'required',
            'paid' => 'nullable|numeric',
            'paid_by' => 'nullable',
        ]);

        try {
            Perception::updateOrCreate(
                [
                    'frais_id' => $this->fee_id,
                    'inscription_id' => $this->inscription_id,
                    'due_date' => $this->due_date,
                    'annee_id' => $this->annee_id,
                ], [
                    'user_id' => $this->user_id,
                    'frais_id' => $this->fee_id,
                    'inscription_id' => $this->inscription_id,
                    'annee_id' => $this->annee_id,
                    'montant' => $this->montant,
                    'due_date' => $this->due_date,
                    'paid' => $this->paid,
                    'paid_at' => $this->paid ? Carbon::now() : null,
                    'paid_by' => $this->paid_by,
                ]
            );

            $this->flash('success', "Frais imputé avec succès !", [], route('finance.perceptions'));

        } catch (Exception $exception) {
            $this->error(local: $exception->getMessage(), production: "Echec d'imputation de frais déjà existante !");
        }
    }

}
