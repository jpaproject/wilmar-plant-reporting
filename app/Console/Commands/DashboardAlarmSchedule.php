<?php

namespace App\Console\Commands;

use App\DashboardAlarm;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Datetime;
use App\Helpers\Alarm;
class DashboardAlarmSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will do alarm dashboard checking';

    /**
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
        $corn = config('global.materials.corn');
        $soya = config('global.materials.soya');
        $wheat = config('global.materials.wheat');      

        $dateNow  = (date('Y-m-d 23:59:00'));
        $dateNow1  = (date('Y-m-d 23:59:00'));
        $dateSelectBefore = new DateTime($dateNow);
        $datebefore = $dateSelectBefore->modify('-1 days')->format('Y-m-d');
        $date_from = $datebefore;
        $date_to = $datebefore;

        $corn_wb = $this->sumWb($corn, $date_from, $date_to);
        $soya_wb = $this->sumWb($soya, $date_from, $date_to);
        $wheat_wb = $this->sumWb($wheat, $date_from, $date_to);

        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $corn_total = $this->sumTotalMaterial( $date_from, $date_to, $corn);
        $soya_total = $this->sumTotalMaterial($date_from, $date_to, $soya);
        $wheat_total = $this->sumTotalMaterial($date_from, $date_to, $wheat);
        // -- Data Alarm
       
        $this->checkAlarm('MALINDO ALARM', 'DASHBOARD - CORN ALARM','corn', $corn_wb, $corn_total);
        $this->checkAlarm('MALINDO ALARM', 'DASHBOARD - WHEAT ALARM','soya', $soya_wb, $soya_total);
        $this->checkAlarm('MALINDO ALARM', 'DASHBOARD - EEC ALARM', 'bbpt', $wheat_wb, $wheat_total);
       
    }

    public function checkAlarm($subject, $event,$material,$mat_wb,$mat_total){
        $data_alarm_ = DashboardAlarm::where('material', $material)->orderBy('id', 'desc')->first();
        if($data_alarm_){
            $diff = abs($this->difference($mat_wb, $mat_total));
            if ($diff >= $data_alarm_->set_point) {
                $data_alarm_->set_point;
                $msg = $data_alarm_->text;
                
                // Initialization Helper Class
                $alarmHelper = new Alarm();

                // Call method from helper class
                $alarmHelper->saveAlarmList($event, $msg);
                $alarmHelper->sendTelegram($msg);
                $alarmHelper->sendEmail($event, $msg, $subject, $material);
            }else{
                echo date('Y-m-d H:i:s').'-> Normal alarm ' . $material.':' .$diff.'>='. $data_alarm_->set_point;
                echo PHP_EOL;  
            }
        }else{
            echo date('Y-m-d H:i:s').'-> No alarm '.$material;
            echo PHP_EOL;
        }
    }

    private function difference($val1, $val2)
    {
        if ($val1 == 0 && $val2 == 0) {
            $percentChange = 0;
        } else {
            try {

                $diff = $val2 - $val1;
                $sum = ($val1 + $val2) / 2;
                $percentChange = (($diff) / ($sum)) * 100;
            } catch (\Throwable $th) {
                //throw $th;
                // dd($th->getMessage());
                $percentChange = 0;
            }
        }
        return $percentChange;
    }

    private function sumTotalMaterial($date_from, $date_to, $material){
        $total = DB::table('trf')
            ->select(DB::raw("sum(qty)"))
            ->where("type", "LIKE", '%INT%')
            ->where("receiver_product_ident", "!=", '123')
            ->where(
                function ($query) use ($material) {
                    for ($i = 0; $i < count($material); $i++) {
                        $query->orwhere('receiver_product_ident', 'like',  '%' . $material[$i] . '%');
                        // ->orwhere('receiver_product_ident', '!=' ,  '123');
                    }
                }
            )
            ->where("end_date_actual", ">=",  $date_from  . '000000')
            ->where("end_date_actual", "<=",  $date_to  . '235959')
            ->first()->sum;
            return $total;
    }

    private function sumWb($material, $date_from, $date_to)
    {
        if (env('DB_WB') == 'SQLSERVER') {
            $material = "'" . implode("','", $material) . "'";

            $count =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            select sum(a.nett) as sum
            from(
            select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
            from wbfile a
            where a.statusax = 'Y' and a.flag = 'Y'
            ) a WHERE itemno  IN ($material) and dateout >= '$date_from' and dateout <= '$date_to'");
            // ) a WHERE itemno  IN ($material) and dateout like  '%$date_from%'")
            return $count[0]->sum;
        } else {
            $count = DB::table('feedmills')
            ->select(DB::raw("sum(nett) 
            "))
            ->where(
                function ($query) use ($material) {
                    for ($i = 0; $i < count($material); $i++) {
                        $query->orwhere('itemno', 'like',  '%' . $material[$i] . '%');
                    }
                }
            )
                // ->where("datein", ">=",  $date_from  . 'T00:00:00.000+00:0')
                // ->where("dateout", "<=",  $date_to  . 'T99:99:99.999+99:99')
                ->where("end_tstamp", ">=",  $date_from  . ' 00:00:00')
                ->where("end_tstamp", "<=",  $date_to  . ' 23:59:59')
                ->first();
            return $count->sum;
        }
    }
}
