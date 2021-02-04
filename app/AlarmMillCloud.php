<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlarmMillCloud extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'alarm_mills';
    protected $guarded = [];
}
