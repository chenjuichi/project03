<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    //預載
    public function getAllRolesAndRolePermissions()
    {
        return $this->with('permissions')->get();
    }

    public function assignRoleWithPermission($role_slug , $permission_slug)
    {
        $permission = Permission::where('slug', $permission_slug)->first();
        $role = $this->where('slug', $role_slug)->first();

        $role->permissions()->attach($permission);
    }
}
