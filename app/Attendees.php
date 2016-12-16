<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendees extends Model
{
    protected $fillable = [
        'student_no',
        'student_name',
        'course'
    ];

}
