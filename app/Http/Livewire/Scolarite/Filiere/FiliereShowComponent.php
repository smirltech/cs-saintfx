<?php

namespace App\Http\Livewire\Scolarite\Filiere;

use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Option;
use App\Models\Section;
use App\Traits\FiliereCode;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FiliereShowComponent extends Component
{
    use LivewireAlert;
    use FiliereCode;

    public $options = [];
    public $sections = [];

    public $nom;
    public $description;
    public $code;
    public $option_id;
    public $section_id;

    public $filiere;

    public $classe_grade;
    public $classe_code;

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

    protected $listeners = ['onSaved', 'onUpdated', 'onDeleted', 'onModalOpened', 'onModalClosed'];

    public function onModalOpened()
    {
        $this->clearValidation();
    }

    public function onSaved()
    {
        $this->loadData();
    }

    public function loadData()
    {
        //  $this->filieres = Filiere::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'ASC')->get();
    }

    public function onUpdated()
    {
        $this->loadData();
    }

    public function onDeleted()
    {
        $this->loadData();
    }

    public function mount(Filiere $filiere)
    {
        $this->sections = Section::orderBy('nom')->get();

        $this->filiere = $filiere;
        $this->nom = $filiere->nom;
        $this->code = $filiere->code;
        $this->description = $filiere->description;
        $this->option_id = $filiere->option_id;
        $this->section_id = $filiere->option->section_id;
        $this->options = Option::where('section_id', $this->section_id)->orderBy('nom')->get();
    }

    public function render()
    {
        return view('livewire.admin.filieres.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la filière']);
    }

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

    public function updateFiliere()
    {
        $this->validate([
            'nom' => [
                "required",
                Rule::unique((new Filiere())->getTable(), "nom")->ignore($this->filiere->id)

            ],
            'code' => [
                "required",
                Rule::unique((new Filiere)->getTable(), "code")->ignore($this->filiere->id)

            ],
            'option_id' => 'required|numeric',
            'description' => 'nullable',
        ]);

        $done = $this->filiere->update([
            'nom' => $this->nom,
            'code' => $this->code,
            'description' => $this->description,
            'option_id' => $this->option_id,
        ]);
        if ($done) {
            $this->emit('onUpdated');
            $this->alert('success', "Filière modifiée avec succès !");

            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-filiere-modal']);
            //$this->flash('success', 'Section modifiée avec succès', [], route('admin.sections'));
        } else {
            $this->alert('warning', "Echec de modification de filière !");
        }
        $this->onModalClosed();

    }

    public function onModalClosed()
    {
        $this->clearValidation();
        $this->reset(['nom', 'code', 'section_id', 'option_id', 'options', 'description']);
    }

    public function addClasse()
    {
        $this->validate([
            'classe_grade' => "required",
            'classe_code' => [
                "required",
                Rule::unique((new Classe())->getTable(), "code")
            ],

        ]);

        $classe = new Classe();
        $classe->grade = $this->classe_grade;
        $classe->code = $this->classe_code;

        $this->filiere->classes()->save($classe);

        $this->emit('onSaved');
        $this->alert('success', "Classe ajoutée avec succès !");

        //$this->reset(['filiere_nom', 'filiere_code']);

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-classe-modal']);
        $this->onModalClosed();
    }

}
