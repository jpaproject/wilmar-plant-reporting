<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Helpers\Alarm;
class MillAlarmSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:mills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will do alarm mills checking';

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
        $date_from = date('Y-m-d', strtotime("-1 days"));
        $date_to = date('Y-m-d');
        // DASHBOARD HAMMER
        
        $data_akumulasi_hm1 = $this->akumulasi_hm($date_from, $date_to, 'HAMMER MILL 1');
        $this->checkAlarm($data_akumulasi_hm1);
        
        $data_akumulasi_hm2 = $this->akumulasi_hm($date_from, $date_to, 'HAMMER MILL 2');
        $this->checkAlarm($data_akumulasi_hm2);

      
        $data_akumulasi_hm3 = $this->akumulasi_hm($date_from, $date_to, 'HAMMER MILL 3');
        $this->checkAlarm($data_akumulasi_hm3);

        $data_akumulasi_pm1 = $this->akumulasi_hm($date_from, $date_to, 'PELLET MILL 1');
        $this->checkAlarm($data_akumulasi_pm1);

        $data_akumulasi_pm2 = $this->akumulasi_hm($date_from, $date_to, 'PELLET MILL 2');
        $this->checkAlarm($data_akumulasi_pm2);

        $data_akumulasi_pm3 = $this->akumulasi_hm($date_from, $date_to, 'PELLET MILL 3');
        $this->checkAlarm($data_akumulasi_pm3);

        $data_akumulasi_pm4 = $this->akumulasi_hm($date_from, $date_to, 'PELLET MILL 4');
        $this->checkAlarm($data_akumulasi_pm4);
    }

    private function checkAlarm($data){
        if ($data) {
            if($data->device === 'HAMMER MILL 1'){
                $device_type = 'GRD1';
            }else if($data->device === 'HAMMER MILL 2'){
                $device_type = 'GRD2';
            } else if ($data->device === 'HAMMER MILL 3') {
                $device_type = 'GRD3';
            } else if ($data->device === 'PELLET MILL 1') {
                $device_type = 'PET1';
            } else if ($data->device === 'PELLET MILL 2') {
                $device_type = 'PET2';
            } else if ($data->device === 'PELLET MILL 3') {
                $device_type = 'PET3';
            } else if ($data->device === 'PELLET MILL 4') {
                $device_type = 'PET4';
            }else{
                $device_type = 'PET4';
            }

            $kode_pakan = $this->getPakan(date('Y-m-d'), $device_type);

            $alarm = \App\AlarmMill::where('device',$data->device)->where('pakan',$kode_pakan)->first();

            // echo 'PAKAN :  ' . $data->device . ' - ' . $kode_pakan . ' - ' . $alarm;
            // echo PHP_EOL;
            if ($alarm) {
              
                if ($data->kwh_ton > $alarm->set_point) {
                    # code...
                    // echo '->' . $data->device;
                    // echo PHP_EOL;
                    echo  $data->device . ' ALARM MILL  ' . $data->kwh_ton . ' > ' . $alarm->set_point;
                    echo PHP_EOL;

                    // Initialization Helper Class
                    $alarmHelper = new Alarm();

                    // Call method from helper class
                    $alarmHelper->saveAlarmList($data->device, $alarm->text);
                    $alarmHelper->sendTelegram("** " . $data->device . " ** \n" . $alarm->text);
                    $alarmHelper->sendEmail("ALARM  " . $data->device, $alarm->text, 'MALINDO ALARM', "SILO " . $data->device);
                }else{
                    echo PHP_EOL;
                    echo  $data->device.' ALARM MILL NORMAL '.$data->kwh_ton .' > '. $alarm->set_point;
                    echo PHP_EOL;
                }
            }else{
                // echo PHP_EOL;

                // echo 'NO ALARM';
            }

        } else {
            // echo PHP_EOL;
           
            // echo " --..PASS";
            // print_r($data);
        }
        
        
    }

    private function getPakan($date_month, $device_type)
    {
        $data = DB::table('hp_materials')
            ->select("receiver_product_ident", "product_name")
            ->where('start_date_actual', 'LIKE', '%' . $date_month . '%')
            ->where("type", $device_type)
            ->where("sender", '00010101000000')
            ->orderBy('start_date_actual', 'desc')
            ->first();
        if ($data) {
            return  $this->materialName($data->receiver_product_ident);
        } else {
            return  DB::table('hp_materials')
                ->select("receiver_product_ident", "product_name")
                ->where("type", $device_type)
                ->where("sender", '00010101000000')
                ->orderBy("id", 'desc')
                ->first()->receiver_product_ident;
        }
    }

    private function MaterialName($code)
    {
        foreach (config('global.materials') as $key => $value1) {
            foreach ($value1 as $sKey) {
                if (stripos($code, $sKey) !== false) {
                    if ($key == 'wheat') {
                        $key = 'BBPT';
                    }
                    return strtoupper($sKey);
                }
            }
        }
        return false;
    }

    private function akumulasi_hm($date_from, $date_to, $data_hm)
    {
        
        return DB::table('hp_mill')
        ->select(DB::raw("
            date_trunc('day',tstamp)  AS datetime , 
            device as device,
            max(kwh_sys)-min(kwh_sys) as sys_kwh,
            max(kwh_motor)- min(kwh_motor) as motor_kwh,
            max(tonnage)- min(tonnage) as akumulasi_tonnage,
            CASE when max(tonnage)- min(tonnage)< 0.1 
            then 0 
            else ROUND(CAST((max(kwh_sys)-min(kwh_sys)+max(kwh_motor)-min(kwh_motor))/ ROUND(CAST( (max(tonnage)- min(tonnage)) as numeric),5) as numeric),3) 
            end as kwh_ton, 
            avg(current) as avg_current
            "))
            ->where("device", "LIKE", '%' . $data_hm . '%')
            ->where("tstamp", ">=", "'" . $date_from . " 08:00:00'")
            ->where("tstamp", "<=", "'" . $date_to . " 08:00:00'")
            ->where("kwh_motor", ">", 0)
            // ->where("kwh_sys", ">", 0)
            ->where("tonnage", ">", 100)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'desc')
            ->first();
    }
}
