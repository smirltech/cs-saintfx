<?php

namespace App\Http\Livewire\Admin\Enseignant;

use App\Models\Annee;
use App\Models\Enseignant;
use App\Traits\EleveUniqueCode;
use App\Traits\FakeProfileImage;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EnseignantShowComponent extends Component
{
    use LivewireAlert;
    use FakeProfileImage;
    use EleveUniqueCode;


    public Enseignant $enseignant;
    public Collection $cours;
    public Collection $classes;
    public Annee $annee_courante;

    protected $listeners = ['onModalClosed', 'refreshComponent' => '$refresh'];


    public function mount(Enseignant $enseignant)
    {
        $this->enseignant = $enseignant;
        $this->cours = $enseignant->cours;
        $this->classes = $enseignant->classes;
        $this->annee_courante = Annee::encours();
    }

    public function render(): Factory|View|Application
    {

        $data = ['title' => 'Modification d\'un enseignant'];
        return view('livewire.admin.enseingnants.show', $data)
            ->layout(AdminLayout::class, $data);
    }


}
