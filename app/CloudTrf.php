<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudTrf extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'trf';
    protected $guarded = [];
}
