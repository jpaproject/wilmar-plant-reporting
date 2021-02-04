<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wbfile extends Model
{
    protected $connection = 'pgsql_cloud';
    public $table = 'feedmills';
    protected $guarded = [];

    public function dateIn()
    {
        return substr($this->datein, 0, 10);
    }
    public function dateOut()
    {
        return substr($this->dateout, 0, 10);
    }
}
