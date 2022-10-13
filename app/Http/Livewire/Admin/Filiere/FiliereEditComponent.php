<?php

namespace App\Http\Livewire\Admin\Filiere;

use App\Models\Faculte;
use App\Models\Filiere;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FiliereEditComponent extends Component
{
    use LivewireAlert;
    public $facultes = [];
    public $filiere;


    public function mount(Filiere $filiere)
    {
        $this->filiere = $filiere;
        $this->loadFacultesData();
    }

    public function loadFacultesData()
    {
        $this->facultes = Faculte::/* orderBy('encours', 'DESC')-> */orderBy('nom', 'ASC')->get();
    }


    protected function rules () {
        return [
        'filiere.nom' => [
            "required",
            Rule::unique((new Filiere)->getTable(), "nom")->ignore($this->filiere->id)

        ] ,
        'filiere.code' => [
            "required",
            Rule::unique((new Filiere)->getTable(), "code")->ignore($this->filiere->id)

        ],
        'filiere.description' => 'nullable|string',
        'filiere.faculte_id' => 'required',

        ];}

    protected $messages = [
        'filiere.nom.required' => 'Ce nom est obligatoire !',
        'filiere.nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'filiere.code.required' => 'Ce code est obligatoire !',
        'filiere.code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function submit()
    {
        $this->validate();
        $this->filiere->save();
        //return redirect()->to(route('admin.filieres'));
        $this->flash('success', 'Filière modifiée avec succès',[],route('admin.filieres'));

    }

    public function render()
    {
        return view('livewire.admin.filiere-academique.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification de la filière']);
    }
}
