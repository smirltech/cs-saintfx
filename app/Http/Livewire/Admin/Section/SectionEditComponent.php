<?php

namespace App\Http\Livewire\Admin\Section;

use App\Models\Section;
use App\Traits\SectionCode;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LivewireUI\Modal\ModalComponent;


class SectionEditComponent extends ModalComponent
{
    use LivewireAlert;
    use SectionCode;

    public $section;

    protected $messages = [
        'section.nom.required' => 'Ce nom est obligatoire !',
       // 'section.nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'section.code.required' => 'Ce code est obligatoire !',
       // 'section.code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function mount($section_id)
    {
       // dd($section);
        $this->section = Section::find($section_id);

    }

    public function submit()
    {
        $this->validate();
        $done = $this->section->save();
        if ($done) {
            $this->emit('onUpdated');
            $this->alert('success', "Section modifiée avec succès !");

            $this->reset(['section']);

            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-section-modal']);
            //$this->flash('success', 'Section modifiée avec succès', [], route('admin.sections'));
        } else {
            $this->alert('warning', "Echec de modification de section !");
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
            'nom' => [
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
