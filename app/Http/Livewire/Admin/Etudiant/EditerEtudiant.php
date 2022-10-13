<?php

namespace App\Http\Livewire\Admin\Etudiant;

use App\Models\Etudiant;
use App\Models\Promotion;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditerEtudiant extends Component
{

    public $etudiant;
    protected $messages = [
        'promotion.grade.required' => 'Cette grade est obligatoire !',
        'promotion.grade.unique' => 'Cette grade est déjà prise, cherchez-en un autre !',

        'promotion.code.required' => 'Ce code est obligatoire !',
        'promotion.code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function mount(Promotion $etudiant)
    {
        $this->etudiant = $etudiant;

    }

    public function submit()
    {
        $this->validate();
        $this->etudiant->save();
        return redirect()->to(route('etudiant'));
    }

    public function render()
    {
        return view('livewire.etudiant-academique.editer-etudiant');
    }

    protected function rules()
    {
        return [
            'etudiant.grade' => [
                "required",
                Rule::unique((new Etudiant)->getTable(), "grade")->ignore($this->etudiant->id)

            ],
            'etudiant.code' => [
                "required",
                Rule::unique((new Etudiant)->getTable(), "code")->ignore($this->etudiant->id)

            ],

        ];
    }
}
