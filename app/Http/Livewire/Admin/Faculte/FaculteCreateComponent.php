<?php

namespace App\Http\Livewire\Admin\Faculte;

use App\Helpers\Helpers;
use App\Models\Faculte;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FaculteCreateComponent extends Component
{
    use LivewireAlert;

    public $nom;
    public $description;
    public $code;
    public $email;
    public $phone;
    public $latlng;
    public $doyen;


    protected $rules = [
        'nom' => 'required|unique:facultes',
        'code' => 'required|unique:facultes',
        'email' => 'nullable',
    ];

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function submit()
    {
        $this->validate();
        Faculte::create([
            'nom' => $this->nom,
            'description' => $this->description,
            'code' => $this->code,
            'email' => $this->email,
            'phone' => $this->phone,
            'latlng' => $this->latlng,
            'doyen' => $this->doyen,
        ]);

        $this->flash('success', 'Faculté ajoutée avec succès',[],route('admin.facultes'));

    }

    public function render()
    {
        return view('livewire.admin.faculte-academique.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout de faculté']);
    }
}
