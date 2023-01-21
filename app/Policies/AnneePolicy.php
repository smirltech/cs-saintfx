<?php

namespace App\Policies;

use App\Models\Annee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AnneePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('annees.view')
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à voir les années.');
    }

    public function view(User $user, Annee $annee): Response
    {
        return $user->can('annees.view.' . $annee->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à voir cette année.');
    }

    public function create(User $user): void
    {
        
    }

    public function update(User $user, Annee $annee)
    {
        //
    }

    public function delete(User $user, Annee $annee)
    {
        //
    }

    public function restore(User $user, Annee $annee)
    {
        //
    }

    public function forceDelete(User $user, Annee $annee)
    {
        //
    }
}
