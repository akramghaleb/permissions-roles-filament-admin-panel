<?php

namespace App\Policies;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'viewAny: Role')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'view: Role')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'create: Role')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'update: Role')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'delete: Role')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'restore: Role')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        $permission = \Spatie\Permission\Models\Permission::where('name' , 'like', 'forceDelete: Role')
            ->get()[0]->roles()->get();
        $permission_list = array();
        foreach ($permission as $i=>$d){
            $permission_list[]= $d->name;
        }
        return $user->hasAnyRole($permission_list);
    }
}
