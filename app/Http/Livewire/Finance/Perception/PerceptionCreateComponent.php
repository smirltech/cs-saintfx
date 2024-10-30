<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\FraisType;
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
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use URL;

class PerceptionCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public $searchCode;

    public $annee_id;
    public $user_id;
    public $fee_id;
    public ?Frais $fee = null;
    public $montant;
    public $paid;
    public $paid_by;
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
    public Perception $perception;

    public function mount(Inscription $inscription): void
    {
        $this->authorize('create', Perception::class);

        $this->perception = new Perception();
        $this->inscription = $inscription;
        $this->frais = Frais::orderBy('nom')->get();

    }


    //updatedFeeId
    public function updatedPerceptionFraisId($value): void
    {
        $this->fee = Frais::find($value);
        $this->feeSelected($value);
    }

    public function feeSelected($value): void
    {
        $this->fee = Frais::find($value);
        $this->perception->frais_montant = $this->fee->montant ?? null;
        $this->perception->devise = $this->fee->devise ?? null;

    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.perceptions.create',
            ['inscriptions' => $this->inscriptions, 'frais' => $this->frais])
            ->layout(AdminLayout::class, ['title' => 'Nouvelle Perception']);

    }

    public function submit(): void
    {
        $this->validate();
        $this->perception->inscription_id = $this->inscription->id;
        $this->perception->save();

        $this->flashSuccess("Frais imputé avec succès !", route('finance.perceptions.print', $this->perception->id));

    }


    public function rules(): array
    {
        return [
            'perception.frais_id' => 'required',
            'perception.montant' => 'required|numeric',
            'perception.frais_montant' => 'required|numeric',
            'perception.devise' => 'required',
            'perception.paid_by' => 'nullable',
            'perception.taux' => 'required_if:perception.devise,CDF',
            //if frais, frais type is minerval
            'perception.custom_property' => Rule::requiredIf(function () {
                return $this->perception->frais->type == FraisType::MINERVAL;
            }),
        ];
    }

}
