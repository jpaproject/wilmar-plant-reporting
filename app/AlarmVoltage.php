<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlarmVoltage extends Model
{
    public $timestamps = true;
    protected $fillable = [
         'normal','range', 'event', 'text'
    ];
}
