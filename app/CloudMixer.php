<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudMixer extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'mixers';
    protected $guarded = [];
}
