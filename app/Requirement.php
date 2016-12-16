<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requirement extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'requirement_desc'
    ];

    public function companyStudent()
    {
        return $this->belongsToMany('App\CompanyStudent','requirement_student','requirement_id','company_student_id')->withTimestamps();
    }

}
