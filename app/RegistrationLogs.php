<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationLogs extends Model
{
    //
    protected $table = 'registration_logs';
    protected $fillable = [
        'registration_id',
        'log_time',
        'log_status'
    ];
    public $timestamps = false;

}
