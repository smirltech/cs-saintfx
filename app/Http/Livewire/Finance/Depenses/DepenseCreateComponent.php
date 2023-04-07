<?php

namespace App\Http\Livewire\Finance\Depenses;

use App\Models\Depense;
use App\Models\DepenseType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_DepenseType_C;
use Livewire\Component;

class DepenseCreateComponent extends Component
{

    /**
     * @var DepenseType[]|Collection|_IH_DepenseType_C
     */
    public _IH_DepenseType_C|array|Collection $types;
    public Depense $depense;

    public function mount(Depense $depense): void
    {
        $this->depense = $depense;
        $this->types = DepenseType::all();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.depenses.depense-create-component')->layoutData([
            'title' => 'Nouvelle dépense',
            'icon' => 'money-bill-wave',
            'breadcrumbs' => [
                ['url' => route('finance.depenses'), 'label' => 'Dépenses'],
                ['url' => route('finance.depenses.create'), 'label' => 'Nouvelle dépense'],
            ],
        ]);
    }

    // submit
    public function submit(): void
    {
        $this->validate();
    }

    protected function rules(): array
    {
        return [
            'depense.type_id' => 'required',
            'depense.montant' => 'required',
            'depense.reference' => 'nullable',
            'depense.date' => 'nullable|date',
        ];
    }
}
