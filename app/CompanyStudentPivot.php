<?php

namespace App;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyStudentPivot extends Pivot {
    protected $id = 'id';

    public function student(){
        return $this->belongsTo('App\Student','student_id');
    }

    public function company(){
        return $this->belongsTo('App\Company','company_id');
    }

    public function dtrs(){
        return $this->hasMany('App\Dtr','company_student_id','id');
    }

    public function requirements()
    {
        return $this->belongsToMany('App\Requirement', 'requirement_student','company_student_id','requirement_id')->withTimestamps()->withPivot('id','ref');
    }

    public function evaluations(){
        return $this->hasMany('App\StudentEvaluation','company_student_id');
    }
}