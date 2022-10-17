<?php

namespace App\Http\Livewire\Admin\Responsable;

use App\Models\Option;
use App\Models\Responsable;
use App\Models\Section;
use App\Traits\SectionCode;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ResponsableShowComponent extends Component
{
    use LivewireAlert;
    public $responsable;

    public function mount(Responsable $responsable)
    {
        $this->responsable = $responsable;
    }

    public function render()
    {
        return view('livewire.admin.responsables.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur le responsable']);
    }

}
