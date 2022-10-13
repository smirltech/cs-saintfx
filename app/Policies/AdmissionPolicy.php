<?php

namespace App\Policies;

use App\Models\Admission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdmissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Admission $admission)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Admission $admission)
    {
        //
    }

    public function delete(User $user, Admission $admission)
    {
        //
    }

    public function restore(User $user, Admission $admission)
    {
        //
    }

    public function forceDelete(User $user, Admission $admission)
    {
        //
    }
}
