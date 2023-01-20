<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->can('users.view_any')
            ? Response::allow()
            : Response::deny('You do not have permission to view users.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function view(User $user, User $model): Response|bool
    {
        return $user->can('users.view.' . $model->id)
            ? Response::allow()
            : Response::deny('You do not have permission to view this user.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('users.create');

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function update(User $user, User $model)
    {
        return $user->can('users.update.' . $model->id)
            ? Response::allow()
            : Response::deny('You do not have permission to update this user.');

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function delete(User $user, User $model): Response|bool
    {
        return $user->can('users.delete.' . $model->id)
            ? Response::allow()
            : Response::deny('You do not have permission to delete this user.');

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $model
     * @return void
     */
    public function restore(User $user, User $model): void
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $model
     * @return void
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
