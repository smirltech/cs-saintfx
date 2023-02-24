<?php

namespace App\Policies;

use App\Models\OuvrageCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OuvrageCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('rayons.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les catégories d\'ouvrages.');
    }

    public function view(User $user, OuvrageCategory $category): Response
    {
        return $user->can('rayons.view.' . $category->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette catégorie d\'ouvrages.');
    }

    public function create(User $user): Response
    {
        return $user->can('rayons.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une catégorie d\'ouvrages.');
    }

    public function update(User $user, OuvrageCategory $category): Response
    {
        return $user->can('rayons.update.' . $category->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette catégorie d\'ouvrages.');
    }

    public function delete(User $user, OuvrageCategory $category)
    {
        return $user->can('rayons.delete.' . $category->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette catégorie d\'ouvrages.');
    }
}
