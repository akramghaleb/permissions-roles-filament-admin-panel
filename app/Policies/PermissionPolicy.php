<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'moderator']);
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'moderator']);
    }

    public function update(User $user, Permission $permission)
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'moderator']);
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->hasAllRoles(['super-admin', 'admin', 'moderator']);
    }


}
