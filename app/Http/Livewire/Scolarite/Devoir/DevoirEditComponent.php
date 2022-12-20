<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Exceptions\ApplicationAlert;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Devoir;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class DevoirEditComponent extends Component
{
    use ApplicationAlert;

    public Devoir $devoir;
    public Collection $cours;
    public Collection $classes;

    protected $messages = [
        'cours.nom.required' => 'Le nom est obligatoire',
        'cours.nom.unique' => 'Le nom existe déjà',
        'cours.description.required' => 'La description est requise',
        'cours.section_id.required' => 'La section est requise'
    ];

    public function submit()
    {
        $this->validate();

        $this->devoir->save();

        $this->alert('success', 'Cours modifiée avec succès');
    }


    public function mount(Devoir $devoir)
    {
        $this->devoir = $devoir;
        $this->cours = Cours::all();
        $this->classes = Classe::all();
    }


    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.devoirs.edit');
    }


    protected function rules(): array
    {
        return [
            'cours.nom' => ['required', Rule::unique('cours')->where(fn($query) => $query->where('section_id', $this->devoir->section_id)
                ->where('nom', $this->devoir->nom))
                ->ignore($this->devoir->id)],
            'cours.description' => 'required',
            'cours.section_id' => 'required'
        ];
    }
}
