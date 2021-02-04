<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiloName extends Model
{
    protected $fillable = ['tstamp', 'storage', 'name'];
    public $timestamps = false;
}
