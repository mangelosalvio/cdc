<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'monitoring',
        'attendance',
        'compliance_of_reports',
        'final_reports',
        'with_monitoring'
    ];

    public function Student(){
        return $this->belongsTo('App\Student');
    }
}
