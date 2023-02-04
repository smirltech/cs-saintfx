<?php

namespace App\Policies;

use App\Models\Filiere;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FilierePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user):Response|bool
    {
        return $user->can('filieres.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les filières.');
    }

    public function view(User $user, Filiere $filiere):Response|bool
    {
        return $user->can('filieres.view.' . $filiere->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette filière.');
    }

    public function create(User $user):Response|bool
    {
        return $user->can('filieres.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une filière.');
    }

    public function update(User $user, Filiere $filiere):Response|bool
    {
        return $user->can('filieres.update.' . $filiere->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette filière.');
    }

    public function delete(User $user, Filiere $filiere):Response|bool
    {
        return $user->can('filieres.delete.' . $filiere->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette filière.');
    }
}
