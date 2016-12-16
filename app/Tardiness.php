<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tardiness extends Model
{
    protected $table = 'tardiness';
    protected $fillable = [
        'student_id',
        'date_filed',
        'from_date',
        'to_date',
        'type_of_absence',
        'reason',
        'remarks'
    ];

    public function student()
    {
        return $this->belongsTo('App\Student');
    }
}


