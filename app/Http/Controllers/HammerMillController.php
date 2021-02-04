<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hp_mill;
use Illuminate\Support\Facades\DB;

class HammerMillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['rawPakan']);
        $this->middleware('privilege:HammerMillView', ['only' => 'index']);
        $this->middleware('privilege:HammerMillTrendView', ['only' => 'trend']);
    }

   

    public function index(Request $request)
    {
        $data['page_title'] = 'Hammer Mill';
        $data['process'] = 'Hammer Mill';

        if ($request->input('period') == 'day') {
            $daterange = 'hour';
            $date_month = $request->input('date');
            $first_date_month = '';
            $last_date_month = '';
        } elseif ($request->input('period') == 'month') {
            $daterange = 'day';
            $date_month = $request->input('month');
            $first_date_month = '-01';
            $last_date_month =  date("-t", strtotime($request->input('month')));
        } else {
            $daterange = 'hour';
            $date_month = date('Y-m-d');
            $first_date_month = '';
            $last_date_month = '';
        }


        // PAKAN
        $data['pakan_hm1'] = $this->getPakan($date_month, 'GRD1');
        $data['pakan_hm2'] = $this->getPakan($date_month, 'GRD2');
        $data['pakan_hm3'] = $this->getPakan($date_month, 'GRD3');
        if($data['pakan_hm1'] == 'WHEAT'){
            $data['pakan_hm1'] = 'BBPT';
        }else{
            $data['pakan_hm1'] = $this->getPakan($date_month, 'GRD1');
        }
        if ($data['pakan_hm2'] == 'WHEAT') {
            $data['pakan_hm2'] = 'BBPT';
        } else {
            $data['pakan_hm2'] = $this->getPakan($date_month, 'GRD2');
        }
        if ($data['pakan_hm3'] == 'WHEAT') {
            $data['pakan_hm3'] = 'BBPT';
        } else {
            $data['pakan_hm3'] = $this->getPakan($date_month, 'GRD3');
        }

        // DASHBOARD HAMMER
        $data['data_akumulasi_hm1'] = $this->akumulasi_hm($date_month,$first_date_month,$last_date_month, 'HAMMER MILL 1');

        $data['data_akumulasi_hm2'] = $this->akumulasi_hm($date_month,$first_date_month,$last_date_month, 'HAMMER MILL 2');
        $data['data_akumulasi_hm3'] = $this->akumulasi_hm($date_month,$first_date_month,$last_date_month, 'HAMMER MILL 3');

        $data_hms = DB::table('hp_mill')
            ->select(DB::raw("
            date_trunc('" . $daterange . "',tstamp)  AS datetime , 
            device as device,
            max(kwh_sys)-min(kwh_sys) as sys_kwh,
            max(kwh_motor)- min(kwh_motor) as motor_kwh,
            max(tonnage)- min(tonnage) as avg_tonnage,
            CASE when max(tonnage)- min(tonnage)<0.1 then 0
             else (max(kwh_sys)-min(kwh_sys)+max(kwh_motor)-min(kwh_motor))/ (max(tonnage)- min(tonnage) ) 
             end as kwh_ton,
            avg(current) as avg_current
            "))
            ->whereIn('device', ['HAMMER MILL 1', 'HAMMER MILL 2', 'HAMMER MILL 3'])
            ->whereBetween('tstamp', [$date_month  . $first_date_month . ' 00:00:00', $date_month  . $last_date_month . ' 23:59:59'])
            // ->where("tstamp", ">=",  $date_month .' 00:00:00')
            // ->where("tstamp", "<=",  $date_month .' 23:59:59')
            ->where("tonnage", ">", 0)
            ->where("kwh_motor", ">", 0)
            ->where("kwh_sys", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'desc')
            ->get()
            ->toArray();


        $convert = array_map(function (Object $arr) {
            // work on each array in the list of arrays
            $arr->date_to = date("Y-m-d H:i:s", strtotime('+59 minutes +59 seconds', strtotime($arr->datetime)));
            $arr->material = $this->getMaterial($arr->datetime, $arr->date_to, $arr->device);
            // return the extended array
            return $arr;
        }, $data_hms);

        $data['data_hms'] = (object) $convert;


        $tstamp = [];
        $kwh_ton = [];
        $kwh = [];
        $ton = [];

        $hm1_kwhton = [];
        $hm2_kwhton = [];
        $hm3_kwhton = [];
        
        foreach ($data['data_hms'] as  $value) {
            array_push($tstamp, $value->datetime . ' (' . $value->device . ')');
            array_push($kwh_ton, (($value->kwh_ton > 0) ?: 1));
            array_push($kwh, $value->sys_kwh);
            array_push($ton, $value->avg_tonnage);

            switch ($value->device) {
                case 'HAMMER MILL 1':
                    array_push($hm1_kwhton, $value->kwh_ton);
                    break;
                case 'HAMMER MILL 2':
                    array_push($hm2_kwhton, $value->kwh_ton);
                    break;
                case 'HAMMER MILL 3':
                    array_push($hm3_kwhton, $value->kwh_ton);
                    break;
                default:
                    array_push($hm3_kwhton, $value->kwh_ton);
                    break;
            }
        }

        $dataChart = [
            'tstamp' => $tstamp,
            'kwh_ton' => $kwh_ton,
            'kwh' => $kwh,
            'ton' => $ton,
        ];



        $data['hm1_avg_kwhton'] = $this->avgKwhTon($hm1_kwhton);
        $data['hm2_avg_kwhton'] = $this->avgKwhTon($hm2_kwhton);
        $data['hm3_avg_kwhton'] = $this->avgKwhTon($hm3_kwhton);


        $data['hm1_kwh_ton'] = $this->chechProduksi($this->selectKwhTon($data['hm1_avg_kwhton'], $data['data_akumulasi_hm1']->kwh_ton ?? 0),$data['data_akumulasi_hm1']->motor_kwh ?? 0);
        $data['hm2_kwh_ton'] = $this->chechProduksi($this->selectKwhTon($data['hm2_avg_kwhton'], $data['data_akumulasi_hm2']->kwh_ton ?? 0),$data['data_akumulasi_hm2']->motor_kwh ?? 0);
        $data['hm3_kwh_ton'] = $this->chechProduksi($this->selectKwhTon($data['hm3_avg_kwhton'], $data['data_akumulasi_hm3']->kwh_ton ?? 0),$data['data_akumulasi_hm3']->motor_kwh ?? 0);


        $data['data_chart'] = $dataChart;


        // $data['data_summary_hms'] = DB::table('hp_mill')
        // ->select(DB::raw("sum(tonnage) as total_tonnage"))
        // ->where("tstamp", "LIKE", '%' . $date_month . '%')

        //     ->orderBy('tstamp', 'asc')
        //     ->get(); 


        // dd($data['data_akumulasi_hm1']);

        return view('reports/hammer-mill/index', $data);
    }

    private function chechProduksi($kwh_ton, $kwh)
    {
        if ($kwh > 0) {
            return $kwh_ton;
        } else {

            return 0;
        }
    }

    private function selectKwhTon($avg, $real)
    {
        if ($real < 5) {
            return $avg;
        } else {
            return $real;
        }
    }
    private function avgKwhTon($a)
    {
        if (count($a)) {
            return $average = array_sum($a) / count($a);
        }
    }


    private function getMaterial($date_from, $date_to, $device)
    {
        $type = explode(" ", $device);
        if ($type[0] == 'PELLET') {
            $device_type = 'PET' . $type[2];
        } else {
            $device_type = 'GRD' . $type[2];
        }

        $data = DB::table('hp_materials')
            ->select("receiver_product_ident", "product_name")
            ->whereBetween('start_date_actual', [$date_from, $date_to])
            ->where("type", $device_type)
            ->orWhereBetween('end_date_actual', [$date_from, $date_to])
            ->where("type", $device_type)
            ->orderBy('id', 'desc')
            ->first();
        if ($data) {
            return $data->receiver_product_ident . ' : ' . $this->materialName($data->receiver_product_ident);
        } else {
            return '-';
        }
    }


    private function getPakan($date_month, $device_type)
    {
        $data = DB::table('hp_materials')
            ->select("receiver_product_ident", "product_name")
            ->where('start_date_actual', 'LIKE', '%' . $date_month . '%')
            ->where("type", $device_type)
            ->where("sender", '00010101000000')
            ->orderBy('start_date_actual','desc')
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
        foreach (config('global.materials') as $key => $value) {
            foreach ($value as $sKey) {
                if (stripos($code, $sKey) !== false) {
                    if($key == 'wheat'){
                        $key = 'BBPT';
                    }
                    return strtoupper($key);
                }
            }
        }
        return false;
    }

    private function akumulasi_hm($date_month, $first_date_month, $last_date_month,  $data_hm)
    {
        $data = DB::table('hp_mill')
            ->select(DB::raw("
            date_trunc('day',tstamp)  AS datetime , 
            device as device,
            CASE when max(kwh_sys) - min(kwh_sys) < 0 
            then 0 
            else max(kwh_sys) - min(kwh_sys) 
            end as sys_kwh,
            max(kwh_motor)- min(kwh_motor) as motor_kwh,
            max(tonnage)- min(tonnage) as akumulasi_tonnage,CASE when max(tonnage)- min(tonnage)< 0.1 
            then 0 
            else ROUND(CAST((max(kwh_sys)-min(kwh_sys)+max(kwh_motor)-min(kwh_motor))/ ROUND(CAST( (max(tonnage)- min(tonnage)) as numeric),5) as numeric),3) 
            end as kwh_ton, 
            avg(current) as avg_current
            "))
            ->where("device", $data_hm)
            ->where("tstamp", ">=",  $date_month .  $first_date_month . ' 00:00:00')
            ->where("tstamp", "<=",  $date_month . $last_date_month . ' 23:59:59')
            ->where("tonnage", ">", 0)
            ->where("kwh_motor", ">", 0)
            ->where("kwh_sys", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')
            ->first();

        if ($data) {

            return $data;
        }
        $nullData = (object)array(
            'sys_kwh' => 0,
            'motor_kwh' => 0,
            'akumulasi_tonnage' => 0,
            'kwh_ton' => 0,
            'avg_current' => 0,
        );
        return $nullData;
    }

    public function trend(Request $request)
    {
        $data['page_title'] = 'Hammer Mill Trend';
        $data['process'] = 'Hammer Mill';

        $date_from  = $request->input('date_from')  ?: date('Y-m-d');
        $date_to    = $request->input('date_to') ?: date('Y-m-d');
        // Hammer Mill 1
        $data_hm1 = DB::table('hp_mill')
            ->select(DB::raw("
            date_trunc('minute',tstamp)  AS datetime , 
            device as device, 
            ROUND(max(tonnage)- min(tonnage),3) as avg_tonnage, 
            max(kwh_sys) - min(kwh_sys) as sys_kwh, 
            ROUND(CAST( max(kwh_motor) - min(kwh_motor) as numeric),3) as motor_kwh, 
            CASE when max(tonnage)- min(tonnage)< 0.1 
            then 0 
            else ROUND(CAST((max(kwh_sys)-min(kwh_sys)+max(kwh_motor)-min(kwh_motor))/ ROUND(CAST( (max(tonnage)- min(tonnage)) as numeric),5) as numeric),3) 
            end as kwh_ton, 
            ROUND(CAST(avg(current) as numeric ),3) as avg_current, 
            ROUND(CAST(avg(current_motor)as numeric ),3) as avg_current_motor, 
            ROUND(CAST(avg(voltage) as numeric ),3) as avg_voltage 
            "))
            ->where('device', 'HAMMER MILL 1')
            ->where("tstamp", ">=",  $date_from  . ' :00:00:00')
            ->where("tstamp", "<=",  $date_to  . ' : 23:59:59')
            ->where("kwh_motor", ">", 0)
            // ->where("kwh_sys", ">", 0)
            // ->where("tonnage", ">", 0)
            // ->where("tonnage", ">", 100)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')
            ->get();
        $tstamp_hm1 = [];
        $data_tonnage_hm1 = [];
        $data_system_kwh_hm1 = [];
        $data_motor_kwh_hm1 = [];
        $data_current_hm1 = [];
        $data_current_motor_hm1 = [];
        $data_voltage_hm1 = [];
        $data_kwh_ton_hm1 = [];
        foreach ($data_hm1 as $hm1) {
            
            array_push($tstamp_hm1, date('H:i', strtotime($hm1->datetime)));
            array_push($data_tonnage_hm1, $hm1->avg_tonnage);
            array_push($data_system_kwh_hm1, $hm1->sys_kwh + $hm1->motor_kwh);
            array_push($data_motor_kwh_hm1, $hm1->motor_kwh);
            array_push($data_current_hm1, $hm1->avg_current + $hm1->avg_current_motor);
            array_push($data_current_motor_hm1, $hm1->avg_current_motor);
            array_push($data_voltage_hm1, $hm1->avg_voltage);
            array_push($data_kwh_ton_hm1, $hm1->kwh_ton);
            
            
        }
        // dd($data_hm1);

        $data['hm1'] = [
            'tstamp' => $tstamp_hm1,
            'tonnage' => $data_tonnage_hm1,
            'kwh_sys' => $data_system_kwh_hm1,
            'kwh_motor' => $data_motor_kwh_hm1,
            'current' => $data_current_hm1,
            'current_motor' => $data_current_motor_hm1,
            'voltage' => $data_voltage_hm1,
            'kwh_ton' => $data_kwh_ton_hm1,
        ];


        // Hammer Mill 2
        $data_hm2 = DB::table('hp_mill')
            ->select(DB::raw("
             date_trunc('minute',tstamp)  AS datetime , 
             device as device, 
            ROUND(max(tonnage)- min(tonnage),3) as avg_tonnage, 
            max(kwh_sys) - min(kwh_sys) as sys_kwh, 
            ROUND(CAST( max(kwh_motor) - min(kwh_motor) as numeric),3) as motor_kwh, 
            CASE when max(tonnage)- min(tonnage)< 0.1 
            then 0 
            else ROUND(CAST((max(kwh_sys)-min(kwh_sys)+max(kwh_motor)-min(kwh_motor))/ ROUND(CAST( (max(tonnage)- min(tonnage)) as numeric),5) as numeric),3) 
            end as kwh_ton, 
            ROUND(CAST(avg(current) as numeric ),3) as avg_current, 
            ROUND(CAST(avg(current_motor)as numeric ),3) as avg_current_motor, 
            ROUND(CAST(avg(voltage) as numeric ),3) as avg_voltage 

            "))
            ->where('device', 'HAMMER MILL 2')
            ->where("tstamp", ">=",  $date_from  . ' :00:00:00')
            ->where("tstamp", "<=",  $date_to  . ' : 23:59:59')
            ->where("kwh_motor", ">", 0)
            // ->where("kwh_sys", ">", 0)
            // ->where("tonnage", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')        
            ->get();
        $tstamp_hm2 = [];
        $data_tonnage_hm2 = [];
        $data_system_kwh_hm2 = [];
        $data_motor_kwh_hm2 = [];
        $data_current_hm2 = [];
        $data_current_motor_hm2 = [];
        $data_voltage_hm2 = [];
        $data_kwh_ton_hm2 = [];
        foreach ($data_hm2 as $hm2) {
            array_push($tstamp_hm2, $hm2->datetime);
            array_push($data_tonnage_hm2, $hm2->avg_tonnage);
            array_push($data_system_kwh_hm2, $hm2->sys_kwh + $hm2->motor_kwh);
            array_push($data_motor_kwh_hm2, $hm2->motor_kwh);
            array_push($data_current_hm2, $hm2->avg_current + $hm2->avg_current_motor);
            array_push($data_current_motor_hm2, $hm2->avg_current_motor);
            array_push($data_voltage_hm2, $hm2->avg_voltage);
            array_push($data_kwh_ton_hm2, $hm2->kwh_ton);
        }
        $data['hm2'] = [
            'tstamp' => $tstamp_hm2,
            'tonnage' => $data_tonnage_hm2,
            'kwh_sys' => $data_system_kwh_hm2,
            'kwh_motor' => $data_motor_kwh_hm2,
            'current' => $data_current_hm2,
            'current_motor' => $data_current_motor_hm2,
            'voltage' => $data_voltage_hm2,
            'kwh_ton' => $data_kwh_ton_hm2,
        ];


        // Hammer Mill 3
        $data_hm3 = DB::table('hp_mill')
            ->select(DB::raw("
             date_trunc('minute',tstamp)  AS datetime , 
             device as device, 
            ROUND(max(tonnage)- min(tonnage),3) as avg_tonnage, 
            max(kwh_sys) - min(kwh_sys) as sys_kwh, 
            ROUND(CAST( max(kwh_motor) - min(kwh_motor) as numeric),3) as motor_kwh, 
            CASE when max(tonnage)- min(tonnage)< 0.1 
            then 0 
            else ROUND(CAST((max(kwh_sys)-min(kwh_sys)+max(kwh_motor)-min(kwh_motor))/ ROUND(CAST( (max(tonnage)- min(tonnage)) as numeric),5) as numeric),3) 
            end as kwh_ton, 
            ROUND(CAST(avg(current) as numeric ),3) as avg_current, 
            ROUND(CAST(avg(current_motor)as numeric ),3) as avg_current_motor, 
            ROUND(CAST(avg(voltage) as numeric ),3) as avg_voltage 
            "))
            ->where('device', 'HAMMER MILL 3')
            ->where("tstamp", ">=",  $date_from  . ' :00:00:00')
            ->where("tstamp", "<=",  $date_to  . ' : 23:59:59')
            ->where("kwh_motor", ">", 0)
            // ->where("kwh_sys", ">", 0)
            // ->where("tonnage", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')
            ->get();
        $tstamp_hm3 = [];
        $data_tonnage_hm3 = [];
        $data_system_kwh_hm3 = [];
        $data_motor_kwh_hm3 = [];
        $data_current_hm3 = [];
        $data_current_motor_hm3 = [];
        $data_voltage_hm3 = [];
        $data_kwh_ton_hm3 = [];
        foreach ($data_hm3 as $hm3) {
            array_push($tstamp_hm3, $hm3->datetime);
            array_push($data_tonnage_hm3, $hm3->avg_tonnage);
            array_push($data_system_kwh_hm3, $hm3->sys_kwh + $hm3->motor_kwh);
            array_push($data_motor_kwh_hm3, $hm3->motor_kwh);
            array_push($data_current_hm3, $hm3->avg_current + $hm3->avg_current_motor);
            array_push($data_current_motor_hm3, $hm3->avg_current_motor);
            array_push($data_voltage_hm3, $hm3->avg_voltage);
            array_push($data_kwh_ton_hm3, $hm3->kwh_ton);
        }

        $data['hm3'] = [
            'tstamp' => $tstamp_hm3,
            'tonnage' => $data_tonnage_hm3,
            'kwh_sys' => $data_system_kwh_hm3,
            'kwh_motor' => $data_motor_kwh_hm3,
            'current' => $data_current_hm3,
            'current_motor' => $data_current_motor_hm3,
            'voltage' => $data_voltage_hm3,
            'kwh_ton' => $data_kwh_ton_hm3,

        ];

        // dd($data);
        return view('reports/hammer-mill/trend', $data);
    }


    public function rawPakan()
    {
        $date = date('Y-m-d');
        $hm1 = $this->valueWrite($this->getPakan($date,'GRD1'));
        $hm2 = $this->valueWrite($this->getPakan($date,'GRD2'));
        $hm3 = $this->valueWrite($this->getPakan($date,'GRD3'));
        return response()->json([
            'hm1' =>  $hm1,
            'hm2' =>  $hm2,
            'hm3' =>  $hm3,
        ]);
    }

    private function valueWrite($raw){
        switch ($raw) {
            case 'SOYA':
                return 1;
                break;
            case 'WHEAT':
                return 2;
                break;
            default:
                return 0;
                break;
        }
    }
}
