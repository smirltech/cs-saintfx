<?php

namespace App\Http\Livewire\Admin\Faculte;

use App\Helpers\Helpers;
use App\Models\Faculte;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FaculteEditComponent extends Component
{
    use LivewireAlert;
    public $faculte;


    public function mount(Faculte $faculte)
    {
        $this->faculte = $faculte;
    }


    protected function rules () {
        return [
        'faculte.nom' => [
            "required",
            Rule::unique((new Faculte)->getTable(), "nom")->ignore($this->faculte->id)

        ] ,
        'faculte.code' => [
            "required",
            Rule::unique((new Faculte)->getTable(), "code")->ignore($this->faculte->id)

        ],
        'faculte.description' => 'nullable|string',
        'faculte.email' => 'nullable',
        'faculte.phone' => 'nullable|string',
        'faculte.latlng' => 'nullable|string',
        'faculte.doyen' => 'nullable|string',
        ];}

    protected $messages = [
        'faculte.nom.required' => 'Ce nom est obligatoire !',
        'faculte.nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'faculte.code.required' => 'Ce code est obligatoire !',
        'faculte.code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function submit()
    {
        $this->validate();
       $done = $this->faculte->save();
     if($done) {
         $this->flash('success', 'Faculté modifiée avec succès', [], route('admin.facultes'));
     }else{
         $this->alert('warning', "Echec de modofication de faculté !");
     }

    }

    public function render()
    {
        return view('livewire.admin.faculte-academique.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification de faculté']);
    }
}
