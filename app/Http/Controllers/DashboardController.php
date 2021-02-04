<?php

namespace App\Http\Controllers;

use App\Departement as Departements;
use App\SiloAdjustmentErp;
use App\User as Users;
use App\SiloSetting;
use App\SiloName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datetime;
use DatePeriod;
use DateInterval;
class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('privilege:Dashboard');
    }

    public function index(Request $request)
    {

        $data['users'] = Users::paginate(5);
        $data['page_title'] = 'Dashboard';
        $data['departements'] = Departements::all();


        // summary
        $date_from  = $request->input('date_from')  ?: date('Y-m-d');
        $date_to    = $request->input('date_to') ?: date('Y-m-d');
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        // -- corn
        $corn = config('global.materials.corn');
        $total_corn = $this->sumMaterial($corn, $date_from, $date_to);

        // -- soya
        $soya = config('global.materials.soya');
        $total_soya = $this->sumMaterial($soya, $date_from, $date_to);


        // -- wheat
        $wheat = config('global.materials.wheat');
        $total_wheat =  $this->sumMaterial($wheat, $date_from, $date_to);

        // ---- report
        if ($request->input('period') == 'day') {
            $daterange = 'hour';
            $date_month = $request->input('date');
        } elseif ($request->input('period') == 'month') {
            $daterange = 'day';
            $date_month = $request->input('month');
        } else {
            $daterange = 'hour';
            $date_month = date('Y-m-d');
        }


        if (env('DB_WB') == 'SQLSERVER') {
            $corn = "'" . implode("','", config('global.materials.corn')) . "'";
            $soya = "'" . implode("','", config('global.materials.soya')) . "'";
            $wheat = "'" . implode("','", config('global.materials.wheat')) . "'";
        } else {
            $date_from  = $request->input('date_from')  ?: date('Y-m-d');
            $date_to    = $request->input('date_to') ?: date('Y-m-d');
        }


        // Days list
        $dateNow0  = $request->input('date_to').' 23:59:59';
        $dateSelect0 = new DateTime($dateNow0);
        $date0 = $dateSelect0->modify('+1 days')->format('Y-m-d');
        $period = new DatePeriod(
            new DateTime($request->input('date_from')),
            new DateInterval('P1D'),
            new DateTime($date0)
        );

        $days = [];
        foreach ($period as $key => $value) {
            array_push($days,$value->format('Y-m-d'));  
        }

        // -- Akumulasi List per hour
        // if ($request->input('date_from')) {
        //     $hour = 0;
        //     $data['akumulasi_hour'] = [];
        //     $checkHour = $request->input('date_from') ? 23 : date('H');
        //     for ($i = 0; $i <=  $checkHour; $i++) {
        //         if (strlen($i) > 1) {
        //             $hour = strval($i);
        //         } else {
        //             $hour = '0' . $i;
        //         }

        //         $akumulasiWbCorn = $this->sumWbHour($corn, $request->input('date_from') ?: date('Y-m-d'), $request->input('date_from') ?: date('Y-m-d'), $hour . ':00:00', $hour . ':59:59');
        //         $akumulasiWbSoya = $this->sumWbHour($soya, $request->input('date_from') ?: date('Y-m-d'), $request->input('date_from') ?: date('Y-m-d'), $hour . ':00:00', $hour . ':59:59');
        //         $akumulasiWbWheat = $this->sumWbHour($wheat, $request->input('date_from') ?: date('Y-m-d'), $request->input('date_from') ?: date('Y-m-d'), $hour . ':00:00', $hour . ':59:59');

        //         $akumulasiIntCorn = $this->sumMaterialHour(config('global.materials.corn'), str_replace("-", "", $request->input('date_from') ?: date('Y-m-d')) . $hour, str_replace("-", "", $request->input('date_from') ?: date('Y-m-d')) . $hour);
        //         $akumulasiIntSoya = $this->sumMaterialHour(config('global.materials.soya'), str_replace("-", "", $request->input('date_from') ?: date('Y-m-d')) . $hour, str_replace("-", "", $request->input('date_from') ?: date('Y-m-d')) . $hour);
        //         $akumulasiIntWheat = $this->sumMaterialHour(config('global.materials.wheat'), str_replace("-", "", $request->input('date_from') ?: date('Y-m-d')) . $hour, str_replace("-", "", $request->input('date_from') ?: date('Y-m-d')) . $hour);
        //         $data_per_hour = array(
        //             'hour' => $hour . ':00:00 ',
        //             'wb_corn' => $akumulasiWbCorn ?: 0,
        //             'wb_soya' => $akumulasiWbSoya ?: 0,
        //             'wb_wheat' => $akumulasiWbWheat ?: 0,
        //             'intake_corn' => $akumulasiIntCorn ?: 0,
        //             'intake_soya' => $akumulasiIntSoya ?: 0,
        //             'intake_wheat' =>  $akumulasiIntWheat ?: 0,
        //             'diff_corn' =>  $this->difference($akumulasiWbCorn, $akumulasiIntCorn),
        //             'diff_soya' =>  $this->difference($akumulasiWbSoya, $akumulasiIntSoya),
        //             'diff_wheat' =>  $this->difference($akumulasiWbWheat, $akumulasiIntWheat),
        //         );
        //         array_push($data['akumulasi_hour'], $data_per_hour);
        //     }
        // }
        if ($request->input('date_from')) {
            $hour = 0;
            $data['akumulasi_hour'] = [];
            $checkHour = $request->input('date_from') ? 23 : date('H');
            for ($i = 0; $i <  count($days); $i++) {
                

                $akumulasiWbCorn = $this->sumWbHour($corn, $days[$i], $days[$i], '00:00:00','23:59:59');
                $akumulasiWbSoya = $this->sumWbHour($soya, $days[$i], $days[$i], '00:00:00','23:59:59');
                $akumulasiWbWheat = $this->sumWbHour($wheat, $days[$i], $days[$i], '00:00:00','23:59:59');

                $akumulasiIntCorn = $this->sumMaterialHour(config('global.materials.corn'), str_replace("-", "",  $days[$i] ) . '00', str_replace("-", "",  $days[$i]) . '23');
                $akumulasiIntSoya = $this->sumMaterialHour(config('global.materials.soya'), str_replace("-", "",  $days[$i] ) . '00', str_replace("-", "",  $days[$i]) . '23');
                $akumulasiIntWheat = $this->sumMaterialHour(config('global.materials.wheat'), str_replace("-", "",  $days[$i]) . '00', str_replace("-", "",  $days[$i]) . '23');
                $data_per_hour = array(
                    'hour' => $days[$i],
                    'wb_corn' => $akumulasiWbCorn ?: 0,
                    'wb_soya' => $akumulasiWbSoya ?: 0,
                    'wb_wheat' => $akumulasiWbWheat ?: 0,
                    'intake_corn' => $akumulasiIntCorn ?: 0,
                    'intake_soya' => $akumulasiIntSoya ?: 0,
                    'intake_wheat' =>  $akumulasiIntWheat ?: 0,
                    'diff_corn' =>  $this->difference($akumulasiWbCorn, $akumulasiIntCorn),
                    'diff_soya' =>  $this->difference($akumulasiWbSoya, $akumulasiIntSoya),
                    'diff_wheat' =>  $this->difference($akumulasiWbWheat, $akumulasiIntWheat),
                );
                array_push($data['akumulasi_hour'], $data_per_hour);
            }
        }


        


        $data['corn_wb'] = $this->sumWb($corn, $request->input('date_from') ?: date('Y-m-d'), $request->input('date_to') ?: date('Y-m-d'));
        $data['soya_wb'] = $this->sumWb($soya, $request->input('date_from') ?: date('Y-m-d'), $request->input('date_to') ?: date('Y-m-d'));
        $data['wheat_wb'] = $this->sumWb($wheat, $request->input('date_from') ?: date('Y-m-d'), $request->input('date_to') ?: date('Y-m-d'));

        $data['corn_total'] = $total_corn->sum;
        $data['soya_total'] = $total_soya->sum;
        $data['wheat_total'] = $total_wheat->sum;

        $data['corn_diff'] = $this->difference($data['corn_wb'], $data['corn_total']);
        $data['soya_diff'] = $this->difference($data['soya_wb'], $data['soya_total']);
        $data['wheat_diff'] = $this->difference($data['wheat_wb'], $data['wheat_total']);


        $data['w_storage']['w1'] = 001;
        $data['w_storage']['w2'] = 002;
        $data['w_storage']['w3'] = 003;
        $data['is_floor'] = $this->isFloor($date_from, $date_to);

        // SILO SUMMARY

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
        // dd($this->checkSetting('501', ${'s501'})['erp']);
        /* --- HITUNG SILO
        ERP = $data['actual'][$tank]
        wincos = $s501

        */
        $st = 501;
        for ($i = 1; $i <= 14; $i++) {
            $data['silo_name' . $i] = $this->siloName($st);

            // $data['different']['s' . $i] = number_format($this->checkSetting($st, ${'s' . $st})['diff'], 0, ',', '.');
            $data['different']['s' . $i] = number_format(($this->checkSetting($st, ${'s' . $st})['erp'] - $this->sumStorage($st)) / 1000, 0, ',', '.');
            $data['actual']['s' . $i] = number_format(($this->checkSetting($st, ${'s' . $st})['erp']) / 1000, 0, ',', '.');
            $data['actualMan']['s' . $i] = number_format(($this->checkSetting($st, ${'s' . $st})['actMan']) / 1000, 0, ',', '.');
            $data['alarm']['s' . $i] = $this->checkAlarm($st, $data['different']['s' . $i]);
            // dd($data['alarm']['s' . $i]);
            $st++;
        }


        $data['silo_storage']['s1']  =  number_format($s501 / 1000, 0, ',', '.');
        $data['silo_storage']['s2']  =  number_format($s502 / 1000, 0, ',', '.');
        $data['silo_storage']['s3']  =  number_format($s503 / 1000, 0, ',', '.');
        $data['silo_storage']['s4']  =  number_format($s504 / 1000, 0, ',', '.');
        $data['silo_storage']['s5']  =  number_format($s505 / 1000, 0, ',', '.');
        $data['silo_storage']['s6']  =  number_format($s506 / 1000, 0, ',', '.');
        $data['silo_storage']['s7']  =  number_format($s507 / 1000, 0, ',', '.');
        $data['silo_storage']['s8']  =  number_format($s508 / 1000, 0, ',', '.');
        $data['silo_storage']['s9']  =  number_format($s509 / 1000, 0, ',', '.');
        $data['silo_storage']['s10'] =  number_format($s510 / 1000, 0, ',', '.');
        $data['silo_storage']['s11'] =  number_format($s511 / 1000, 0, ',', '.');
        $data['silo_storage']['s12'] =  number_format($s512 / 1000, 0, ',', '.');
        $data['silo_storage']['s13'] =  number_format($s513 / 1000, 0, ',', '.');
        $data['silo_storage']['s14'] =  number_format($s514 / 1000, 0, ',', '.');

        // cut off hari sebelumnya
        $data['date_before'] =
            $date_from = date('Y-m-d', strtotime($request->input('date_from') . " -1 days"));
        $date_to    = $request->input('date_to') ?: date('Y-m-d');

        $data['is_floor_before'] = $this->isFloor($date_from, $date_to);

        $data['corn_wb_before'] = $this->sumWb($corn, $date_from, $date_from  ?: date('Y-m-d'));
        $data['soya_wb_before'] = $this->sumWb($soya, $date_from, $date_from  ?: date('Y-m-d'));
        $data['wheat_wb_before'] = $this->sumWb($wheat, $date_from, $date_from  ?: date('Y-m-d'));

        // -- convert date intake
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $corn = config('global.materials.corn');
        $soya = config('global.materials.soya');
        $wheat = config('global.materials.wheat');
        $data['corn_total_before'] = $this->sumMaterial($corn, $date_from, $date_from, 'BEFORE_CORN');
        $data['soya_total_before'] = $this->sumMaterial($soya, $date_from, $date_from, 'BEFORE_SOYA');
        $data['wheat_total_before'] = $this->sumMaterial($wheat, $date_from, $date_from, 'BEFORE_WHEAT');

        $data['corn_diff_before'] = $this->difference($data['corn_wb_before'], $data['corn_total_before']->sum);
        $data['soya_diff_before'] = $this->difference($data['soya_wb_before'], $data['soya_total_before']->sum);
        $data['wheat_diff_before'] = $this->difference($data['wheat_wb_before'], $data['wheat_total_before']->sum);

        $dateNow  = (date('Y-m-d 23:59:00'));
        $dateNow1  = (date('Y-m-d 23:59:00'));
        $dateSelectBefore = new DateTime($dateNow);
        $datebefore = $dateSelectBefore->modify('-1 days')->format('Y-m-d');
        // $datebefore = str_replace("-", "", $datebefore);

        $data['date_silo'] =  $datebefore . ' 00:00:00' . ' - ' . $datebefore . ' 23:59:00';

        return view('dashboard.index', $data);
    }

    private function sumMaterial($material, $date_from, $date_to, $name = '')
    {
        try {
            return DB::table('trf')
                ->select(DB::raw("sum(qty)"))
                ->where("type", "LIKE", '%INT%')
                ->where('receiver_product_ident', '!=', '123')
                ->where(
                    function ($query) use ($material) {
                        for ($i = 0; $i < count($material); $i++) {
                            $query->orwhere('receiver_product_ident', 'like',  '%' . $material[$i] . '%');
                        }
                    }
                )
                ->where("end_date_actual", ">=",  $date_from  . '000000')
                ->where("end_date_actual", "<=",  $date_to  . '235959')
                ->first();
        } catch (\Throwable $th) {
            //throw $th;
            // dd($material);
            dd($name);
        }
    }

    private function sumMaterialHour($material, $date_from, $date_to, $name = '')
    {
        try {
            return DB::table('trf')
                ->select(DB::raw("sum(qty)"))
                ->where("type", "LIKE", '%INT%')
                ->where('receiver_product_ident', '!=', '123')
                ->where(
                    function ($query) use ($material) {
                        for ($i = 0; $i < count($material); $i++) {
                            $query->orwhere('receiver_product_ident', 'like',  '%' . $material[$i] . '%');
                        }
                    }
                )
                ->where("end_date_actual", ">=",  $date_from  . '0000')
                ->where("end_date_actual", "<=",  $date_to  . '5959')
                ->first()->sum?:0; 
        } catch (\Throwable $th) {
            //throw $th;
            // dd($material);
            dd($name);
        }
    }
    private function siloName($storage)
    {
        $silo_name = SiloName::where('storage', $storage)->first();
        if ($silo_name) {
            return $silo_name->name;
        } else {;
            return null;
        }
    }

    private function difference($wb, $intake)
    {
        if ($wb == 0 && $intake == 0) {
            $percentChange = 0;
        }

        if (($wb == 0 and $intake != 0) or ($wb != 0 and $intake == 0)) {
            $percentChange = 100;
        }

        if ($wb != 0 and $intake != 0) {
            try {

                $diff = $intake - $wb;
                $sum = ($wb + $intake) / 2;
                $percentChange = (($diff) / ($sum)) * 100;
            } catch (\Throwable $th) {
                //throw $th;
                // dd($th->getMessage());
                $percentChange = 0;
            }
        }
        return $percentChange;
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
            // ->where("end_date_actual", ">=",  $date  . '125900')
            ->where("end_date_actual", "<=",  $datebefore  . '235900')
            ->first();

        // Hitung nilai akumulasi Sender dari file wincos sesuai storage 
        $sender = DB::table('trf')
            ->select(DB::raw("sum(qty) 
            "))
            ->where('sender', $code)
            // ->where("end_date_actual", ">=",  $date_from  . ' :00:00:00')
            // ->where("datetime", "<=",  $date_to  . ' : 23:59:59')
            ->where("end_date_actual", "<=",  $datebefore  . '235900')
            ->first();
        // $receive = DB::table('trf')
        //     ->select(DB::raw("sum(qty) 
        //     "))
        //     ->where('receive', $code)
        //     // ->where("datetime", ">=",  $date_from  . ' :00:00:00')
        //     // ->where("datetime", "<=",  $date_to  . ' : 23:59:59')
        //     ->first();

        // $sender = DB::table('trf')
        //     ->select(DB::raw("sum(qty) 
        //     "))
        //     ->where('sender', $code)
        //     // ->where("datetime", ">=",  $date_from  . ' :00:00:00')
        //     // ->where("datetime", "<=",  $date_to  . ' : 23:59:59')
        //     ->first();
        // $code = $code-500;
        $adjustments = \App\SiloAdjustmentErp::where('silo', $code)
            ->where('location' ,'like','%SILO%')
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

    private function sumWbHour($material, $date_from, $date_to,$timein,$timeout)
    {

        if (env('DB_WB') == 'SQLSERVER') {
            $count =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            select sum(a.nett) as sum
            from(
            select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
            from wbfile a
            where a.statusax = 'Y' and a.flag = 'Y'
            ) a WHERE itemno  IN ($material ) and dateout >= '$date_from' and dateout <= '$date_to' ");
            // ) a WHERE itemno  IN ($material ) and dateout >= '$date_from' and dateout <= '$date_to' and timeout >= '$timein' and timeout <= '$timeout' ");
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

    private function sumWb($material, $date_from, $date_to)
    {

        if (env('DB_WB') == 'SQLSERVER') {
            $count =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            select sum(a.nett) as sum
            from(
            select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
            from wbfile a
            where a.statusax = 'Y' and a.flag = 'Y'
            ) a WHERE itemno  IN ($material ) and dateout >= '$date_from' and dateout <= '$date_to'");
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

        // if (env('DB_WB') == 'SQLSERVER') {
        //     $count =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
        //     select sum(a.nett) as sum
        //     from(
        //     select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett, b.jumlah_bag,
        //     case when  b.jumlah_bag >=1 and   b.jumlah_bag<=19 then 0
        //     when  b.jumlah_bag >=1 and   b.jumlah_bag<=19 then 0
        //     when  b.jumlah_bag >=20 and   b.jumlah_bag<=80 then 10
        //     when  b.jumlah_bag >=81 and   b.jumlah_bag<=150 then 20
        //     when  b.jumlah_bag >=151 and   b.jumlah_bag<=230 then 30
        //     when  b.jumlah_bag >=231 and   b.jumlah_bag<=300 then 40
        //     when  b.jumlah_bag >=301 and   b.jumlah_bag<=400 then 50
        //     when  b.jumlah_bag >=401 and   b.jumlah_bag<=460 then 60
        //     when  b.jumlah_bag >=461 and   b.jumlah_bag<=540 then 70
        //     when  b.jumlah_bag >=541 and   b.jumlah_bag<=699 then 80
        //     when  b.jumlah_bag >=700 and   b.jumlah_bag<=1000 then 80
        //     else 0 end as 'potongan'
        //     from wbfile a, t_barcode b
        //     where a.barcode = b.barcode and a.statusax = 'Y' and a.flag = 'Y'
        //     ) a WHERE itemno  IN ($material ) and datein >= '$date_from' and dateout <= '$date_to'");
        //     return $count[0]->sum;
        // }else{
        //     $count = DB::table('feedmills')
        //         ->select(DB::raw("sum(nett) 
        //     "))
        //         ->where(
        //             function ($query) use ($material) {
        //                 for ($i = 0; $i < count($material); $i++) {
        //                     $query->orwhere('itemno', 'like',  '%' . $material[$i] . '%');
        //                 }
        //             }
        //         )
        //         ->where("datein", ">=",  $date_from  . 'T00:00:00.000+00:0')
        //         ->where("dateout", "<=",  $date_to  . 'T99:99:99.999+99:99')
        //         ->first();
        //     return $count->sum;
        // }
    }

    private function checkSetting($storage, $valueDashboard)
    {
        $settingMan = \App\SiloActual::where('storage_code', $storage)
            ->orderby('date', 'desc')
            ->first();

        if($settingMan){
            $settingMan = $settingMan->value_actual;
        }else{
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

        if ($diff < 0) {
            $alarm = \App\SiloAlarm::where('storage_code', $storage)
                // ->where('range_min', '<=', abs($diff))
                // ->where('range_max', '>=', abs($diff))
                // ->where('formula', '-')
                ->first();
        } else {
            $alarm = \App\SiloAlarm::where('storage_code', $storage)
                // ->where('range_min', '<=', $diff)
                // ->where('range_max', '>=', $diff)
                // ->where('formula', '+')
                ->first();
        }
        if ($alarm) {
            if ($alarm->formula == '>') {
                if ($diff > $alarm->range_max) {
                    return 'gt';
                } else {
                    return 'nm';
                }
            } else {
                if ($diff < $alarm->range_max && $diff > 0) {
                    return 'lt';
                } else {
                    return 'nm';
                }
            }
        } else {
            return '';
        }
    }

    private function isFloor($date_from, $date_to)
    {
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $data_floor =
            DB::table('trf')
            ->select('receiver_product_ident', 'file_name')
            // ->where("type", "LIKE", '%INT%')
            ->where("file_name", "MANUAL_FLOOR")
            // ->orwhere('type',  "LIKE", '%INT2%')
            ->where("end_date_actual", ">=",  $date_from  . '000000')
            ->where("end_date_actual", "<=",  $date_to  . '235959')
            ->get();

        $corn = config('global.materials.corn');
        $soya = config('global.materials.soya');
        $wheat = config('global.materials.wheat');
        $isFloor['corn'] = $this->isFloorMaterial($data_floor, $corn, 'corn');
        $isFloor['soya'] = $this->isFloorMaterial($data_floor, $soya, 'soya');
        $isFloor['wheat'] = $this->isFloorMaterial($data_floor, $wheat, 'wheat');
        return $isFloor;
    }

    private function isFloorMaterial($data_floors, $materials, $mname)
    {
        foreach ($data_floors as $data_floor) {
            $productident = explode("*", $data_floor->receiver_product_ident);
            if (in_array($productident[0], $materials, TRUE)) {
                return $data_floor->receiver_product_ident;
            }
        }
    }
}
