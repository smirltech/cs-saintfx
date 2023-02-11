<?php

namespace App\Http\Livewire\Finance\Frais;


use App\Enums\FraisFrequence;
use App\Enums\FraisType;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Filiere;
use App\Models\Frais;
use App\Models\Option;
use App\Models\Section;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FraisIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $sections = [];
    public $options = [];
    public $filieres = [];
    public $classes = [];

    public $section_id;
    public $option_id;
    public $filiere_id;
    public $classe_id;


    public $frais = [];
    public $fee; // fee c'est le français de frais.
    // Étant donné que frais s'écrit de la même façon au singulier et au pluriel, j'utilise frais pour le pluriel et fee pour le singulier

    public $nom;
    public $description;
    public $montant;
    public $annee_id;
    public $frequence = FraisFrequence::mensuel;
    public $type = FraisType::frais_divers;
    public $classable_id;
    public $classable_type;

    protected $messages = [
        'montant.required' => 'Le montant est obligatoire !',
        'nom.required' => 'Le nom est obligatoire !',
        'annee_id.required' => 'L\'année est obligatoire !',
    ];

    //protected $listeners = ['onModalClosed'];

    public function mount()
    {
        $this->authorize('viewAny', Frais::class);
        $this->annee_id = Annee::id();
        $this->sections = Section::orderBy('nom')->get();
        // dd($this->sections);
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.finance.frais.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Frais']);
    }

    public function loadData()
    {
        $this->loadAvailableClasses();
        //Todo: we will need to specify the année scolaire;
        $this->frais = Frais::where('annee_id', $this->annee_id)->orderBy('nom', 'ASC')->get();
    }

    private function loadAvailableClasses()
    {
        if ($this->filiere_id > 0) {
            $filiere = Filiere::find($this->filiere_id);
            $this->classes = $filiere->classes ?? [];
        } else if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $this->classes = $option->classes ?? [];
        } else if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->classes = $section->classes ?? [];
        } else {
            $this->classes = [];
        }

        $this->sections = Section::orderBy('nom')->get();
        $this->options = ($this->section_id > 0) ? Option::where('section_id', $this->section_id)->get() : [];
        $this->filieres = ($this->option_id > 0) ? Option::find($this->option_id)->filieres ?? [] : [];
    }

    public function addFrais()
    {
        // dd($this->nom);

        $this->validate([
            'nom' => 'required',
            'montant' => 'required',
            'classable_id' => 'required',
            'classable_type' => 'required',
        ]);

        Frais::create([
            'nom' => $this->nom,
            'description' => $this->description,
            'montant' => $this->montant,
            'frequence' => $this->frequence,
            'type' => $this->type,
            'annee_id' => $this->annee_id,
            'classable_id' => $this->classable_id,
            'classable_type' => $this->classable_type,
        ]);
        $this->onModalClosed('add-frais-modal');
        $this->alert('success', "Frais ajouté avec succès !");
       // $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-frais-modal']);
    }

    public function onModalClosed($p_id)
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $p_id]);
        //$this->clearValidation();
        $this->reset(['nom', 'description', 'montant',
            'classable_type', 'classable_id',
            'section_id', 'option_id', 'filiere_id', 'classe_id'
        ]);
    }

    public function getSelectedFrais(Frais $fee)
    {
        $this->fee = $fee;
        $this->nom = $fee->nom;
        $this->description = $fee->description;
        $this->montant = $fee->montant;
        $this->frequence = $fee->frequence->value;
        $this->type = $fee->type->value;
        $this->classable_type = $fee->classable_type;
        $this->classable_id = $fee->classable_id;

        $this->classe_id = null;
        $this->filiere_id = null;
        $this->option_id = null;
        $this->section_id = null;

        if (str_ends_with($this->classable_type, 'Classe')) {
            $this->classe_id = $this->classable_id;
            $this->manipulateFilierableClasse();
        } else if (str_ends_with($this->classable_type, 'Filiere')) {
            $this->filiere_id = $this->classable_id;
            $this->manipulateFilierableFiliere();
        } else if (str_ends_with($this->classable_type, 'Option')) {
            $this->option_id = $this->classable_id;
            $this->manipulateFilierableOption();
        } else if (str_ends_with($this->classable_type, 'Section')) {
            $this->section_id = $this->classable_id;
        }
    }

    private function manipulateFilierableClasse()
    {
        $classe = $this->classe_id != null ? Classe::find($this->classe_id) : null;
        if ($classe) {
            if (str_ends_with($classe->filierableType, 'Filiere')) {
                $this->filiere_id = $classe->filierable->id;
                $this->manipulateFilierableFiliere();
            } else if (str_ends_with($classe->filierableType, 'Option')) {
                $this->option_id = $classe->filierable->id;
                $this->manipulateFilierableOption();
            } else if (str_ends_with($classe->filierableType, 'Section')) {
                $this->section_id = $classe->filierable->id;
            }
        }
    }

    private function manipulateFilierableFiliere(): void
    {
        $filiere = $this->filiere_id != null ? Filiere::find($this->filiere_id) : null;
        $this->option_id = $filiere->option_id ?? null;
        $this->manipulateFilierableOption();
    }

    private function manipulateFilierableOption(): void
    {
        $option = $this->option_id != null ? Option::find($this->option_id) : null;
        $this->section_id = $option->section_id ?? null;
    }

    public function updateFrais(): void
    {
        $this->validate([
            'nom' => 'required',
            'montant' => 'required',
            'classable_id' => 'required',
            'classable_type' => 'required',
        ]);

        $done = $this->fee->update([
            'nom' => $this->nom,
            'description' => $this->description,
            'montant' => $this->montant,
            'frequence' => $this->frequence,
            'type' => $this->type,
            'classable_id' => $this->classable_id,
            'classable_type' => $this->classable_type,
        ]);
        if ($done) {
            $this->onModalClosed('edit-frais-modal');
            $this->alert('success', "Frais modifié avec succès !");
        } else {
            $this->alert('warning', "Echec de modification de frais !");
        }


    }


    // =================================================

    public function deleteFrais()
    {

        if (count($this->fee->perceptions) == 0) {
            if ($this->fee->delete()) {
                $this->onModalClosed('delete-frais-modal');
                $this->loadData();
                $this->alert('success', "Frais supprimé avec succès !");
            }
        } else {
            $this->alert('warning', "Frais n'a pas été supprimé, il y a des perceptions attachées !");
        }

    }

    public function changeSection()
    {
        $this->options = [];
        $this->filieres = [];
        if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->options = $section->options ?? [];
        }
        $this->classable_id = $this->section_id;
        $this->classable_type = Section::class;
        $this->option_id = null;
        $this->filiere_id = null;
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }

    public function changeOption()
    {
        $this->filieres = [];
        if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $this->filieres = $option->filieres ?? [];
        }
        $this->classable_id = $this->option_id;
        $this->classable_type = Option::class;
        $this->filiere_id = null;
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }

    public function changeFiliere()
    {
        $this->classable_id = $this->filiere_id;
        $this->classable_type = Filiere::class;
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }

    public function onClasseSelected()
    {
        $this->classable_id = $this->classe_id;
        $this->classable_type = Classe::class;
        $this->loadAvailableClasses();
    }

}
