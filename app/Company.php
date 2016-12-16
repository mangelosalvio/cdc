<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
      'company_name',
      'address',
      'company_contact_person',
      'company_contact_no',
      'position',
      'nature_of_business'
    ];

    public function students()
    {
        return $this->belongsToMany('App\Student','company_student','company_id','student_id')->withTimestamps();
    }

    public function colleges()
    {
        return $this->belongsToMany('App\College')->withTimestamps()->withPivot('id');
    }

    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {

        if ($parent instanceof Student) {
            return new CompanyStudentPivot($parent, $attributes, $table, $exists);
        }
        return parent::newPivot($parent, $attributes, $table, $exists);
    }

    public function moaCategory(){
        return $this->belongsTo('App\MoaCategory');
    }
}
