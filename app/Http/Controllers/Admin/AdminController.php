<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Staff;
use Response;
use Session;
class AdminController extends Controller
{   

    public function index(){
        $users = User::all();
        return view('admin.home', ['users' => $users]);
    }

    public function assignRole(Request $request){
        //Get the User
        $userId = $request->userId; 
        $user = User::where('id', $userId)->firstOrFail();

        //Check if Role is valid
        $requestedRole = $request->role;
        
        if ($requestedRole != 'admin') {
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

        return redirect()->back();
    }

    public function users(Request $request){
        if(!empty($request->value)){
            $users = User::where('name', 'like', '%'.$request->value.'%')->with('roles')->get();
        }else{
            $users = User::all();
        }

        $data = '
            <table class="ui table"><thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Action</th><th>View</th></tr></thead><tbody>
        ';
        foreach ($users as $user) {

                $data .= '
                    <tr>
                        <td>'. $user->name .'</td>
                        <td>'. $user->email .'</td>   
                        <td>'. $user->roles[0]->name .'</td>';
                if($user->roles[0]->name != 'admin'){
                    $data .= '
                        <td><form class="ui form" method="POST" action="'.route('admin.user.role').'">
                            <input type="hidden" name="_token" value="'.Session::token().'">
                            <input type="hidden" name="userId" value="'.$user->id.'"> 
                            <div class="fields">
                                <div class="eleven wide field">
                                    <div class="ui selection dropdown">
                                        <input type="hidden" name="role" value="'.$user->roles[0]->name.'">
                                        <i class="dropdown icon"></i>
                                        <div class="default text">Role</div>
                                        <div class="menu">
                                            <div class="item" data-value="staff">Staff</div>
                                            <div class="item" data-value="student">Student</div>
                                            <div class="item" data-value="guest">Guest</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="five wide field">
                                    <button class="ui red button" type="submit">Commit</button>
                                </div>
                            </div>
                        </form></td>';
                }
                            
            if(isset($user->profile)){
                $data .= '<td><a class="ui blue button" href="/search/'.$user->profile->staff_id.'"><i class="eye outline icon"></i> View</a></td>
                    </tr>
                ';
            }else{
                $data .= '<td></td></tr>';
            }
        }
        $data .= '
            </tbody></table><script>$(".ui.selection").dropdown();</script>
        ';
        return Response::json($data);
    }

}
