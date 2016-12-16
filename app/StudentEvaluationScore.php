<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentEvaluationScore extends Model
{
    use SoftDeletes;

    protected $table = 'tpe_student_scores';
    protected $fillable = [
        'tpe_category_id',
        'tpe_question_id',
        'tpe_score',
        'tpe_student_evaluation_id'
    ];
}
