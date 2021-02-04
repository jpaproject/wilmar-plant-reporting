<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudSiloName extends Model
{
    public $timestamps = false;
    protected $connection = 'pgsql_cloud';
    public $table = 'silo_names';
    protected $fillable = ['tstamp', 'storage', 'name'];

}
