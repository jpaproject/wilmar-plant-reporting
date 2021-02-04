<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlarmSetting extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'tag_name', 'formula', 'sp', 'text', 'status','trigger'
    ];
}
