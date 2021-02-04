<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiloActualCloud extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'silo_actuals';
    protected $guarded = [];
}
