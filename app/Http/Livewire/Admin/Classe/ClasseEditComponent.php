<?php

namespace App\Http\Livewire\Admin\Classe;


use App\Models\Filiere;
use App\Models\Promotion;
use App\Traits\PomotionCode;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClasseEditComponent extends Component
{
    use LivewireAlert;
    use PomotionCode;

    public $filieres = [];
    public Promotion $promotion;
    public $grade;
    public $code;
    public $filiere_id;

    protected $messages = [
        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    public function mount()
    {
        $this->loadFilieresData();
        $this->grade = $this->promotion->grade;
        $this->code = $this->promotion->code;
        $this->filiere_id = $this->promotion->filiere_id;
    }

    public function loadFilieresData()
    {
        $this->filieres = Filiere::orderBy('nom', 'ASC')->get();
    }

    public function submit()
    {
        $this->validate();
        $this->promotion->update([
            'grade' => $this->grade,
            'code' => $this->code,
            'filiere_id' => $this->filiere_id,
        ]);
        $this->flash('success', 'Promotion modifiée avec succès', [], route('admin.promotions'));

    }

    public function render()
    {
        return view('livewire.admin.promotion-academique.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification de la promotion']);
    }

    protected function rules()
    {
        return [
            'grade' => 'required',
            'code' => 'required|unique:promotions,code,' . $this->promotion->id,
            'filiere_id' => 'required',
        ];
    }
}
