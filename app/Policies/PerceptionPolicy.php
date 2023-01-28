<?php

namespace App\Policies;

use App\Models\Perception;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PerceptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('perceptions.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les perceptions.');
    }

    public function view(User $user, Perception $perception): Response|bool
    {
        return $user->can('perceptions.view.' . $perception->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette perception.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('perceptions.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une perception.');
    }

    public function update(User $user, Perception $perception): Response|bool
    {
        return $user->can('perceptions.update.' . $perception->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette perception.');
    }

    public function delete(User $user, Perception $perception): Response|bool
    {
        return $user->can('perceptions.delete.' . $perception->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette perception.');
    }

    public function restore(User $user, Perception $perception): Response|bool
    {
        return $user->can('perceptions.restore.' . $perception->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à restaurer cette perception.');
    }

    public function forceDelete(User $user, Perception $perception): Response|bool
    {
        return $user->can('perceptions.force_delete.' . $perception->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer définitivement cette perception.');
    }
}
