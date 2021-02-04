<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use \App\AlarmWb;
use App\AlarmList;
use App\Helpers\Alarm;
class WbAlarm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:wb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $corn = "'" . implode("','", config('global.materials.corn')) . "'";
        $soya = "'" . implode("','", config('global.materials.soya')) . "'";
        $wheat = "'" . implode("','", config('global.materials.wheat')) . "'";
        $all_material = $corn . ',' . $soya . ',' . $wheat;
        $date_month = date('Y-m-d');

        $wbfiles =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            select  a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
           
            from(
            select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
           
            from wbfile a
            where a.statusax = 'Y' and a.flag = 'Y'
            ) a  WHERE itemno  IN ($all_material ) and  dateout like  '%$date_month%'");

        foreach ($wbfiles as $wbfile) {
            $start = $wbfile->datein.' '.$wbfile->timein;
            $end = $wbfile->dateout.' '.$wbfile->timeout;

            $to_time = strtotime($start);
            $from_time = strtotime($end);
            $duration = round(abs($to_time - $from_time) / 60, 2) ;
            $this->checkAlarm($duration,$wbfile->ticket);
        
            echo PHP_EOL;
            echo '---------------';
            echo PHP_EOL;
        }
    }

    function checkAlarm($duration,$ticket){
        $wb_alarms = AlarmWb::orderby('id', 'desc')->get();
        $check_ticket_alarm = AlarmList::where('event','like','%'.$ticket.'%')->first();
        foreach ($wb_alarms as $wb_alarm) {
            if($duration > $wb_alarm->duration){
                echo '-> TRIGGER ' . $ticket . $duration . ' > ' . $wb_alarm->duration . ' minutes';
                echo PHP_EOL;
                // check jika alarm sudah ada
                if($check_ticket_alarm == null){

                    // Initialization Helper Class
                    $alarmHelper = new Alarm();

                    // Call method from helper class
                    $alarmHelper->saveAlarmList('ALARM WEIGHT BRIDGE '.$ticket, $wb_alarm->text);
                    echo "SAVE ALARM";
                    $alarmHelper->sendTelegram("** " . 'ALARM WEIGHT BRIDGE ' . $ticket . " ** \n" . $wb_alarm->text);
                    $alarmHelper->sendEmail('ALARM WEIGHT BRIDGE ' . $ticket, $wb_alarm->text, 'MALINDO ALARM', "WEIGHT BRIDGE " . $ticket);
                }else{
                    echo " ALARM EXIST";
                }
            }else{
                echo '-> NORMAL' . $duration . ' > ' . $wb_alarm->duration . ' minutes';
           }
        }
    }
}
