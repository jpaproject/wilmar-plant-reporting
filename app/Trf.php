<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trf extends Model
{
    public $table = 'trf';
    protected $guarded = [];

    public function startDate()
    {
        $y = substr($this->start_date_actual, 0, 4);
        $m = substr($this->start_date_actual, 4, 2);
        $d = substr($this->start_date_actual, 6, 2);
        $h = substr($this->start_date_actual, 8, 2);
        $i = substr($this->start_date_actual, 10, 2);
        $s = substr($this->start_date_actual, 12, 2);

        $date = $y . '-' . $m . '-' . $d;
        $time = $h . ':' . $i . ':' . $s;

        $datetime = $date . ' ' . $time;
        return $datetime;
    }
    public function endDate()
    {
        $y = substr($this->end_date_actual, 0, 4);
        $m = substr($this->end_date_actual, 4, 2);
        $d = substr($this->end_date_actual, 6, 2);
        $h = substr($this->end_date_actual, 8, 2);
        $i = substr($this->end_date_actual, 10, 2);
        $s = substr($this->end_date_actual, 12, 2);

        $date = $y . '-' . $m . '-' . $d;
        $time = $h . ':' . $i . ':' . $s;

        $datetime = $date . ' ' . $time;
        return $datetime;
    }
}
