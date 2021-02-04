<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiloSettingCloud extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'silo_settings';
    protected $guarded = [];
}
