<?php

namespace App\Http\Livewire\Admin\Option;

use App\Models\Option;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Livewire\Component;

class OptionShowComponent extends Component
{
    public $option;


    public function mount(Option $option)
    {
        $this->option = $option;
    }

    public function render()
    {
        return view('livewire.admin.options.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur l\'option']);
    }
}
