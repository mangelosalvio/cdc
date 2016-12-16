<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table = 'tpe_questions';
    protected $fillable = [
        'tpe_category_id',
        'tpe_question',
        'question_version'
    ];

    public function category(){
        return $this->belongsTo('App\TpeCategories', 'tpe_category_id');
    }


    public function scopeVersion($query, $version){
        return $query->whereQuestionVersion('v' . $version);
    }
}
