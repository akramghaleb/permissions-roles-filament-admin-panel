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
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'read: role')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }


    public function create(User $user)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'create: role')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    public function update(User $user, Role $role)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'update: role')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);

    }

    public function delete(User $user, Role $role)
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'delete: role')->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

}
