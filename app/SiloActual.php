<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiloActual extends Model
{
    protected $fillable = ['storage_code', 'date', 'value_actual'];
}
