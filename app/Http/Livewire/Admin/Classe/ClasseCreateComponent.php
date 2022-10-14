<?php

namespace App\Http\Livewire\Admin\Classe;

use App\Models\Filiere;
use App\Models\Promotion;
use App\Traits\PomotionCode;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClasseCreateComponent extends Component
{
    use LivewireAlert;
    use PomotionCode;

    public $filieres = [];

    public $grade;
    public $code;
    public $filiere_id;


    protected $rules = [
        'grade' => 'required',
        'code' => 'required|unique:promotions',
        'filiere_id' => 'required',

    ];

    protected $messages = [
        'grade.required' => 'Cette grade est obligatoire !',
        'grade.unique' => 'Cette grade est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'filiere_id.required' => 'La filière est obligatoire !',
    ];

    public function submit()
    {
        $this->validate();
        Promotion::create([
            'grade' => $this->grade,
            'code' => $this->code,
            'filiere_id' => $this->filiere_id,

        ]);

        $this->flash('success', 'Promotion ajoutée avec succès', [], route('admin.promotions'));
        //return redirect()->to(route('admin.promotions'));
    }


    public function mount()
    {
        $this->loadFilieresData();
    }

    public function loadFilieresData()
    {
        $this->filieres = Filiere::orderBy('nom')->get();
    }

    public function render()
    {

        return view('livewire.admin.promotion-academique.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout de promotion']);
    }


}
