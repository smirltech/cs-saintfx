<?php

namespace App\Http\Livewire\Finance\Depenses;

use App\Enums\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Models\Depense;
use App\Models\DepenseType;
use App\Notifications\DepenseCreated;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class DepenseCreateComponent extends BaseComponent
{
    public array|Collection $types;
    public Depense $depense;

    public function mount(Depense $depense): void
    {
        $this->depense = $depense;
        $this->types = DepenseType::all();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.depenses.depense-create-component')->layoutData([
            'title' => $this->depense->exists ? 'Modifier une dépense' : 'Ajouter une dépense',
            'icon' => 'money-bill-wave',
            'breadcrumbs' => [
                ['url' => route('finance.depenses.index'), 'label' => 'Dépenses'],
            ],
        ]);
    }

    // submit
    public function submit(): void
    {
        $this->validate();
        $this->depense->save();


        // notify all admins amd promoteurs
        $this->depense->notifyAll(
            notification: new DepenseCreated($this->depense),
            roles: [UserRole::admin->value, UserRole::promoteur->value]
        );

        $this->flashSuccess('Dépense enregistrée avec succès', route('finance.depenses.index'));
    }

    protected function rules(): array
    {
        return [
            'depense.depense_type_id' => 'required',
            'depense.montant' => 'required',
            'depense.reference' => 'nullable',
            'depense.date' => 'nullable|date',
            'depense.note' => 'nullable|string',
        ];
    }
}
