<?php

namespace App\Http\Livewire\Admin\Promotion;

use App\Enum\AdmissionStatus;
use App\Models\Promotion;
use App\View\Components\AdminLayout;
use Livewire\Component;

class PromotionShowComponent extends Component
{
    public $promotion;
    public $admissions;

    public $pendingCount = 0;
    public $approvedCount = 0;
    public $rejectedCount = 0;
    public $canceledCount = 0;


    public function mount(Promotion $promotion)
    {
        $this->promotion = $promotion;
        $this->admissions = $this->promotion->admissions;
    }


    public function render()
    {
        $this->pendingCount = 0;
        $this->approvedCount = 0;
        $this->rejectedCount = 0;
        $this->canceledCount = 0;
        foreach ($this->admissions as $admission) {
            if ($admission->status == AdmissionStatus::pending) $this->pendingCount++;
            if ($admission->status == AdmissionStatus::approved) $this->approvedCount++;
            if ($admission->status == AdmissionStatus::rejected) $this->rejectedCount++;
            if ($admission->status == AdmissionStatus::canceled) $this->canceledCount++;
        }
        return view('livewire.admin.promotion-academique.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la promotion']);
    }
}
