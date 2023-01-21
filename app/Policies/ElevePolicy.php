<?php

namespace App\Policies;

use App\Models\Eleve;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ElevePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->can('users.view')
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à voir les élèves.');
    }

    public function view(User $user, Eleve $eleve): Response
    {
        return $user->can('users.view.' . $eleve->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à voir cet élève.');
    }

    public function create(User $user): Response
    {
        return $user->can('users.create')
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à créer un élève.');
    }

    public function update(User $user, Eleve $eleve): Response
    {
        return $user->can('users.update.' . $eleve->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à modifier cet élève.');
    }

    public function delete(User $user, Eleve $eleve): Response
    {
        return $user->can('users.delete.' . $eleve->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à supprimer cet élève.');
    }

    public function restore(User $user, Eleve $eleve): Response
    {
        return $user->can('users.restore.' . $eleve->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à restaurer cet élève.');
    }

    public function forceDelete(User $user, Eleve $eleve): Response
    {
        return $user->can('users.forceDelete.' . $eleve->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à supprimer définitivement cet élève.');
    }
}
