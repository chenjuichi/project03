<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User as myUser;

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
}
