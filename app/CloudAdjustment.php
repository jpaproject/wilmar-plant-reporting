<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudAdjustment extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'silo_adjustments';
    protected $guarded = [];
}
