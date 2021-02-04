<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlarmMixer extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'material', 'formula', 'sp', 'text'
    ];
}
