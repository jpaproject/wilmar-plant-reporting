<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiSetting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'idstasiun', 'apikey', 'apisecret',
    ];
}
