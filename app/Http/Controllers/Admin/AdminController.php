<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Role;
use App\Staff;
use Response;
use Session;
class AdminController extends Controller
{   

    public function index(){
        $userId = Auth::id(); 
        $users = User::all();
        $avatar = User::select('avatar')->where('id', $userId)->first();
        return view('admin.home', ['users' => $users, 'avatar' => $avatar->avatar]);
    }

    public function assignRole(Request $request){
        //Get the User
        $userId = strval($request->data['userId']); 
        $user = User::where('id', $userId)->firstOrFail();

        //Check if Role is valid
        $requestedRole = $request->data['role'];
        $role = Role::where('name', $requestedRole)->firstOrFail();
        $requestedRole = $role->name;

        if ($requestedRole != 'admin') {
            /**
             * Change the Role
             * 
            */
            $hasRole = $user->roles()->where('user_id', $userId)->firstOrFail();
            $hasRole = $hasRole->name;
            // Same as current Role
            if($hasRole == $requestedRole){return null;}   
            if ($hasRole != '') {
                // Remove Staff Details Entry
                if($hasRole == 'staff' && $requestedRole != 'staff'){
                    Staff::where('user_id', $userId)->delete();
                }
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
                    'academic_qualification' => '[]',
                    'experience' => '[]',
                    'journal' => '[]',
                    'conference' => '[]',
                    'online_course' => '[]',
                    'book' => '[]',
                    'fdp' => '[]',
                    'workshop' => '[]',
                    'award' => '[]',
                ]);
            }

        }

        return null;

    }

    public function users(Request $request){
        if(!empty($request->value)){
            $users = User::where('name', 'like', '%'.$request->value.'%')->with('roles')->get();
        }else{
            $users = User::all();
        }

        $data = '
            <table class="ui table"><thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr></thead><tbody>
        ';
        foreach ($users as $user) {

                $data .= '
                    <tr>
                        <td>
                            <h4 class="ui image header">
                                <img src="'. asset('/storage/avatar/'.$user->avatar) .'" class="ui small circular image">
                                <div class="content">
                                    '. $user->name .'
                                    <div class="sub header">';

                                    if (isset($user->profile))
                                        $data .= '<i>'. $user->profile->designation .' ('. $user->profile->department.')</i>';
                                    
                $data .= '          </div>
                                </div>
                            </h4>
                        </td>
                        <td>'. $user->email .'</td>   
                        <td>'. $user->roles[0]->name .'</td>';
                if($user->roles[0]->name != 'admin'){
                    $data .= '
                        <td><div class="ui icon top left pointing dropdown icon_btn_inv button">
                            <i class="ellipsis vertical icon"></i>
                            <div class="menu">
                                <div class="header">Basic</div>';
                            
                    if(isset($user->profile->staff_id)){
                        $data .= '<a class="item" href="/search/'. $user->profile->staff_id.'"><i class="eye outline icon"></i>View</a>';
                    }
                    else{
                        $data .= '<div class="disabled item"><i class="eye outline icon"></i> View</div>';
                    }           
                    $data .= '<div class="item"><i class="trash alternate icon"></i>Delete</div>
                                <div class="ui divider"></div>
                                <div class="header">Previledge</div>
                                <div class="item">
                                    <i class="dropdown icon"></i>
                                    <i class="user shield icon"></i> Role
                                    <div class="menu user_role" id="'.$user->id.'">
                                        <div class="item" id="staff">
                                            Staff
                                        </div>
                                        <div class="item" id="student">
                                            Student
                                        </div>
                                        <div class="item" id="guest">
                                            Guest
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div></td>';
                }else{
                    $data .= '<td></td>';    
                }
            
        }
        $data .= '
            </tbody></table><script>$(".ui.selection").dropdown();$(".ui.dropdown").dropdown();
            function alert_modal(resolve, reject) {
                // Generate the modal
                var modal = \'<div class="ui alert modal"><div style="text-align: center; margin: 30px;"><h2>Are you sure?</h2></div><div class="content" style="padding-right: 30px; padding-left: 30px; padding-bottom: 50px;"><button class="ui blue right floated button" id="confirm_alert">Yes</button><button class="ui right floated button" id="cancel_alert">Cancel</button></div></div>\';
                $(\'#alert_modal\').html(modal);
                $(\'.ui.alert.modal\').modal(\'show\');
                // Alert Cancelled
                $(\'#cancel_alert\').on(\'click\', function(event){
                    event.preventDefault();
                    $(\'.ui.alert.modal\').modal(\'hide\');
                    reject(\'Error\');
                });
                // Alert Confirmed
                $(\'#confirm_alert\').on(\'click\', function(event){
                    event.preventDefault();
                    $(\'.ui.alert.modal\').modal(\'hide\');
                    resolve();
                }); 
            }
            $(".user_role").children().on("click", function(event){
                event.preventDefault();
                // Toggle Alert Modal
                new Promise(alert_modal).then(() => {
                    var data = {\'role\': event.target.id, \'userId\': $(event.target).parent()[0].id};
                    $.post("'. route('admin.user.role') .'", {data: data, _token: "'. Session::token() .'" }, function(data){
                        location.reload();
                    }); 
                }).catch((e) => {console.log()});
            });</script>
        ';
        return Response::json($data);
    }

}
