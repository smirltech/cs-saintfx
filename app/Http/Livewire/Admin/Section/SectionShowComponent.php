<?php

namespace App\Http\Livewire\Admin\Section;

use App\Models\Option;
use App\Models\Section;
use App\Traits\SectionCode;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SectionShowComponent extends Component
{
    use LivewireAlert;
    use SectionCode;

    public $section;

    public $nom;
    public $code;

    public $option_nom;
    public $option_code;

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'option_nom.required' => 'Ce nom d\'option est obligatoire !',
        'option_nom.unique' => 'Ce nom d\'option est déjà pris, cherchez-en un autre !',

        'option_code.required' => 'Ce code d\'option est obligatoire !',
        'option_code.unique' => 'Ce code d\'option est déjà pris, cherchez-en un autre !',
    ];

    protected $listeners = ['onSaved', 'onUpdated', 'onDeleted', 'onModalOpened', 'onModalClosed'];

    public function onModalOpened()
    {
        $this->clearValidation();
    }

    public function onModalClosed()
    {
        $this->clearValidation();
        $this->reset(['nom', 'code']);
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

    public function loadData()
    {
        $this->section = Section::find($this->section->id);
        $this->nom = $this->section->nom;
        $this->code = $this->section->code;
    }

    public function mount(Section $section)
    {
        $this->section = $section;
        $this->nom = $section->nom;
        $this->code = $section->code;
    }

    public function render()
    {
        return view('livewire.admin.sections.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la section']);
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

            $this->reset(['nom', 'code']);

            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-section-modal']);
            //$this->flash('success', 'Section modifiée avec succès', [], route('admin.sections'));
        } else {
            $this->alert('warning', "Echec de modification de section !");
        }
        $this->onModalClosed();

    }


    // ---------------------------

    public function addOption()
    {
        // dd($this->nom);

        $this->validate([
            'option_nom' => [
                "required",
                Rule::unique((new Option)->getTable(), "nom")

            ],
            'option_code' => [
                "required",
                Rule::unique((new Option())->getTable(), "code")

            ],

        ]);

        Option::create([
            'nom' => $this->option_nom,
            'code' => $this->option_code,
            'section_id' => $this->section->id,
        ]);
        $this->emit('onSaved');
        $this->alert('success', "Option ajoutée avec succès !");

        $this->reset(['option_nom', 'option_code']);

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-option-modal']);
        $this->onModalClosed();
    }
}
