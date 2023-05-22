<?php

namespace App\Http\Livewire\Finance\Frais;

use App\Http\Livewire\BaseComponent;
use App\Models\Eleve;
use App\Models\Frais;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\NoReturn;

class FraisCreateComponent extends BaseComponent
{
    public Frais $frais;
    public Collection $eleves;

    public function mount(Frais $frais): void
    {
        $this->frais = $frais;
        $this->eleves = Eleve::all();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.frais.frais-create-component');
    }


    #[NoReturn] public function submit(): void
    {

        $this->validate();
        
        $this->frais->save();

        $this->emit('fraisAdded'); // Close model to using to jquery
        $this->emit('hideModal'); // Close model to using to jquery
        $this->alert('success', "Frais enregistré avec succès !");
    }

    public function rules(): array
    {
        return [
            'frais.nom' => 'required',
            'frais.montant' => 'required',
            'frais.description' => 'nullable',
        ];
    }
}
