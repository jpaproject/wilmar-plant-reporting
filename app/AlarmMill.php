<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlarmMill extends Model
{
    protected $fillable = ['device', 'pakan', 'set_point', 'text'];
}
