<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mixer;
use Datetime;
use App\Helpers\Alarm;
class MixerAlarmSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:mixers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will do alarm mixers checking';

    /*
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $date_from  = date('Y-m-d');
        $date_to    = date('Y-m-d');

        // $date_from  = '2020-12-24';
        // $date_to    = '2020-12-24';
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);

        $total_material = $this->countMaterial($date_from, $date_to);
        // print_r($total_material);
        $this->checkAlarm($total_material['corn'], 'corn');
        $this->checkAlarm($total_material['soya'], 'soya');
        $this->checkAlarm($total_material['eec'], 'eec');

        $total_diff = $this->difference($total_material['tonActual'], $total_material['tonTarget']);
        $this->checkAlarm($total_diff, 'diff');

       
        $batch_hour = $this->countBatchHour($total_material['total_batch'] , $total_material['total_hour']);
        // $batch_hour = 13;

        $this->checkAlarm($batch_hour, 'batch');
    }

    function countBatchHour($total_batch,$total_hour){
         try {
           return $batch_hour = $total_batch/$total_hour;
        } catch (\Throwable $th) {
            return  0;
            //throw $th;
        }
    }
    private function countMaterial($date_from, $date_to)
    {
        $total_batch = \App\Mixer::where("start_date", ">=",  $date_from . '000000')
            ->where("end_date", "<=", $date_to . '235959');
        $total_corn = 0;
        $total_wheat = 0;
        $total_soya = 0;
        $total_tonActual = 0;
        $total_tonTarget = 0;
        $total_time = 0;
        foreach ($total_batch->get() as $tb) {
            $total_time  += (int) $tb->totalTime();
            $total_corn += $tb->total_corn();
            $total_wheat += $tb->total_wheat();
            $total_soya += $tb->total_soya();
            $total_tonActual += $tb->total_actualproduct();
            $total_tonTarget += $tb->total_targetproduct();
        }
        $startData = $this->startData($date_from, $date_to);
        $endData = $this->endData($date_from, $date_to);
        $totaltime = $this->ttlTime($startData, $endData);
        $data['total_hour_2'] =   $totaltime['interval']->format('%h,%i');
        $data['total_hour_3'] =   $totaltime['interval']->format('%h.%i');

        return array(
            "corn" => $total_corn,
            "soya" => $total_soya,
            "eec" => $total_wheat,
            "tonActual" => $total_tonActual,
            "tonTarget" => $total_tonTarget,
            "total_hour" => $total_time,
            'total_batch' => $total_batch->sum('total_batch'),
            'total_hour' =>  $data['total_hour_3'] 
        );
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

    private function checkAlarm($total, $material)
    {
        $alarms = \App\AlarmMixer::where('material', $material)->get();
        foreach ($alarms as $alarm) {
            if ($alarm) {
                $trigger = false;
                if (strpos($alarm->text, '>') !== false) {
                    if ($total > $alarm->sp) {
                        $trigger = true;
                    }
                }elseif(strpos($alarm->text, '<') !== false){
                    if ($total < $alarm->sp) {
                        $trigger = true;
                    }
                }else{
                    if ($total > $alarm->sp) {
                        $trigger = true;
                    }
                }

                if ($trigger) {
                    # code...
                    // echo '->' . $material;
                    echo PHP_EOL;
                    
                    echo '-> TRIGGER ' . $material . ' : ' . $total . ' > ' . $alarm->sp;
                    echo PHP_EOL;

                    // Initialization Helper Class
                    $alarmHelper = new Alarm();

                    // Call method from helper class
                    $alarmHelper->saveAlarmList($material, $alarm->text);
                    $alarmHelper->sendTelegram("** " . $material . " ** \n" . $alarm->text);
                    $alarmHelper->sendEmail("ALARM  " . $material, $alarm->text, 'MALINDO ALARM', "MIXER " . $material);
                } else {
                    echo PHP_EOL;
                    echo '-> NORMAL ' . $material.' : ' .$total .' > '.$alarm->sp;
                    echo PHP_EOL;
                }
            }
        }

      
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
            // dd($startData);
        }
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
}
