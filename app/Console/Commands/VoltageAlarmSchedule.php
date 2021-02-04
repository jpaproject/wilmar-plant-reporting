<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Helpers\Alarm;
class VoltageAlarmSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:voltage';

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
        $data_pm1 = DB::table('hp_mill')
        ->select('voltage')
        ->where('device', 'PELLET MILL 1')
        ->where("tstamp", ">=",  date('Y-m-d')  . ' :00:00:00')
        ->where("tstamp", "<=",  date('Y-m-d')  . ' : 23:59:59')
        ->orderBy('id', 'desc')
        ->first();
        $alarm = \App\AlarmVoltage::first();
        try {
            // $voltage_actual = 379;
            $voltage_actual = $data_pm1->voltage;
            $voltage_normal = $alarm->normal;
            $range = abs($voltage_actual - $voltage_normal); 
            if( $range >= $alarm->range){
                echo $alarm->text; 

                // Initialization Helper Class
                $alarmHelper = new Alarm();

                // Call method from helper class
                $alarmHelper->saveAlarmList($alarm->event, $alarm->text);  
                $alarmHelper->sendTelegram($alarm->text);            
                // $alarm->sendEmail("ALARM  " . $material, $alarm->text, 'MALINDO ALARM', "MIXER " . $material);
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
