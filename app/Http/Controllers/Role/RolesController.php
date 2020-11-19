<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User as myUser;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $roleid)
    {
        //
        return 'User id' . strval($id) . 'User role' . strval($roleid);

        $user = new myUser();

        $current_user = $user->where('id', $id)->first();
        $permission = $current_user->hasPermission('manage-users');
        $user_roles  =$current_user->roles()->get();
        //return 'User role' . strval($id) . ' name  is ' . $current_user->name . ' permission ' . $current_user->roles()->first()->name;
        //參考1
        //$current_user->roles()->skip(1)->first(); //Second row
        //$current_user->roles()->skip(2)->first(); //Third row


        $items = array();
        foreach($user_roles as $userRole) {
            $items[] = $userRole->name;
        }
        return 'User id ' . strval($id) . ' and name  is ' . $current_user->name . ' role has ' . $items[1];
        //參考2 return array
        //return response()->json(["userRoles"=>$items], 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
