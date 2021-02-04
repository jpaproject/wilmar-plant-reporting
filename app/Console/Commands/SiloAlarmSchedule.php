<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Datetime;
use App\Helpers\Alarm;
class SiloAlarmSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alarm:silo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will do alarm silo checking';

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
        $s501 = $this->sumStorage(501);
        $s502 = $this->sumStorage(502);
        $s503 = $this->sumStorage(503);
        $s504 = $this->sumStorage(504);
        $s505 = $this->sumStorage(505);
        $s506 = $this->sumStorage(506);
        $s507 = $this->sumStorage(507);
        $s508 = $this->sumStorage(508);
        $s509 = $this->sumStorage(509);
        $s510 = $this->sumStorage(510);
        $s512 = $this->sumStorage(512);
        $s511 = $this->sumStorage(511);
        $s513 = $this->sumStorage(513);
        $s514 = $this->sumStorage(514);

        
        $st = 501;
        for ($i = 1; $i <= 14; $i++) {
            $differenceInPercent = number_format(($this->checkSetting($st,  ${'s' . $st})['erp'] - $this->sumStorage($st)) / 1000, 0, '', '');
            // $data['different']['s' . $i] = $this->checkSetting($st, ${'s' . $st})['diff'];
            $data['actual']['s' . $i] = number_format(($this->checkSetting($st, ${'s' . $st})['erp']) / 1000, 0, '', '');
            $data['wincos']['s' . $i] = number_format(${'s' . $st} / 1000, 0, ',', '.');;
            echo PHP_EOL;
            echo PHP_EOL;
            echo '**DIFFNYA : s'.$i.' = '.$differenceInPercent;
            echo PHP_EOL;

            if ($data['actual']['s' . $i]>0){
                $differenceInPercent = ($differenceInPercent/ $data['actual']['s' . $i])*100;
            }else{
                $differenceInPercent = 0;
            }
            
            if($data['actual']['s' . $i] != 0 || $data['wincos']['s' . $i] != 0 ){
                echo 'ERP :' . $i.' = '.  $data['actual']['s' . $i];
                echo PHP_EOL;
                echo 'WINCOS :' . $i.' ='.   $data['wincos']['s' . $i];
                echo PHP_EOL;
                echo $data['alarm']['s' . $i] = $this->checkAlarm($st, $differenceInPercent);
            }else{
                $text_if_zero = "ERP / WINCOS 0";

                // Initialization Helper Class
                $alarmHelper = new Alarm();

                // Call method from helper class
                $alarmHelper->saveAlarmList('SILO ' . $st, $text_if_zero);
                $alarmHelper->sendTelegram("** ALARM SILO " . $st . "  **\n" . $text_if_zero);
                $alarmHelper->sendEmail("** ALARM SILO " . $st, $text_if_zero, 'MALINDO ALARM', "SILO " . $st);
            }


            $st++;
        }
    }

    private function sumStorage($code)
    {
        $dateNow  = (date('Y-m-d 23:59:00'));
        $dateNow1  = (date('Y-m-d 23:59:00'));
        $dateSelectBefore = new DateTime($dateNow);
        $datebefore = $dateSelectBefore->modify('-1 days')->format('Y-m-d');
        $datebefore = str_replace("-", "", $datebefore);

        
        $receive = DB::table('trf')
            ->select(DB::raw("sum(qty) 
            "))
            ->where('receive', $code)
            ->where("end_date_actual", "<=",  $datebefore  . '235900')

            // ->where("datetime", ">=",  $date_from  . ' :00:00:00')
            // ->where("datetime", "<=",  $date_to  . ' : 23:59:59')
            ->first();

        $sender = DB::table('trf')
            ->select(DB::raw("sum(qty) 
            "))
            ->where('sender', $code)
            ->where("end_date_actual", "<=",  $datebefore  . '235900')

            // ->where("datetime", ">=",  $date_from  . ' :00:00:00')
            // ->where("datetime", "<=",  $date_to  . ' : 23:59:59')
            ->first();

        $adjustments = \App\SiloAdjustmentErp::where('silo', $code)
            ->where('type', '!=', 'On Hand')
            ->get();

        // Hitung nilai akumulasi adjustment dari file erp selain on hand 
        if ($adjustments) {
            // switch ($adjustment->formula) {
            //     case '-':
            //         return ($receive->sum - $sender->sum)- $adjustment->quantity;
            //         break;
            //     default:
            //         return ($receive->sum - $sender->sum) + $adjustment->quantity;
            //         break;
            // }
            // return $receive->sum - $sender->sum;
            $storageTotal = abs($receive->sum) - abs($sender->sum);
            foreach ($adjustments as $adjustment) {
                $storageTotal += $adjustment->quantity;
            }

            // return $receive->sum - $sender->sum;

            return $storageTotal;
        } else {
            return $receive->sum - $sender->sum;
        }
    }

    private function checkSetting($storage, $valueDashboard)
    {
        $settingMan = \App\SiloActual::where('storage_code', $storage)
            ->orderby('date', 'desc')
            ->first();

        if ($settingMan) {
            $settingMan = $settingMan->value_actual;
        } else {
            $settingMan = 0;
        }



        $lastJurnal = \App\SiloAdjustmentErp::where('type', 'like', '%On Hand%')
            ->orderby('date', 'desc')
            ->first();

        if ($lastJurnal) {
            $lastDate = $lastJurnal->date;
        } else {
            $lastDate = date('Y-m-d');
        }

        $setting =
            DB::table('silo_adjustments')
            ->select(DB::raw("sum(quantity) 
            "))
            ->where('silo', $storage)
            ->where('type', 'like', '%On Hand%')
            ->where('date', $lastDate)
            ->first();


        if ($setting) {
            // $diff = $setting->sum - $settingMan->value_actual;
            return array(
                // 'diff' => $diff,
                'erp' =>  $setting->sum,
                // 'act' => $setting->sum,
                'actMan' => $settingMan

            );
        } else {
            return array(
                // 'diff' => 0,
                'erp' => 0,
                // 'act' => 0,
                'actMan' => 0
            );
        }
        // if ($settingMan) {
        //     $diff = $setting->quantity - $settingMan->value_actual;
        //     return array(

        //         'actMan' => $settingMan->value_actual
        //     );
        // } else {
        //     return array(

        //         'actMan' => 0
        //     );
        // }
    }

    private function checkAlarm($storage, $diff)
    {
        // if ($diff < 0) {
        //     $alarm = \App\SiloAlarm::where('storage_code', $storage)
        //         // ->where('range_min', '<=', abs($diff))
        //         // ->where('range_max', '>=', abs($diff))
        //         // ->where('formula', '-')
        //         ->first();
                
        // } else {
        //     $alarm = \App\SiloAlarm::where('storage_code', $storage)
        //         // ->where('range_min', '<=', $diff)
        //         // ->where('range_max', '>=', $diff)
        //         // ->where('formula', '+')
        //         ->first();
        // }
        $alarm = \App\SiloAlarm::first();
        $diff = abs($diff);
        if ($alarm) {
            if ($alarm->formula == '>') {
                if ($diff > $alarm->range_max) {
                    // Initialization Helper Class
                    $alarmHelper = new Alarm();

                    // Call method from helper class
                    $alarmHelper->saveAlarmList('SILO '.$storage, $alarm->text);
                    $alarmHelper->sendTelegram("** ALARM SILO " . $storage."  **\n".$alarm->text);
                    $alarmHelper->sendEmail("** ALARM SILO " . $storage , $alarm->text, 'MALINDO ALARM', "SILO ". $storage);

                    return $storage.' : '.$alarm->text.' DIFF :'.$diff;
                } else {
                    return $storage.' : '.'-'.' DIFF :'.$diff;
                }
            } else {
                if ($diff < $alarm->range_max && $diff > 0) {
                    // Initialization Helper Class
                    $alarmHelper = new Alarm();

                    // Call method from helper class
                    $alarmHelper->saveAlarmList('SILO '.$storage, $alarm->text);
                    $alarmHelper->sendTelegram("** ALARM SILO ".$storage."  ** \n".$alarm->text);
                    $alarmHelper->sendEmail("ALARM SILO " . $storage, $alarm->text, 'MALINDO ALARM',"SILO " . $storage);

                    return $storage.' :lt '.$alarm->text.' DIFF :'.$diff;
                } else {
                    return $storage.' : '.'-'.' DIFF :'.$diff;
                }
            }
        } else {
            return '';
        }
    }
}
