<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiloAlarmCloud extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'silo_alarms';
    protected $guarded = [];
}
