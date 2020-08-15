<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Staff;

class AdminController extends Controller
{
    public function index(){
        $users = User::with('roles')->get();
      
        return view('admin.home', ['users' => $users]);
    }

    public function assignRole(Request $request){
        //Get the User
        $userId = $request->userId; 
        $user = User::where('id', $userId)->firstOrFail();

        //Check if Role is valid
        $requestedRole = $request->role;
        if ($requestedRole == 'none') {
            //Remove User Roles
            $user->roles()->detach();
        }
        elseif ($requestedRole != 'admin') {
            /**
             * Change the Role
             * 
            */
            $role = Role::where('name', $requestedRole)->firstOrFail();
            $hasRole = $user->roles()->where('userId', $userId);
            if ($hasRole != '') {
                //Update the User Role
                $user->roles()->detach();
                $user->roles()->attach($role->id);
            }else{
                //Create a User Role
                $user->roles()->attach($role->id);
            }
            
            //Add Entry in Staff Details Table
            if ($requestedRole == 'staff') {
                Staff::create([
                    'user_id' => $userId,
                ]);
            }

        }

        return redirect('/admin');

    }

}
