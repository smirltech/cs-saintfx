<?php

namespace App\Http\Livewire\Admin\Cours;


use App\Models\Cours;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CoursEditComponent extends Component
{
    use LivewireAlert;

    public ?Cours $cours;


    protected $messages = [
        'cours.nom.required' => 'Le nom est obligatoire',
        'cours.nom.unique' => 'Le nom existe déjà',
        'cours.description.required' => 'La description est requise',
    ];

    public function submit()
    {
        $this->validate();

        $this->cours->save();

        $this->alert('success', 'Cours modifiée avec succès');
    }


    public function mount(Cours $cours)
    {
        $this->cours = $cours;
    }


    public function render()
    {
        return view('livewire.admin.cours.edit')
            ->layout(AdminLayout::class, ['title' => 'Ajout de classe']);
    }


    protected function rules(): array
    {
        return [
            'cours.nom' => 'required|unique:cours,nom,' . $this->cours->id,
            'cours.description' => 'required'
        ];
    }
}
