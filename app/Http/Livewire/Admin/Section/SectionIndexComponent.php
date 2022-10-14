<?php

namespace App\Http\Livewire\Admin\Section;

use App\Models\Option;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SectionIndexComponent extends Component
{
    use LivewireAlert;

    public $sections = [];

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

    public function deleteSection($id)
    {
        $section = Section::find($id);
        if (count($section->options) == 0) {
            if ($section->delete()) {
                $this->loadData();
                $this->alert('success', "Section supprimée avec succès !");
            }
        } else {
            $this->alert('warning', "Section n'a pas été supprimée, il y a des filières attachées !");
        }
    }
}
