<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User as myUser;
use App\Role;

class CustomerUsersController extends Controller
{
    /**
     * Add, 2020-10-22
     * @param Request $request
     * 
     * @return array
     */
    public function rolesList(Request $request)
    {
        $user = new myUser();
        $id = Auth::user()->id;
        $userWithRoles = $user->with('roles')->where('id', $id)->first();

        return response()->json(
            [
                "userAndUserRoles" => $userWithRoles,
            ]
        );
    }

    public function attatchedRole(Request $request)
    {
        $users = new myUser();
        $currentUser = $users->where('id', $request->userId)->first();
        $currentRole = Role::where('id', $request->roleId)->first();

        //echo $currentUser->name;
        //echo "\r\n";
        //echo $currentRole->name;

        //$currentUser->roles()->attach($request->role);
        //$currentUser->roles()->toggle([$request->roleId]);
        $currentUser->roles()->sync([$request->roleId]);

        return response()->json(
            [
                "message" => $currentUser->name . " has attatched the " . $currentRole->name . " role, ok!"
            ]
        );
    }
}
