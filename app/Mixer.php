<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Mixer extends Model
{
    protected $guarded = [];

    function total_actualproduct()
    {
        $totprod = DB::table('mixer_details')
            ->select(DB::raw("sum(qty_actual)"))
            ->where("mixer_id", $this->id)
            ->first();
        return $totprod->sum;
    }
    function total_targetproduct()
    {
        $material = config('global.materials.corn');
        $tottarget = DB::table('mixer_details')
            ->select(DB::raw("sum(qty_target)"))
            ->where("mixer_id", $this->id)
            ->first();
        return $tottarget->sum;
    }


    function total_corn()
    {
        $material = config('global.materials.corn');

        $products = DB::table('mixer_details')
            ->select(DB::raw("sum(qty_actual)"))
            ->where("mixer_id", $this->id)
            ->where(
                function ($query) use ($material) {
                    for ($i = 0; $i < count($material); $i++) {
                        $query->orwhere('id_rawmate', 'like',  '%' . $material[$i] . '%');
                    }
                }
            )
            ->first();
        return $products->sum ?: 0;
    }


    function total_wheat()
    {
        $material = config('global.materials.wheat');

        $products = DB::table('mixer_details')
            ->select(DB::raw("sum(qty_actual)"))
            ->where("mixer_id", $this->id)
            ->where(
                function ($query) use ($material) {
                    for ($i = 0; $i < count($material); $i++) {
                        $query->orwhere('id_rawmate', 'like',  '%' . $material[$i] . '%');
                    }
                }
            )
            ->first();
        return $products->sum ?: 0;
    }


    function total_soya()
    {
        $material = config('global.materials.soya');
        $products = DB::table('mixer_details')
            ->select(DB::raw("sum(qty_actual)"))
            ->where("mixer_id", $this->id)
            ->where(
                function ($query) use ($material) {
                    for ($i = 0; $i < count($material); $i++) {
                        $query->orwhere('id_rawmate', 'like',  '%' . $material[$i] . '%');
                    }
                }
            )
            ->first();
        return $products->sum ?: 0;
    }

    public function startDate()
    {

        $y = substr($this->start_date, 0, 4);
        $m = substr($this->start_date, 4, 2);
        $d = substr($this->start_date, 6, 2);
        $h = substr($this->start_date, 8, 2);
        $i = substr($this->start_date, 10, 2);
        $s = substr($this->start_date, 12, 2);

        $date = $y . '-' . $m . '-' . $d;
        $time = $h . ':' . $i . ':' . $s;

        $datetime = $date . ' ' . $time;
        return $datetime;
    }

    public function endDate()
    {
        $y = substr($this->end_date, 0, 4);
        $m = substr($this->end_date, 4, 2);
        $d = substr($this->end_date, 6, 2);
        $h = substr($this->end_date, 8, 2);
        $i = substr($this->end_date, 10, 2);
        $s = substr($this->end_date, 12, 2);

        $date = $y . '-' . $m . '-' . $d;
        $time = $h . ':' . $i . ':' . $s;

        $datetime = $date . ' ' . $time;
        return $datetime;
    }

    // public function totalTime(){
    //     $date_a = $this->millisecsBetween( $this->startDate() );
    //     $date_b = new DateTime($this->endDate());

    //     $interval = date_diff($date_a, $date_b);

    //     echo $interval->format('%h:%i:%s');
    // }

    function totalTime($abs = true)
    {
        $func = $abs ? 'abs' : 'intval';
        $total_time = $func(strtotime($this->end_tstamp) - strtotime($this->start_tstamp)) / 60;
        return number_format($total_time,2,'.','.');
    }
}
