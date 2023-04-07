<?php

namespace App\Http\Livewire\Finance\Depenses;

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

    public function mount(): void
    {
        $this->types = DepenseType::all();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.depenses.depense-create-component');
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
        ];
    }
}
