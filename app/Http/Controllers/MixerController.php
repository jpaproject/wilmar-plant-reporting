<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Mixer;
use \App\MixerDetail;
use Illuminate\Support\Facades\DB;
use Datetime;
use DatePeriod;
use DateInterval;

class MixerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:MixerView', ['only' => 'index']);
    }

    public function index(Request $request)
    {

        $data['page_title'] = "Mixer";
        $data['process'] = "Mixer";

        // ---- report
        if ($request->input('period') == 'day') {
            $date_month = $request->input('date');
        } elseif ($request->input('period') == 'month') {
            $date_month = $request->input('month');
        } else {
            $date_month = date('Y-m-d');
        }

        $date_month = str_replace("-", "", $date_month);
        $data['mixers'] = Mixer::orderBy('id', 'desc')
            ->where("start_date", ">=",  $date_month . '000000')
            ->where("end_date", "<=", $date_month . '235959')
            ->get();
            
        
        // ----- summary
        $date_from  = $request->input('date_from')  ?: date('Y-m-d');
        $date_to    = $request->input('date_to') ?: date('Y-m-d');


      
        // -- convert ke date ymdhis
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);

       
        $total_batch = $this->totalBatch($date_from, $date_to);

        // $data['mixers'] = $total_batch->get();

        $startData = $this->startData($date_from, $date_to);
        $endData = $this->endData($date_from, $date_to);
        $totaltime = $this->ttlTime($startData, $endData);
        $totalCurrent = $this->allTotal($total_batch);


        $corn = config('global.materials.corn');
        $soya = config('global.materials.soya');
        $wheat = config('global.materials.wheat');
        // Days list
        $dateNow0  = $request->input('date_to') . ' 23:59:59';
        $dateSelect0 = new DateTime($dateNow0);
        $date0 = $dateSelect0->modify('+1 days')->format('Y-m-d');
        $period = new DatePeriod(
            new DateTime($request->input('date_from')),
            new DateInterval('P1D'),
            new DateTime($date0)
        );

        $days = [];
        foreach ($period as $key => $value) {
            array_push($days, $value->format('Y-m-d'));
        }
        // -- Akumulasi List per day
        if ($request->input('date_from')) {
            $test = 0;
            $hour = 0;
            $data['akumulasi_hour'] = [];
            for ($i = 0; $i < count($days); $i++) {
                
                $corn_hour = $this->totalHour($corn, $days[$i]);
                $soya_hour = $this->totalHour($soya, $days[$i]);
                $wheat_hour = $this->totalHour($wheat, $days[$i]);
                $tonn = $this->tonnageHour($days[$i]);
                $total_batch_hour = $this->batchHour($days[$i]);
                if ($total_batch_hour->total_batch != null) {
                    $total_hour_hour = $this->ttlTime($total_batch_hour, $total_batch_hour)['interval']->format('%h.%i');
                } else {
                    $total_hour_hour = 0;
                }

                if($total_hour_hour>0)
                    $tbph = $total_batch_hour->total_batch / $total_hour_hour;
                else
                    $tbph = 0;

                array_push($data['akumulasi_hour'],[
                    'hour'=> $days[$i],
                    'total_batch_per_hour'=> $tbph,
                    'total_batch_hour'=> $total_batch_hour->total_batch,
                    'total_hour_hour'=> $total_hour_hour,
                    'tonn_target'=> $tonn->target,
                    'tonn_actual'=> $tonn->actual,
                    'tonn_diff'=>  $this->difference($tonn->actual,$tonn->target),
                    'corn_hour'=> $corn_hour->sum,
                    'soya_hour'=> $soya_hour->sum,
                    'wheat_hour'=> $wheat_hour->sum,
                ]);
                $test +=  $wheat_hour->sum;
            }
            // dd($data['akumulasi_hour']);
        }
        // if ($request->input('date_from')) {
        //     $test = 0;
        //     $hour = 0;
        //     $data['akumulasi_hour'] = [];
        //     $checkHour = $request->input('date_from') ? 23 : date('H');
        //     for ($i = 0; $i <=  $checkHour; $i++) {
        //         if (strlen($i) > 1) {
        //             $hour = strval($i);
        //         } else {
        //             $hour = '0' . $i;
        //         }
        //         $corn_hour = $this->totalHour($corn, $date_from, $hour);
        //         $soya_hour = $this->totalHour($soya, $date_from, $hour);
        //         $wheat_hour = $this->totalHour($wheat, $date_from, $hour);
        //         $tonn = $this->tonnageHour($date_from, $hour);
        //         $total_batch_hour = $this->batchHour($date_from, $hour);
        //         if ($total_batch_hour->total_batch != null) {
        //             $total_hour_hour = $this->ttlTime($total_batch_hour, $total_batch_hour)['interval']->format('%h.%i');
        //         } else {
        //             $total_hour_hour = 0;
        //         }

        //         if($total_hour_hour>0)
        //             $tbph = $total_batch_hour->total_batch / $total_hour_hour;
        //         else
        //             $tbph = 0;

        //         array_push($data['akumulasi_hour'],[
        //             'hour'=>$hour,
        //             'total_batch_per_hour'=> $tbph,
        //             'total_batch_hour'=> $total_batch_hour->total_batch,
        //             'total_hour_hour'=> $total_hour_hour,
        //             'tonn_target'=> $tonn->target,
        //             'tonn_actual'=> $tonn->actual,
        //             'tonn_diff'=>  $this->difference($tonn->actual,$tonn->target),
        //             'corn_hour'=> $corn_hour->sum,
        //             'soya_hour'=> $soya_hour->sum,
        //             'wheat_hour'=> $wheat_hour->sum,
        //         ]);
        //         $test +=  $wheat_hour->sum;
        //     }
        //     // dd($data['akumulasi_hour']);
        // }



        $data['total_batch'] = $total_batch->sum('total_batch');
       
        $data['total_hour'] = ($totaltime['total_hour'] == 0) ? 1 : 5;
        $data['total_hour_2'] =   $totaltime['interval']->format('%h,%i');
        $data['total_hour_3'] =   $totaltime['interval']->format('%h.%i');
        $data['total_tonActual'] = $totalCurrent['total_tonActual'];
        $data['total_tonTarget'] = $totalCurrent['total_tonTarget'];
        $data['tonn_diff'] = $this->difference($totalCurrent['total_tonActual'], $totalCurrent['total_tonTarget']);
        $data['total_corn'] = $totalCurrent['total_corn'];
        $data['total_wheat'] = $totalCurrent['total_wheat'];
        $data['total_soya'] = $totalCurrent['total_soya'];

        // before data
        $data['date_before'] = date('Y-m-d', strtotime($request->input('date_from') . " -1 days"));

        $date_from_before = str_replace("-", "", $data['date_before']);
        $date_to_before = str_replace("-", "", $data['date_before']);

        $total_batch_before = $this->totalBatch($date_from_before, $date_to_before);
        $startData_before = $this->startData($date_from_before, $date_to_before);
        $endData_before = $this->endData($date_from_before, $date_to_before);
        $totaltime_before = $this->ttlTime($startData_before, $endData_before);
        $totalCurrent_before = $this->allTotal($total_batch_before);

        $data['total_batch_before'] = $total_batch_before->sum('total_batch');
        $data['total_hour_before'] = ($totaltime_before['total_hour'] == 0) ? 1 : 5;
        $data['total_hour_2_before'] =   $totaltime_before['interval']->format('%h,%i');
        $data['total_hour_3_before'] =   $totaltime_before['interval']->format('%h.%i');
        $data['total_tonActual_before'] = $totalCurrent_before['total_tonActual'];
        $data['total_tonTarget_before'] = $totalCurrent_before['total_tonTarget'];
        $data['tonn_diff_before'] = $this->difference($totalCurrent_before['total_tonActual'], $totalCurrent_before['total_tonTarget']);
        $data['total_corn_before'] = $totalCurrent_before['total_corn'];
        $data['total_wheat_before'] = $totalCurrent_before['total_wheat'];
        $data['total_soya_before'] = $totalCurrent_before['total_soya'];



        return view('reports/mixer/index', $data);
    }

    private function totalHour($material,$date_from){
        return DB::table('mixer_details')
            ->select(DB::raw("
                        sum(mixer_details.qty_actual) as sum
                    "))
            ->join('mixers', 'mixers.id', '=', 'mixer_details.mixer_id')
            ->where(
                function ($query) use ($material) {
                    for ($i = 0; $i < count($material); $i++) {
                        $query->orwhere('id_rawmate', 'like',  '%' . $material[$i] . '%');
                    }
                }
            )
            ->where("mixers.start_tstamp", ">=",   $date_from  .' 00:00:00' )
            ->where("mixers.end_tstamp", "<=",   $date_from  . ' 23:59:59'   )
            ->first();
    }

    private function batchHour($date_from)
    {
        $total = DB::table('mixers')
            ->select(DB::raw("sum(total_batch) as total_batch,min(start_date) as start_date,max(end_date) as end_date"))
            ->where("mixers.start_tstamp", ">=",   $date_from   . ' 00:00:00')
            ->where("mixers.end_tstamp", "<=",   $date_from   . ' 23:59:59')
            ->first();
        return $total;
    }

    private function tonnageHour($date_from)
    {
        $totprod = DB::table('mixer_details')
            ->select(DB::raw("sum(qty_actual) as actual,sum(qty_target) as target"))
            ->where("mixer_details.start_tstamp", ">=",   $date_from   . ' 00:00:00')
            ->where("mixer_details.end_tstamp", "<=",   $date_from   . ' 23:59:59')
            ->first();
        return $totprod;
    }

    private function totalBatch($date_from, $date_to)
    {
        return Mixer::where("start_date", ">=",  $date_from . '000000')
        ->where("end_date", "<=", $date_to . '235959')
        ->where(DB::raw('(select sum(mixer_details.qty_actual) from mixer_details where mixer_id = mixers.id)'), '>', 0);
    }

    private function startData($date_from, $date_to)
    {
        return Mixer::select('start_date', 'end_date')->where("start_date", ">=",  $date_from . '000000')
            ->where("end_date", "<=", $date_to . '235959')
            ->orderBy('start_date', 'asc')
            ->first();
    }
    private function endData($date_from, $date_to)
    {
        return Mixer::select('start_date', 'end_date')->where("start_date", ">=",  $date_from . '000000')
            ->where("end_date", "<=", $date_to . '235959')
            ->orderBy('end_date', 'desc')
            ->first();
    }

    private function allTotal($total_batch)
    {
        $data['total_hour'] = 0;
        $data['total_tonActual'] = 0;
        $data['total_tonTarget'] = 0;
        $data['total_corn'] = 0;
        $data['total_wheat'] = 0;
        $data['total_soya'] = 0;
        foreach ($total_batch->get() as $tb) {
            $data['total_hour'] += (int) $tb->totalTime();
            $data['total_tonActual'] += $tb->total_actualproduct();
            $data['total_tonTarget'] += $tb->total_targetproduct();
            $data['total_corn'] += $tb->total_corn();
            $data['total_wheat'] += $tb->total_wheat();
            $data['total_soya'] += $tb->total_soya();
        }
        return $data;
    }

    

    private function ttlTime($startData, $endData)
    {
        try {
            if ($startData && $endData) {
                $date_start = $startData->start_date;
                $date_end = $endData->end_date;

                $y = substr($date_start, 0, 4);
                $m = substr($date_start, 4, 2);
                $d = substr($date_start, 6, 2);
                $h = substr($date_start, 8, 2);
                $i = substr($date_start, 10, 2);
                $s = substr($date_start, 12, 2);

                $date = $y . '-' . $m . '-' . $d;
                $time = $h . ':' . $i . ':' . $s;

                $datestart = $date . ' ' . $time;

                $y = substr($date_end, 0, 4);
                $m = substr($date_end, 4, 2);
                $d = substr($date_end, 6, 2);
                $h = substr($date_end, 8, 2);
                $i = substr($date_end, 10, 2);
                $s = substr($date_end, 12, 2);
                $date = $y . '-' . $m . '-' . $d;
                $time = $h . ':' . $i . ':' . $s;
                $dateend = $date . ' ' . $time;
            } else {
                $datestart = date('Y-m-d H:i:s');
                $dateend = date('Y-m-d H:i:s');
            }

            $datetime1 = new DateTime($datestart);
            $datetime2 = new DateTime($dateend);
            $interval = $datetime1->diff($datetime2);
            $totaltime = $interval->format('%h.%i');

            return [
                'total_hour' => $totaltime,
                'interval' => $interval,
            ];
        } catch (\Throwable $th) {
            //throw $th;
            dd($startData);
        }
     
    }
    private function difference($actual, $target)
    {
        if ($actual == 0 && $target == 0) {
            $percentChange = 0;
        }

        if (($actual == 0 and $target != 0) or ($actual != 0 and $target == 0)) {
            $percentChange = 100;
        }

        if ($actual != 0 and $target != 0) {
            try {

                $diff = $target - $actual;
                $sum = ($actual + $target) / 2;
                $percentChange = (($diff) / ($sum)) * 100;
            } catch (\Throwable $th) {
                //throw $th;
                // dd($th->getMessage());
                $percentChange = 0;
            }
        }
        return $percentChange;
    }
}
