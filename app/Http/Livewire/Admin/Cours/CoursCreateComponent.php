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

    public Cours $cours;


    protected $rules = [
        'cours.nom' => 'required|unique:cours,nom',

    ];

    protected $messages = [
        'cours.nom.required' => 'Le nom est obligatoire',
        'cours.nom.unique' => 'Le nom existe déjà',
    ];

    public function submit()
    {
        $this->validate();

        $this->flash('success', 'Classe ajoutée avec succès', [], route('admin.classes'));
        //return redirect()->to(route('admin.promotions'));
    }


    public function mount()
    {

    }


    public function render()
    {

        return view('livewire.admin.cours.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout de classe']);
    }


}
