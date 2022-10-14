<?php

namespace App\Http\Livewire\Admin\Option;

use App\Models\Option;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class OptionIndexComponent extends Component
{
    use LivewireAlert;

    public $options = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.admin.options.index')
            ->layout(AdminLayout::class, ['title' => 'Liste d\'options']);
    }

    public function loadData()
    {
        $this->options = Option::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'ASC')->get();
    }

    public function deleteOption($id)
    {
        $option = Option::find($id);
       // if (count($option->options) == 0) {
            if ($option->delete()) {
                $this->loadData();
                $this->alert('success', "Option supprimée avec succès !");
            }
//        } else {
//            $this->alert('warning', "Section n'a pas été supprimée, il y a des filières attachées !");
//        }
    }
}
