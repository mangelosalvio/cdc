<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentEvaluation extends Model
{
    use SoftDeletes;

    protected $table = 'tpe_student_evaluation';
    protected $fillable = [
        'rating',
        'date',
        'comments',
        'rated_by',
        'position',
        'tpe_version'
    ];

    public function scores(){
        return $this->hasMany('App\StudentEvaluationScore','tpe_student_evaluation_id');
    }

    public function scopeVersion($query, $version){
        return $query->whereTpeVersion('v' . $version);
    }



}
