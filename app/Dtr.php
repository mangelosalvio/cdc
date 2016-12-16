<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dtr extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from_date_dtr',
        'to_date_dtr',
        'no_of_hrs',
        'file_loc'
    ];


}
