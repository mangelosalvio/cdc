<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_no',
        'student_name',
        'college_id',
        'course_id',
        'contact_no',
        'email',
        'internship_taken_id',
        'internship_enrolled_id',
        'remarks',
        'no_of_events_given',
        'no_of_events_attended',
        'attendance_grade',
        'penalty_hrs',
        'penalty_remarks',
        'section',
        'document_filename'
    ];

    //
    /**
     * Gets the companies the student worked in
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany('App\Company')->withTimestamps()->withPivot('id');
    }

    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        if ($parent instanceof Company) {
            return new CompanyStudentPivot($parent, $attributes, $table, $exists);
        }
        return parent::newPivot($parent, $attributes, $table, $exists);
    }

    public function college(){
        return $this->belongsTo('App\College');
    }

    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function grade(){
        return $this->hasOne('App\Grade');
    }
}
