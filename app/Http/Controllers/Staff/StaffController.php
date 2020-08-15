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
        return view('staff.home');
    }

    public function create_details(){
        return view('staff.home');
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
        //dd($data);
        return view('staff.profile', ['data' => $data[0]]);
    }

    public function profileUpdate(Request $request){
        $userId = Auth::id();
        if (!empty($request->name) && !empty($request->email)) {
            User::where('id', $userId)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }
        $date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
        Staff::where('user_id', $userId)->update([
            'staff_id' => $request->staff_id,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'date_of_birth' => $date_of_birth,
            'permanent_address' => $request->permanent_address,
            'present_address' => $request->present_address,
            'pan_card_number' => $request->pan_card_number,
            'aadhar_card_number' => $request->aadhar_card_number,
            'department' => $request->department,
            'designation' => $request->designation,
            'anna_university_id' => $request->anna_university_id,
            'aicte_id' => $request->aicte_id,
        ]);

        return redirect('/staff/profile');
    }

    public function avatar(Request $request){
        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;
            $file_name = uniqid();
            
            $avatar->storeAs('avatar', $file_name, 'public');
            $userId = Auth::id();
            
            Staff::where('user_id', $userId)->update(['avatar' => $file_name]);

            return redirect()->back();
        }
    }

    /**
     * Qualification Page functions
     */ 
    public function qualification(){
        $userId = Auth::id();
        $data = Staff::where('user_id', $userId)->select('academic_qualification', 'experience')->get();
        $degree = Degree::all();
        //dd($degrees);
        return view('/staff/qualification', ['data' => $data[0], 'degrees' => $degree]);
    }

    /**
     * Qualification Page functions
     */ 
    public function publication(){
        $userId = Auth::id();
        $data = Staff::where('user_id', $userId)->select('journal', 'book', 'conference')->get();
        
        return view('/staff/publication', ['data' => $data[0]]);
    }

    /**
     * Workshop and FDP Page functions
     */ 
    public function workshop(){
        $userId = Auth::id();
        $data = Staff::where('user_id', $userId)->select('workshop', 'fdp')->get();
        
        return view('/staff/workshop', ['data' => $data[0]]);
    }

    /**
     * Online Course Page functions
     */ 
    public function online_course(){
        $userId = Auth::id();
        $data = Staff::where('user_id', $userId)->select('online_course', 'award')->get();
        
        return view('/staff/online_course', ['data' => $data[0]]);
    }

    public function jsonUpdate(Request $request){
        $userId = Auth::id();
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
       
        return redirect()->back();	
    }


}
