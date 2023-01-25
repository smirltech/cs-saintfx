<?php

namespace App\Policies;

use App\Models\Inscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class InscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user):Response|bool
    {
        return $user->can('inscriptions.view')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les insciptions.');
    }

    public function view(User $user, Inscription $inscription):Response|bool
    {
        return $user->can('inscriptions.view')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette inscription.');
    }

    public function create(User $user):Response|bool
    {
        return $user->can('inscriptions.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une inscription.');
    }

    public function update(User $user, Inscription $inscription):Response|bool
    {
        return $user->can('inscriptions.update')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette inscription.');
    }

    public function delete(User $user, Inscription $inscription):Response|bool
    {
        return $user->can('inscriptions.delete')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette inscription.');
    }

    public function restore(User $user, Inscription $inscription):Response|bool
    {
        return $user->can('inscriptions.restore')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à restaurer cette inscription.');
    }

    public function forceDelete(User $user, Inscription $inscription):Response|bool
    {
        return $user->can('inscriptions.force-delete')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer définitivement cette inscription.');
    }
}
