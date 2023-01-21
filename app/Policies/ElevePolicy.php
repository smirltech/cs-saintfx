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
        return $user->can('users.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à voir les élèves.');
    }

    public function view(User $user, Eleve $eleve)
    {
        return $user->can('users.view.' . $eleve->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à voir cet élève.');
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Eleve $eleve)
    {
        //
    }

    public function delete(User $user, Eleve $eleve)
    {
        //
    }

    public function restore(User $user, Eleve $eleve)
    {
        //
    }

    public function forceDelete(User $user, Eleve $eleve)
    {
        //
    }
}
