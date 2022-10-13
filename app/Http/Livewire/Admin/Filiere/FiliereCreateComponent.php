<?php

namespace App\Http\Livewire\Admin\Filiere;

use App\Models\Faculte;
use App\Models\Filiere;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FiliereCreateComponent extends Component
{
    use LivewireAlert;
    public $facultes = [];

    public $nom;
    public $description;
    public $code;
    public $faculte_id;



    protected $rules = [
        'nom' => 'required|unique:filieres',
        'code' => 'required|unique:filieres',
        'description' => 'required',
        'faculte_id' => 'required',

    ];

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'description.required' => 'Cette description est obligatoire !',

        'faculte_id.required' => 'La faculté est obligatoire !',
    ];

    public function submit()
    {
        $this->validate();
        Filiere::create([
            'nom'=>$this->nom,
            'description'=>$this->description,
            'code'=>$this->code,
            'faculte_id'=>$this->faculte_id,

        ]);
       // return redirect()->to(route('admin.filieres'));
        $this->flash('success', 'Filière ajoutée avec succès',[],route('admin.filieres'));

    }

    public function loadFacultesData()
    {
        $this->facultes = Faculte::/* orderBy('encours', 'DESC')-> */orderBy('nom', 'ASC')->get();
    }

    public function render()
    {
        $this->loadFacultesData();
        return view('livewire.admin.filiere-academique.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout de filière']);
    }
}
