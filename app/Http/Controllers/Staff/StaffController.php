<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Staff;
use App\User;
use App\Degree;

class StaffController extends Controller
{
    public function index(){
        $id = Auth::id();
        $user = User::get();
        $data = Staff::where('user_id', $id)->get();
        return view('staff.home', ['data' => $data[0], 'user' => $user[0]]);
    }

    /**
     * Profile Page functions
     */ 
    public function profile(){
        $id = Auth::id();
        $staff_auth = User::where('id', $id)->select('name', 'email')->get();
        $data = Staff::where('user_id', $id)->get();

        $data[0]->name = $staff_auth[0]->name;
        $data[0]->email = $staff_auth[0]->email;

        return view('staff.profile', ['data' => $data[0]]);
    }

    public function edit(Request $request){
        $userId = Auth::id();
        if (isset($request->field)) {
            $arr = array();
            $data = $request->input();

            $field = $data['field'];
            unset($data['field']);
            unset($data['_token']);

            // 	Segregate the N entries like experience1, exp2...
            foreach ($data as $key => $value) {
                for($i = 0; $i < count($value); $i++){
                    $arr[$i][$key] = $value[$i];
                }
            }
            $data = json_encode($arr);

            Staff::where('user_id', $userId)->update([
                $field => $data,
            ]);

        }else{
            if (!empty($request->name) && !empty($request->email)) {
                User::where('id', $userId)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }
            $date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
            Staff::where('user_id', $userId)->update(['staff_id' => $request->staff_id, 'phone_number' => $request->phone_number, 'gender' => $request->gender,
                'date_of_birth' => $date_of_birth, 'permanent_address' => $request->permanent_address, 'present_address' => $request->present_address,
                'pan_card_number' => $request->pan_card_number, 'aadhar_card_number' => $request->aadhar_card_number, 'department' => $request->department,
                'designation' => $request->designation, 'anna_university_id' => $request->anna_university_id, 'aicte_id' => $request->aicte_id,
            ]);
        }

        return redirect()->back();
        
    }

    public function avatar(Request $request){
        if ($request->hasFile('avatar')) {

            $avatar = $request->avatar;
            $userId = Auth::id();

            $this->validate($request, [
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'mimes' => 'Only jpeg, png, bmp,tiff are allowed.'
            ]);
            
            //Get the Old Avatar Name
            $avatar_name = Staff::where('user_id', $userId)->select('avatar')->get();
            $file_name = ($avatar_name == 'default') ? uniqid() : $avatar_name[0]->avatar;           

            $avatar->storeAs('avatar', $file_name, 'public');
            Staff::where('user_id', $userId)->update(['avatar' => $file_name]);
        }
        
        return redirect()->back();
    }



}
