<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hp_mill extends Model
{
    protected $table = 'hp_mill';
    protected $guarded = [];

    function kwh_ton(){

        return $this->kwh_sys/ $this->tonnage;
    }

}
