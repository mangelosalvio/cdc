<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TpeCategories extends Model
{
    use SoftDeletes;
    protected $table = 'tpe_categories';

    protected $fillable = [
        'tpe_category',
        'tpe_rate'
    ];

    public function questions(){
        return $this->hasMany('App\Evaluation','tpe_category_id');
    }
}
