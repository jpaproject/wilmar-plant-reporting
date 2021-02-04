<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlarmWb extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'tstamp', 'duration', 'event', 'text'
    ];
}
