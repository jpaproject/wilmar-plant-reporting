<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardAlarmCloud extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'dashboard_alarms';
    protected $guarded = [];
}
