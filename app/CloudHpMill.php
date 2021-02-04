<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudHpMill extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'hp_mill';
    protected $guarded = [];
}
