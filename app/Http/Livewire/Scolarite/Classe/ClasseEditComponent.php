<?php

namespace App\Http\Livewire\Scolarite\Classe;


use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseEnseignant;
use App\Models\Filiere;
use App\Models\Option;
use App\Models\Section;
use App\Traits\CanHandleClasseCode;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClasseEditComponent extends Component
{
    use LivewireAlert;
    use CanHandleClasseCode;

    public $options = [];
    public $sections = [];
    public $filieres = [];

    public $classe;
    public $grade;
    public $code;

    public $filiere_id;
    public $option_id;
    public $section_id;
    public $enseignant_id;

    protected $messages = [
        'grade.required' => 'Cette grade est obligatoire !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'section_id.required' => 'La section est obligatoire !',
    ];

    public function mount(Classe $classe)
    {
        $this->classe = $classe;
        $this->enseignant_id = $this->classe->enseignant_id;
        $this->grade = $this->classe->grade->value;
        $this->code = $this->classe->code;
        $this->loadFilieresData();
        $classable = $classe->filierable;
        if ($classable instanceof Filiere) {
            $this->filiere_id = $this->classe->filierable_id;
            $fily = Filiere::find($this->filiere_id);
            $this->option_id = $fily->option_id;
            $this->section_id = $fily->option->section_id;
            $this->options = Option::where("section_id", $this->section_id)->orderBy('nom')->get();
            $this->filieres = Filiere::where("option_id", $this->option_id)->orderBy('nom')->get();
        } else if ($classable instanceof Option) {
            $this->option_id = $this->classe->filierable_id;
            $opy = Option::find($this->option_id);
            $this->section_id = $opy->section_id;
            $this->options = Option::where("section_id", $this->section_id)->orderBy('nom')->get();
            $this->filieres = Filiere::where("option_id", $this->option_id)->orderBy('nom')->get();
        } else if ($classable instanceof Section) {
            $this->section_id = $this->classe->filierable_id;
        }
    }

    public function loadFilieresData()
    {
        $this->sections = Section::orderBy('nom')->get();
    }

    public function submit()
    {
        $this->validate();


        $this->classe->grade = $this->grade;
        $this->classe->code = $this->code;

        if ($this->filiere_id > 0) {
            $filiere = Filiere::find($this->filiere_id);
            $filiere->classes()->save($this->classe);
        } else if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $option->classes()->save($this->classe);
        } else if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $section->classes()->save($this->classe);
        }
        if ($this->enseignant_id) {
            ClasseEnseignant::updateOrCreate(
                [
                    'classe_id' => $this->classe->id,
                    'annee_id' => Annee::id(),
                ],
                [
                    'classe_id' => $this->classe->id,
                    'enseignant_id' => $this->enseignant_id,
                    'annee_id' => Annee::id(),

                ]
            );
        }


        $this->alert('success', 'Classe modifiée avec succès');

    }

    public function render()
    {
        return view('livewire.admin.classes.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification de la classe']);
    }

    public function changeSection()
    {
        if ($this->section_id > 0) {
            $section = Section::find($this->section_id);

            $this->options = $section->options;
            if (count($this->options) > 0) {
                $option = $this->options[0];
                //   $this->option_id = $option->id;
                $this->option_id = null;
                $this->filiere_id = null;

            } else {
                $this->option_id = null;
                $this->options = [];

                $this->filiere_id = null;
                $this->filieres = [];
            }
        } else {
            $this->option_id = null;
            $this->options = [];

            $this->filiere_id = null;
            $this->filieres = [];
        }
        $this->setCode();
    }

    public function changeOption()
    {
        if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            //$this->setCode();
            $this->filieres = $option->filieres;
            if (count($this->filieres) > 0) {
                $this->filiere_id = null;

            } else {
                $this->filiere_id = null;
                $this->filieres = [];
            }
        } else {
            $this->filiere_id = null;
            $this->filieres = [];
        }
        $this->setCode();
    }

    protected function rules()
    {
        return [
            'grade' => "required",
            'code' => [
                "required",
                //  Rule::unique((new Classe())->getTable(), "code")->ignore($this->classe->id)
            ],
            'section_id' => 'required',
            'enseignant_id' => 'nullable',
        ];
    }

}
