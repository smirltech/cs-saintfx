<?php

namespace App\Http\Livewire\Scolarite\Classe\Cours;

use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Option;
use App\Models\Section;
use App\Traits\CanHandleClasseCode;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Edit extends Component
{
    use LivewireAlert;
    use CanHandleClasseCode;

    public $options = [];
    public $sections = [];
    public $filieres = [];

    public $grade;
    public $code;
    public $filiere_id;
    public $option_id;
    public $section_id;


    protected $rules = [
        'grade' => 'required',
        'code' => 'required|unique:classes',
        'section_id' => 'required',

    ];

    protected $messages = [
        'grade.required' => 'Cette grade est obligatoire !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'section_id.required' => 'La section est obligatoire !',
    ];

    public function submit()
    {
        $this->validate();

        $classe = new Classe();
        $classe->grade = $this->grade;
        $classe->code = $this->code;

        if ($this->filiere_id > 0) {
            $filiere = Filiere::find($this->filiere_id);
            $filiere->classes()->save($classe);
        } else if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $option->classes()->save($classe);
        } else if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $section->classes()->save($classe);
        }

        $this->flash('success', 'Classe ajoutée avec succès', [], route('scolarite.classes'));
        //return redirect()->to(route('scolarite.promotions'));
    }


    public function mount()
    {
        $this->loadFilieresData();
    }

    public function loadFilieresData()
    {

        $this->sections = Section::orderBy('nom')->get();
        // $this->options = Option::orderBy('nom')->get();
        //  $this->filieres = Filiere::orderBy('nom')->get();
    }

    public function render()
    {

        return view('livewire.scolarite.classes.cours.edit');
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

}
