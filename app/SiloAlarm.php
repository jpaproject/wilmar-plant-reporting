<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiloAlarm extends Model
{
    protected $fillable = ['storage_code', 'date', 'range_min', 'range_max', 'formula', 'text'];
}
