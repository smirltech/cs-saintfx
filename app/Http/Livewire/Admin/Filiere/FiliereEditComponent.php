<?php

namespace App\Http\Livewire\Admin\Filiere;

use App\Models\Filiere;
use App\Models\Option;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FiliereEditComponent extends Component
{
    use LivewireAlert;
    public $options = [];
    public $sections = [];

    public $section_id;

    public $filiere;
    protected $messages = [
        'filiere.nom.required' => 'Ce nom est obligatoire !',
        'filiere.nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'filiere.code.required' => 'Ce code est obligatoire !',
        'filiere.code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'filiere.option_id.required' => 'L\'option est obligatoire !',
    ];

    public function mount(Filiere $filiere)
    {
        $this->filiere = $filiere;

            $this->section_id = $this->filiere->option->section_id;
            $this->options = Option::orderBy('nom')->get();
            $this->sections = Section::orderBy('nom')->get();


    }


    public function submit()
    {
        $this->validate();
        $this->filiere->save();

        $this->flash('success', 'Filière modifiée avec succès', [], route('admin.filieres'));

    }

    public function render()
    {
        return view('livewire.admin.filieres.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification de la filière']);
    }

    protected function rules()
    {
        return [
            'filiere.nom' => [
                "required",
                Rule::unique((new Filiere)->getTable(), "nom")->ignore($this->filiere->id)

            ],
            'filiere.code' => [
                "required",
                Rule::unique((new Filiere)->getTable(), "code")->ignore($this->filiere->id)

            ],
            'filiere.description' => 'nullable|string',
            'filiere.option_id' => 'required',

        ];
    }

    public function changeSection()
    {
        if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->options = $section->options;
            if (count($this->options) > 0) {
                $option = $this->options[0];
                $this->filiere->option_id = $option->id;

            } else {
                $this->filiere->option_id = null;
                $this->options = [];
            }
        } else {
            $this->filiere->option_id = null;
            $this->options = [];
        }
    }

}
