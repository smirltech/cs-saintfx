<?php

namespace App\Http\Livewire\Admin\Cours;

use App\Models\Cours;
use App\Traits\ClasseCode;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CoursCreateComponent extends Component
{
    use LivewireAlert;
    use ClasseCode;

    public ?Cours $cours;


    protected $rules = [
        'cours.nom' => 'required|unique:cours,nom',
        'cours.description' => 'required'

    ];

    protected $messages = [
        'cours.nom.required' => 'Le nom est obligatoire',
        'cours.nom.unique' => 'Le nom existe déjà',
        'cours.description.required' => 'La description est requise',
    ];

    public function submit()
    {
        $this->validate();

        $this->cours->save();

        $this->flash('success', 'Cours ajoutée avec succès', [], route('admin.cours.index'));
    }


    public function mount()
    {
        $this->cours = new Cours();
    }


    public function render()
    {

        return view('livewire.admin.cours.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout de classe']);
    }


}
