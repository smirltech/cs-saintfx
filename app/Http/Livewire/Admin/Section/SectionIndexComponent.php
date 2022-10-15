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

    protected $listeners = ['onSaved', 'onUpdated', 'onDeleted'];

    public function onSaved(){
        $this->loadData();
    }

    public function onUpdated(){
        $this->loadData();
    }

    public function onDeleted(){
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
            'nom'=>$this->nom,
            'code'=>$this->code,
        ]);
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

    public function deleteSection($id)
    {
        $section = Section::find($id);
        if (count($section->options) == 0) {
            if ($section->delete()) {
                $this->loadData();
                $this->alert('success', "Section supprimée avec succès !");
            }
        } else {
            $this->alert('warning', "Section n'a pas été supprimée, il y a des options attachées !");
        }
    }
}
