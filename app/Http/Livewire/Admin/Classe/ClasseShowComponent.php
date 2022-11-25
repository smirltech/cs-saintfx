<?php

namespace App\Http\Livewire\Admin\Classe;

use App\Models\Classe;
use App\Models\ClasseEnseignant;
use App\Models\CoursEnseignant;
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
    public ?CoursEnseignant $cours_enseignant;
    public ?ClasseEnseignant $classe_enseignant;
    public Collection $enseignants;


    public function mount(Classe $classe)
    {

        $this->cours_enseignant = new CoursEnseignant();
        $this->classe_enseignant = new ClasseEnseignant();

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
        $this->validate([
            'cours_enseignant.cours_id' => 'required|exists:cours,id',
            'cours_enseignant.enseignant_id' => 'required|exists:enseignants,id',
        ]);

        $this->cours_enseignant->classe_id = $this->classe->id;
        $this->cours_enseignant->save();

        $this->cours = $this->classe->cours;
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-cours-modal']);
    }

    // function rules
    public function rules()
    {
        return [
            'cours_enseignant.cours_id' => 'required|exists:cours,id',
            'cours_enseignant.enseignant_id' => 'required|exists:enseignants,id',
            'classe_enseignant.enseignant_id' => 'required|exists:enseignants,id',
        ];
    }
}
