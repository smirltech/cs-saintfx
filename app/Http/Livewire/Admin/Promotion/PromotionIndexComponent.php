<?php

namespace App\Http\Livewire\Admin\Promotion;

use App\Models\Promotion;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PromotionIndexComponent extends Component
{
    use LivewireAlert;

    public $promotions = [];

    public function render()
    {
        $this->loadData();
        return view('livewire.admin.promotion-academique.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Promotions']);
    }


    public function loadData()
    {
        $this->promotions = Promotion::orderBy('code')->get();
    }

    public function deletePromotion($id)
    {

        $fa = Promotion::find($id);
        if ($fa->delete()) {
            $this->loadData();
            $this->alert('success', 'Promotion supprimée avec succès');

        }
    }
}
