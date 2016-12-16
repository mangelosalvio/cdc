<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preregistration extends Model
{
    protected $table = "preregistration";
    protected $fillable = [
        'event_id', 'student_no', 'student_name', 'course', 'email', 'contact_no','college'
    ];
}
