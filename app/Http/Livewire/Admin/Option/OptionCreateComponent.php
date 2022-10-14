<?php

namespace App\Http\Livewire\Admin\Option;

use App\Models\Option;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Illuminate\Support\Facades\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class OptionCreateComponent extends Component
{
    use LivewireAlert;

    public $nom;
    public $code;
    public $section_id;
    public $sections = [];

    public function mount()
    {
        if(request()->has('section_id')){
            $this->section_id = request()->section_id;
        }
     $this->sections = Section::orderBy('nom')->get();
    }

    protected $rules = [
        'nom' => 'required|unique:sections',
        'code' => 'required|unique:sections',
        'section_id' => 'required|numeric',
    ];

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function submit()
    {
        $this->validate();
        Option::create([
            'nom' => $this->nom,
            'code' => $this->code,
            'section_id' => $this->section_id,
        ]);

        $this->flash('success', 'Option ajoutée avec succès', [], route('admin.options'));

    }

    public function render()
    {
        return view('livewire.admin.options.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout d\'option']);
    }
}
