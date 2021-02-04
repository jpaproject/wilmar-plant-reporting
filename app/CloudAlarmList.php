<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudAlarmList extends Model
{
    protected $connection = 'pgsql_cloud';
    protected $table = 'alarm_lists';
    protected $guarded = [];
}
