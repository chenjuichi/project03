<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User as myUser;

class CustomerRolesController extends Controller
{
    //
    public function show($id, $roleId=null)
    {
        //
        $user = new myUser();
        //$current_user = $user->where('id',intval($id))->first();
        $current_user = $user->where('id',$id)->first();
        //$current_user_and_roles = $current_user->with('roles')->get();
        $current_user_and_roles = $current_user->with('roles')->first();
		return response()->json(["userAndUserRoles" => $current_user_and_roles]);

        //return 'User id' . strval($id) . 'User role' . strval($roleId);
    }
}
