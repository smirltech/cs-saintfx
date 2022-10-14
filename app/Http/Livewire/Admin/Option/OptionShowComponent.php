<?php

namespace App\Http\Livewire\Admin\Option;

use App\Models\Section;
use App\View\Components\AdminLayout;
use Livewire\Component;

class OptionShowComponent extends Component
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
