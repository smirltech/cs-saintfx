<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SectionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('sections.view')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les sections.');
    }

    public function view(User $user, Section $section): Response|bool
    {
        return $user->can('sections.view.' . $section->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette section.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('sections.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une section.');
    }

    public function update(User $user, Section $section): Response|bool
    {
        return $user->can('sections.update.' . $section->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette section.');
    }

    public function delete(User $user, Section $section): Response|bool
    {
        return $user->can('sections.delete.' . $section->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette section.');
    }

    public function restore(User $user, Section $section): Response|bool
    {
        return $user->can('sections.restore.' . $section->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à restaurer cette section.');
    }

    public function forceDelete(User $user, Section $section): Response|bool
    {
        return $user->can('sections.force_delete.' . $section->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer définitivement cette section.');
    }
}
