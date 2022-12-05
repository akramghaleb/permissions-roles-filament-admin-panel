<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'read: permission')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    public function create(User $user)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'create: permission')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    public function update(User $user, Permission $permission)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'update: permission')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    public function delete(User $user, Permission $permission)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'delete: permission')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }


}
