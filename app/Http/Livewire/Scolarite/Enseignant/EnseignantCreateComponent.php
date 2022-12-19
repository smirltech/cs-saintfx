<?php

namespace App\Http\Livewire\Scolarite\Enseignant;

use App\Enums\Sexe;
use App\Models\Enseignant;
use App\Models\Section;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class EnseignantCreateComponent extends Component
{
    use LivewireAlert;

    public Enseignant $enseignant;
    public Collection $sections;
    protected $messages = [
        'enseignant.nom.required' => 'Le nom est obligatoire',
        'enseignant.nom.unique' => 'Le nom existe déjà',
        'enseignant.email.required' => 'L\'email est obligatoire',
        'enseignant.email.unique' => 'L\'email existe déjà',
        'enseignant.telephone.required' => 'Le téléphone est obligatoire',
        'enseignant.telephone.unique' => 'Le téléphone existe déjà',
        'enseignant.section_id.required' => 'La section est requise',
        'enseignant.lieu_naissance.required' => 'Le lieu de naissance est obligatoire',
        'enseignant.date_naissance.required' => 'La date de naissance est obligatoire',
    ];

    #[NoReturn] public function submit()
    {
        $this->validate();


        $this->enseignant->save();

        $this->flash('success', 'Enseignant ajoutée avec succès', [], route('scolarite.enseignants.index'));
    }

    public function mount()
    {
        $this->enseignant = new Enseignant();
        $this->sections = Section::all();

        if (app()->isLocal()) {
            $this->enseignant->date_naissance = Date::create(1999, 1, 1)->format('Y-m-d');
            $this->enseignant->lieu_naissance = 'Yaound';
            $this->enseignant->sexe = Sexe::f;
            $this->enseignant->section_id = $this->sections->first()->id;
        }
    }

    public function render()
    {

        $data = ['title' => 'Ajout d\'un enseignant'];
        return view('livewire.scolarite.enseingnants.create', $data)
            ->layout(AdminLayout::class, $data);
    }

    protected function rules(): array
    {
        return [
            'enseignant.nom' => 'required|unique:enseignants,nom',
            'enseignant.email' => 'required|unique:enseignants,email',
            'enseignant.telephone' => 'required|unique:enseignants,telephone',
            'enseignant.section_id' => 'required',
            'enseignant.sexe' => 'required',
            'enseignant.date_naissance' => 'required|date|before:today-18 years',
            'enseignant.lieu_naissance' => 'required',
            'enseignant.adresse' => 'required',
        ];
    }


}
