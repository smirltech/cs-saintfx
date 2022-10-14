<?php

namespace App\Http\Livewire\Admin\Admission;

use App\Models\Annee;
use App\Models\Inscription;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class AdmissionIndexComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $annee_courante;

    public string $search = '';

    protected $queryString = ['search'];

    public function render()
    {
        $this->annee_courante = Annee::where('encours', true)->first();

        #TODO: move this to mount()
        $admissions = $this->loadData();


        return view('livewire.admin.admission-academique.index', [
            'admissions' => $admissions->paginate(10),
        ])
            ->layout(AdminLayout::class, ['title' => "Liste d'admissions"]);
    }

    public function loadData()
    {
        $query = Inscription::query();

        if ($this->search) {
            $query->whereHas('etudiant', function ($q) {
                $q->where('nom', 'like', "%{$this->search}%")
                    ->orWhere('postnom', 'like', "%{$this->search}%")
                    ->orWhere('prenom', 'like', "%{$this->search}%");

            });
        }

        $query->orderBy('status', 'ASC');

        return $query;
    }

    public function deleteAdmission($id)
    {
        $this->alert('info', "Cette fonctionnalité n'est pas encore implémentée !");

        /*   $fa = Faculte::find($id);
           if (count($fa->filieres) == 0) {
               if ($fa->delete()) {
                   $this->loadData();
                   Helpers::swal($this, 'success', 'Fécilitation', "Faculté supprimée avec succès !");
               }
           } else {
               Helpers::swal($this, 'warning', 'Echec', "Faculté n'a pas été supprimée, il y a des filières attachées !");
           }*/
    }
}
