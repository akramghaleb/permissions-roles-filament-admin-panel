<?php

namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'moderator' , 'developer']);
    }


    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    public function update(User $user, Role $role)
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

    public function delete(User $user, Role $role)
    {
        return $user->hasAnyRole(['super-admin', 'admin']);
    }

}
