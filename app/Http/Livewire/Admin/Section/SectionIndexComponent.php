<?php

namespace App\Http\Livewire\Admin\Section;

use App\Models\Option;
use App\Models\Section;
use App\Traits\SectionCode;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SectionIndexComponent extends Component
{
    use LivewireAlert;
    use SectionCode;

    public $sections = [];
    public $section;
    public $nom;
    public $code;

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    protected $listeners = ['onSaved', 'onUpdated', 'onDeleted', 'onModalOpened', 'onModalClosed'];

    public function onModalOpened()
    {
        $this->clearValidation();
    }

    public function onModalClosed()
    {
        $this->clearValidation();
        $this->reset(['section', 'nom', 'code']);
    }

    public function onSaved()
    {
        $this->loadData();
    }

    public function onUpdated()
    {
        $this->loadData();
    }

    public function onDeleted()
    {
        $this->loadData();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.admin.sections.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Sections']);
    }

    public function loadData()
    {
        $this->sections = Section::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'ASC')->get();
    }

    public function addSection()
    {
        // dd($this->nom);

        $this->validate([
            'nom' => 'required|unique:sections',
            'code' => 'required|unique:sections',
        ]);

        Section::create([
            'nom' => $this->nom,
            'code' => $this->code,
        ]);
        $this->emit('onSaved');
        $this->alert('success', "Section ajoutée avec succès !");

        $this->reset(['nom', 'code']);

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-section-modal']);
        $this->onModalClosed();
    }

    public function getSelectedSection(Section $section)
    {
        // dd($section);
        $this->section = $section;
        $this->nom = $section->nom;
        $this->code = $section->code;
    }

    public function updateSection()
    {
        $this->validate([
            'nom' => [
                "required",
                Rule::unique((new Section)->getTable(), "nom")->ignore($this->section->id)

            ],
            'code' => [
                "required",
                Rule::unique((new Section)->getTable(), "code")->ignore($this->section->id)

            ],
        ]);

        $done = $this->section->update([
            'nom' => $this->nom,
            'code' => $this->code,
        ]);
        if ($done) {
            $this->emit('onUpdated');
            $this->alert('success', "Section modifiée avec succès !");

            $this->reset(['section', 'nom', 'code']);

            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-section-modal']);
            //$this->flash('success', 'Section modifiée avec succès', [], route('admin.sections'));
        } else {
            $this->alert('warning', "Echec de modification de section !");
        }
        $this->onModalClosed();

    }

    public function deleteSection()
    {
        if (count($this->section->options) == 0) {
            if ($this->section->delete()) {
                $this->loadData();
                $this->alert('success', "Section supprimée avec succès !");
                $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-section-modal']);
            }
        } else {
            $this->alert('warning', "Section n'a pas été supprimée, il y a des options attachées !");
        }
        $this->onModalClosed();

    }
}
