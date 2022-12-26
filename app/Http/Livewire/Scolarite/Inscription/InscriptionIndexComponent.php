<?php

namespace App\Http\Livewire\Scolarite\Inscription;

use App\Models\Annee;
use App\Models\Inscription;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class InscriptionIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;
    use WithPagination;

    public $annee_courante;

    public string $search = '';

    protected $queryString = ['search'];

    public function render()
    {
        $this->annee_courante = Annee::where('encours', true)->first();

        #TODO: move this to mount()
        $inscriptions = $this->loadData();


        return view('livewire.scolarite.inscriptions.index', [
            'inscriptions' => $inscriptions->get(),
        ])
            ->layout(AdminLayout::class, ['title' => "Liste d'inscriptions"]);
    }

    public function loadData()
    {
        $query = Inscription::query();
        $query->where('annee_id', $this->annee_courante->id)->orderBy('status', 'ASC');
        return $query;
    }

    public function deleteInscription($id)
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
