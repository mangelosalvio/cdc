<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    public function companies()
    {
        return $this->belongsToMany('App\Company')->withTimestamps()->withPivot('id');
    }
}
