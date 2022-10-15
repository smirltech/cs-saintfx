<?php

namespace App\Http\Livewire\Admin\Option;

use App\Models\Option;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;


class OptionEditComponent extends ModalComponent
{
    use LivewireAlert;

    public $option;
    public $sections = [];

    protected $messages = [
        'option.nom.required' => 'Ce nom est obligatoire !',
        'option.nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'option.code.required' => 'Ce code est obligatoire !',
        'option.code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
        'option.section_id.required' => 'La section est obligatoire !',
    ];

    public function mount(Option $option)
    {
        $this->option = $option;
        $this->sections = Section::orderBy('nom')->get();
    }

    public function submit()
    {
        $this->validate();
        $done = $this->option->save();
        if ($done) {
            $this->flash('success', 'Option modifiée avec succès', [], route('admin.options'));
        } else {
            $this->alert('warning', "Echec de modification d'option !");
        }

    }

    public function render()
    {
        return view('livewire.admin.options.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification d\'option']);
    }

    protected function rules()
    {
        return [
            'option.nom' => [
                "required",
                Rule::unique((new Option)->getTable(), "nom")->ignore($this->option->id)
            ],
            'option.code' => [
                "required",
                Rule::unique((new Option)->getTable(), "code")->ignore($this->option->id)
            ],
            'option.section_id' => [
                "required",
            ],

        ];
    }
}
