<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = ['event_desc','event_date'];
    protected $dates = ['event_date'];
}
