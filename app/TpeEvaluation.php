<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TpeEvaluation extends Model
{
    use SoftDeletes;
    protected $table = 'tpe_student_evaluation';
}
