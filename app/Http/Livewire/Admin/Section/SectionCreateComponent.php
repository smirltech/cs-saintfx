<?php

namespace App\Http\Livewire\Admin\Section;

use App\Models\Section;
use App\Traits\SectionCode;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class SectionCreateComponent extends Component
{
    use LivewireAlert;
    use SectionCode;

    public $nom;
    public $code;

    protected $rules = [
        'nom' => 'required|unique:sections',
        'code' => 'required|unique:sections',
    ];

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function submit()
    {
        // dd($this->nom);
        $this->validate();
        Section::create([
            'nom' => $this->nom,
            'code' => $this->code,
        ]);
        $this->emit('onSaved');
        $this->alert('success', "Section ajoutée avec succès !");

        $this->reset(['nom', 'code']);

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-section-modal']);
    }

    public function render()
    {
        return view('livewire.admin.sections.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout de Section']);
    }

}
