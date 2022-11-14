<?php

namespace App\Http\Livewire\Admin\Cours;


use App\Models\Cours;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CoursEditComponent extends Component
{
    use LivewireAlert;

    public $cours;

    public function mount(Cours $cours)
    {

        $this->cours = $cours;
    }


    public function submit()
    {
        $this->validate();

        $this->flash('success', 'Classe modifiée avec succès', [], route('admin.classes'));

    }

    public function render()
    {
        return view('livewire.admin.cours.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification de la classe']);
    }


    protected function rules()
    {
        return [
            'cours.nom' => "required",
            'cours.code' => [
                "required",
                Rule::unique((new Cours())->getTable(), "code")->ignore($this->cours->id)
            ],
            'cours.description' => 'required',
        ];
    }

}
