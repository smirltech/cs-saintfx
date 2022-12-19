<?php

namespace App\Http\Livewire\Admin\craps\Classe;

use App\Enums\InscriptionStatus;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Option;
use App\Models\Promotion;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Livewire\Component;

class ClasseShowComponent extends Component
{
    public $classe;
    public $parent = "";
    public $parent_url = "";
    public $inscriptions = [];

    /* public $admissions;

     public $pendingCount = 0;
     public $approvedCount = 0;
     public $rejectedCount = 0;
     public $canceledCount = 0;*/


    public function mount(Classe $classe)
    {
        $this->classe = $classe;
        $this->inscriptions = $this->classe->inscriptions;
        // $this->admissions = $this->promotion->admissions;

        $classable = $classe->filierable;
        if ($classable instanceof Filiere) {
            $this->parent_url = "/admin/filieres/$classe->filierable_id";
            $this->parent = "Filière";
        } else if ($classable instanceof Option) {
            $this->parent_url = "/admin/options/$classe->filierable_id";
            $this->parent = "Option";
        } else if ($classable instanceof Section) {
            $this->parent_url = "/admin/sections/$classe->filierable_id";
            $this->parent = "Section";
        }
    }


    public function render()
    {
        /*  $this->pendingCount = 0;
          $this->approvedCount = 0;
          $this->rejectedCount = 0;
          $this->canceledCount = 0;
          foreach ($this->admissions as $admission) {
              if ($admission->status == InscriptionStatus::pending) $this->pendingCount++;
              if ($admission->status == InscriptionStatus::approved) $this->approvedCount++;
              if ($admission->status == InscriptionStatus::rejected) $this->rejectedCount++;
              if ($admission->status == InscriptionStatus::canceled) $this->canceledCount++;
          }*/
        return view('livewire.admin.classes.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la classe']);
    }
}
