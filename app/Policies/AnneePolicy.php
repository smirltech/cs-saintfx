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

    public function create(User $user): Response
    {
       return  $user->can('annees.create')
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à créer une année.');
    }

    public function update(User $user, Annee $annee):Response
    {
        return $user->can('annees.update.' . $annee->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à modifier cette année.');
    }

    public function delete(User $user, Annee $annee)
    {
        return $user->can('annees.delete.' . $annee->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à supprimer cette année.');
    }

    public function restore(User $user, Annee $annee)
    {
        return $user->can('annees.restore.' . $annee->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à restaurer cette année.');
    }

    public function forceDelete(User $user, Annee $annee)
    {
        return $user->can('annees.forceDelete.' . $annee->id)
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à supprimer définitivement cette année.');
    }
}
