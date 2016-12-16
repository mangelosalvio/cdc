<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = "registration";

    protected $fillable = [
        'event_id',
        'student_no',
        'student_name',
        'course',
        'college',
        'email',
        'contact_no',
        'time_in'
    ];

    protected $dates = [
      'created_at', 'updated_at','time_in'
    ];

    public function logs(){
        return $this->hasMany('App\RegistrationLogs','registration_id');
    }
}
