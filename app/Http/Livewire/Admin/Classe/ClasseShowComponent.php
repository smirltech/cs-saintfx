<?php

namespace App\Http\Livewire\Admin\Classe;

use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Option;
use App\Models\Promotion;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ClasseShowComponent extends Component
{
    public Classe $classe;
    public ?string $parent = "";
    public ?string $parent_url = "";
    public ?Collection $inscriptions;
    public Collection $cours;
    public Collection $enseignants;


    public function mount(Classe $classe)
    {
        $this->classe = $classe;
        $this->cours = $classe->cours;
        $this->enseignants = $classe->enseignants;
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
        return view('livewire.admin.classes.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la classe']);
    }

    // ajouter un cours
    public function addCours()
    {
        $this->emit('addCours', $this->classe);
    }
}
