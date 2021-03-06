<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Auth;
use App\User;
use App\Staff;
use App\Role;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::where('name', 'like', '%'.$request->value.'%')->get();
        if (!isset($users[0])) {
            $users = Staff::where('department', 'like', '%'.$request->value.'%')->orWhere('staff_id', $request->value)->get();
        }
        
        $data = '
            <table class="ui table"><thead><tr><th>Name</th><th>Email</th><th>Designation</th><th>Department</th><th></th></tr></thead><tbody>
        ';
        foreach ($users as $user) {
            if(!isset($user->name)){
                $user = User::find($user->user_id);
            }
            if(isset($user->profile)){
                $data .= '
                    <tr>
                        <td>'. $user->name .'</td>
                        <td>'. $user->email .'</td>
                        <td>'. $user->profile->designation .'</td>
                        <td>'. $user->profile->department .'</td>
                ';
                $data .= isset($user->profile->staff_id) ? '<td><a class="ui blue button" href="/search/'.$user->profile->staff_id.'"><i class="eye outline icon"></i> View</a></td></tr>' : '<td><a class="ui disabled button"><i class="eye outline icon"></i> View</a></td></tr>';
            }
        }
        $data .= '
            </tbody></table>
        ';
        return Response::json($data);
    }

    public function show($id){
        $data = Staff::where('staff_id', $id)->firstOrFail();   
        $staff_auth = User::where('id', $data->user_id)->select('name', 'email', 'avatar')->firstOrFail();
        
        $data->name = $staff_auth->name;
        $data->email = $staff_auth->email;
        $data->avatar = $staff_auth->avatar;
        
        // LogedIn User Avatar
        $userId = Auth::id();
        $avatar = User::where('id', $userId)->select('avatar')->first();      
        
        return view('user', ['data' => $data, 'avatar' => $avatar->avatar]);
    }

    // public function remove(Request $request){
    //     $user = Auth::user();
    //     $id = ($user->roles[0]->name === 'admin') ? $request->data : $user->id;
        
    //     // Admin role protection
    //     $targetUser = User::where('id', $id)->firstOrFail();
    //     if ($targetUser->roles[0]->name !== 'admin') {
    //         User::delete()->where('id', $id);
    //     }

    //     return null;
    // }
    
}
 