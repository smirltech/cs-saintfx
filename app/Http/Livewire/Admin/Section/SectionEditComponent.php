<?php

namespace App\Http\Livewire\Admin\Section;

use App\Models\Section;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;


class SectionEditComponent extends ModalComponent
{
    use LivewireAlert;

    public $section;
    protected $messages = [
        'section.nom.required' => 'Ce nom est obligatoire !',
        'section.nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'section.code.required' => 'Ce code est obligatoire !',
        'section.code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function mount(Section $section)
    {
        $this->section = $section;
    }

    public function submit()
    {
        $this->validate();
        $done = $this->section->save();
        if ($done) {
            $this->flash('success', 'Section modifiée avec succès', [], route('admin.sections'));
        } else {
            $this->alert('warning', "Echec de modofication de section !");
        }

    }

    public function render()
    {
        return view('livewire.admin.sections.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification de section']);
    }

    protected function rules()
    {
        return [
            'section.nom' => [
                "required",
                Rule::unique((new Section)->getTable(), "nom")->ignore($this->section->id)

            ],
            'section.code' => [
                "required",
                Rule::unique((new Section)->getTable(), "code")->ignore($this->section->id)

            ],

        ];
    }
}
