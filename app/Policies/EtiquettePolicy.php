<?php

namespace App\Policies;

use App\Models\Etiquette;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EtiquettePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('etiquettes.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les étiquettes.');
    }

    public function view(User $user, Etiquette $etiquette): Response
    {
        return $user->can('etiquettes.view.' . $etiquette->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette étiquette.');
    }

    public function create(User $user): Response
    {
       return  $user->can('etiquettes.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une étiquette.');
    }

    public function update(User $user, Etiquette $etiquette):Response
    {
        return $user->can('etiquettes.update.' . $etiquette->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette étiquette.');
    }

    public function delete(User $user, Etiquette $etiquette)
    {
        return $user->can('etiquettes.delete.' . $etiquette->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette étiquette.');
    }
}
