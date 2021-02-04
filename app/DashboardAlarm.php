<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardAlarm extends Model
{
    protected $fillable = ['material', 'set_point','text'];
}
