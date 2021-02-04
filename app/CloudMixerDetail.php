<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudMixerDetail extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'mixer_details';
    protected $guarded = [];
}
