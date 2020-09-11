<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staff_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'staff_id', 'phone_number', 'gender', 'date_of_birth', 'permanent_address', 'present_address', 'pan_card_number', 'aadhar_card_number', 'department', 'designation',
        'anna_university_id', 'aicte_id', 'academic_qualification', 'experience', 'journal', 'conference', 'online_course', 'book',
    ];

    public function users(){
        return $this->hasOne('App\User');
    }
}
