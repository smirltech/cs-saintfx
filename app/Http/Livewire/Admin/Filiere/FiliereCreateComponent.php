<?php

namespace App\Http\Livewire\Admin\Filiere;

use App\Models\Filiere;
use App\Models\Option;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FiliereCreateComponent extends Component
{
    use LivewireAlert;

    public $options = [];
    public $sections = [];


    public $nom;
    public $description;
    public $code;
    public $option_id;
    public $section_id;

    public function mount()
    {
        if(request()->has('option_id')){
            $this->option_id = request()->option_id;
            $this->section_id = Option::find($this->option_id)->section_id;
            $this->options = Option::orderBy('nom')->get();
            $this->sections = Section::orderBy('nom')->get();
        }
        else {
            $this->options = [];
            $this->sections = Section::orderBy('nom')->get();
        }
    }

    protected $rules = [
        'nom' => 'required|unique:filieres',
        'code' => 'required|unique:filieres',
        'description' => 'nullable',
        'option_id' => 'required|numeric',

    ];

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'option_id.required' => 'L\'option est obligatoire !',
    ];

    public function submit()
    {
        $this->validate();
        Filiere::create([
            'nom' => $this->nom,
            'description' => $this->description,
            'code' => $this->code,
            'option_id' => $this->option_id,

        ]);
        // return redirect()->to(route('admin.filieres'));
        $this->flash('success', 'Filière ajoutée avec succès', [], route('admin.filieres'));

    }

    public function render()
    {
      //  $this->loadOptionsData();
        return view('livewire.admin.filieres.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout de filière']);
    }

   // public function loadOptionsData()
   // {
//        $this->options = Option::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'ASC')->get();
//    }

    public function changeSection()
    {
        if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->options = $section->options;
            if (count($this->options) > 0) {
                $option = $this->options[0];
                $this->option_id = $option->id;

            } else {
                $this->option_id = null;
                $this->options = [];
            }
        } else {
            $this->option_id = null;
            $this->options = [];
        }
    }

}
