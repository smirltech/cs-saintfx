<?php

namespace App\Http\Livewire\Admin\Section;

use App\Models\Section;
use App\View\Components\AdminLayout;
use Livewire\Component;

class SectionShowComponent extends Component
{
    public $section;


    public function mount(Section $section)
    {
        $this->section = $section;
    }

    public function render()
    {
        return view('livewire.admin.sections.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la section']);
    }
}
