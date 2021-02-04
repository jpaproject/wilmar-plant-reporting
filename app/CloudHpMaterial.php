<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudHpMaterial extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'hp_materials';
    protected $guarded = [];
}
