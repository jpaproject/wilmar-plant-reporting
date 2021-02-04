<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelletMillController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:PelletView', ['only' => 'index']);
        $this->middleware('privilege:PelletTrendView', ['only' => 'trend']);
    }


    public function index(Request $request)

    {
        $data['page_title'] = "Pellet Mill";
        $data['process'] = "Pellet Mill";

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
        if ($request->input('period') == 'month') {
            $data['pakan_pm1'] = '-';
            $data['pakan_pm2'] = '-';
            $data['pakan_pm3'] = '-';
            $data['pakan_pm4'] = '-';

        } else {
            $data['pakan_pm1'] = substr($this->getPakan($date_month,'PET1'), 0, 4);
            $data['pakan_pm2'] = substr($this->getPakan($date_month,'PET2'), 0, 4);
            $data['pakan_pm3'] = substr($this->getPakan($date_month,'PET3'), 0, 4);
            $data['pakan_pm4'] = substr($this->getPakan($date_month,'PET4'), 0, 4);
        }
        

        // DASHBOARD PELLET
        $data['data_akumulasi_pm1'] = $this->akumulasi_pm($date_month,$first_date_month,$last_date_month,'PELLET MILL 1');
        $data['data_akumulasi_pm2'] = $this->akumulasi_pm($date_month,$first_date_month,$last_date_month,'PELLET MILL 2');
        $data['data_akumulasi_pm3'] = $this->akumulasi_pm($date_month,$first_date_month,$last_date_month,'PELLET MILL 3');
        $data['data_akumulasi_pm4'] = $this->akumulasi_pm($date_month,$first_date_month,$last_date_month,'PELLET MILL 4');
        $data_pms = DB::table('hp_mill')
            ->select(DB::raw("
            date_trunc('" . $daterange . "',tstamp)  AS datetime , 
            device as device,
            CASE when max(kwh_sys) - min(kwh_sys) < 0 
            then 0 
            else max(kwh_sys) - min(kwh_sys) 
            end as sys_kwh,
            max(kwh_motor)- min(kwh_motor) as motor_kwh,
            max(tonnage)- min(tonnage) as avg_tonnage,
            (max(kwh_sys)-min(kwh_sys)+max(kwh_motor)-min(kwh_motor))/(max(tonnage)- min(tonnage)) as kwh_ton
            "))
            // ->where("device", "LIKE", '%PELLET MILL%')
            ->whereIn('device', ['PELLET MILL 1', 'PELLET MILL 2', 'PELLET MILL 3', 'PELLET MILL 4'])
            ->whereBetween('tstamp', [$date_month  . $first_date_month . ' 00:00:00', $date_month  . $last_date_month . ' 23:59:59'])
            // ->where("tstamp", ">=",  $date_month  . $first_date_month.' 00:00:00')
            // ->where("tstamp", "<=",  $date_month  . $last_date_month.' 23:59:59')
            ->where("tonnage", ">", 0)
            ->where("kwh_motor", ">", 0)
            ->where("kwh_sys", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')
            ->get()
            ->toArray();
        



        $convert = array_map(function (Object $arr) {
            // work on each array in the list of arrays
            $arr->date_to = date("Y-m-d H:i:s", strtotime('+59 minutes +59 seconds', strtotime($arr->datetime)));
            $arr->material = $this->getMaterial($arr->datetime, $arr->date_to, $arr->device);
            // return the extended array

            return $arr;
        }, $data_pms);

        $data['data_pms'] = (object) $convert;





        $tstamp = [];
        $kwh_ton = [];
        $kwh = [];
        $ton = [];

        $pm1_kwhton = [];
        $pm2_kwhton = [];
        $pm3_kwhton = [];
        $pm4_kwhton = [];
        foreach ($data['data_pms'] as  $value) {
            array_push($tstamp, $value->datetime . ' (' . $value->device . ')');
            array_push($kwh_ton, $value->kwh_ton);
            // array_push($kwh_ton, ($value->sys_kwh + $value->motor_kwh) / ($value->avg_tonnage ?: 1));
            array_push($kwh, $value->sys_kwh);
            array_push($ton, $value->avg_tonnage);

            switch ($value->device) {
                case 'PELLET MILL 1':
                    array_push($pm1_kwhton, $value->kwh_ton);
                    break;
                case 'PELLET MILL 2':
                    array_push($pm2_kwhton, $value->kwh_ton);
                    break;
                case 'PELLET MILL 3':
                    array_push($pm3_kwhton, $value->kwh_ton);
                    break;
                case 'PELLET MILL 4':
                    array_push($pm4_kwhton, $value->kwh_ton);
                    break;
                default:
                    array_push($pm4_kwhton, $value->kwh_ton);
                    break;
            }
        }

        $data['pm1_avg_kwhton'] = $this->avgKwhTon($pm1_kwhton);
        $data['pm2_avg_kwhton'] = $this->avgKwhTon($pm2_kwhton);
        $data['pm3_avg_kwhton'] = $this->avgKwhTon($pm3_kwhton);
        $data['pm4_avg_kwhton'] = $this->avgKwhTon($pm4_kwhton);
        

        $data['pm1_kwh_ton'] = $this->chechProduksi($this->selectKwhTon($data['pm1_avg_kwhton'], $data['data_akumulasi_pm1']->kwh_ton ?? 0),$data['data_akumulasi_pm1']->motor_kwh??0);
        $data['pm2_kwh_ton'] = $this->chechProduksi($this->selectKwhTon($data['pm2_avg_kwhton'], $data['data_akumulasi_pm2']->kwh_ton ?? 0),$data['data_akumulasi_pm2']->motor_kwh??0);
        $data['pm3_kwh_ton'] = $this->chechProduksi($this->selectKwhTon($data['pm3_avg_kwhton'], $data['data_akumulasi_pm3']->kwh_ton ?? 0),$data['data_akumulasi_pm3']->motor_kwh??0);
        $data['pm4_kwh_ton'] = $this->chechProduksi($this->selectKwhTon($data['pm4_avg_kwhton'], $data['data_akumulasi_pm4']->kwh_ton ?? 0),$data['data_akumulasi_pm4']->motor_kwh??0);

        

       
        $dataChart = [
            'tstamp' => $tstamp,
            'kwh_ton' => $kwh_ton,
            'kwh' => $kwh,
            'ton' => $ton,
        ];
        $data['data_chart'] = $dataChart;
        return view('reports/pellet-mill/index', $data);
    }


    private function chechProduksi($kwh_ton,$kwh){
        if($kwh > 0){
            return $kwh_ton;
        }else{
            return 0;
        }
    }

    private function selectKwhTon($avg,$real){
        if($real < 5){
            return $avg;
        }else{
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
            ->orderBy("start_date_actual", 'desc')
            ->first();
        if ($data) {
            return  $data->receiver_product_ident;
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
                    if ($key == 'wheat') {
                        $key = 'BBPT';
                    }
                    return strtoupper($key);
                }
            }
        }
        return false;
    }

    private function akumulasi_pm($date_month, $first_date_month, $last_date_month, $data_pm)
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
            ->where("device", $data_pm)
            ->where("tstamp", ">=",  $date_month .  $first_date_month.' 00:00:00')
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
        $nullData = (object) array(
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
        $data['page_title'] = 'Pellet Mill Trend';
        $data['process'] = 'Pellet Mill';
        // $date = '2020-06-18';
        $date_from  = $request->input('date_from')  ?: date('Y-m-d');
        $date_to    = $request->input('date_to') ?: date('Y-m-d');
        // Pellet Mill 1
        $data_pm1 = DB::table('hp_mill')
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
            ->where('device', 'PELLET MILL 1')
            ->where("tstamp", ">=",  $date_from  . ' :00:00:00')
            ->where("tstamp", "<=",  $date_to  . ' : 23:59:59')
            // ->where("tonnage", ">", 100)
            ->where("kwh_motor", ">", 0)
            ->where("kwh_sys", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')
            ->get();
        $tstamp_pm1 = [];
        $data_tonnage_pm1 = [];
        $data_system_kwh_pm1 = [];
        $data_motor_kwh_pm1 = [];
        $data_current_pm1 = [];
        $data_current_motor_pm1 = [];
        $data_voltage_pm1 = [];
        $data_kwh_ton_pm1 = [];

        foreach ($data_pm1 as $pm1) {
            array_push($tstamp_pm1, date('H:i', strtotime($pm1->datetime)));
            array_push($data_tonnage_pm1, $pm1->avg_tonnage);
            array_push($data_system_kwh_pm1, $pm1->sys_kwh + $pm1->motor_kwh);
            array_push($data_motor_kwh_pm1, $pm1->motor_kwh);
            array_push($data_current_pm1, $pm1->avg_current + $pm1->avg_current_motor);
            array_push($data_current_motor_pm1, $pm1->avg_current_motor);
            array_push($data_voltage_pm1, $pm1->avg_voltage);
            array_push($data_kwh_ton_pm1, (($pm1->kwh_ton) <= 0 ? 1 : $pm1->kwh_ton));
        }
        $data['pm1'] = [
            'tstamp' => $tstamp_pm1,
            'tonnage' => $data_tonnage_pm1,
            'kwh_sys' => $data_system_kwh_pm1,
            'kwh_motor' => $data_motor_kwh_pm1,
            'current' => $data_current_pm1,
            'current_motor' => $data_current_motor_pm1,
            'voltage' => $data_voltage_pm1,
            'kwh_ton' => $data_kwh_ton_pm1,
        ];


        // Pellet Mill 2
        $data_pm2 = DB::table('hp_mill')
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
            ->where('device', 'PELLET MILL 2')
            ->where("tstamp", ">=",  $date_from  . ' :00:00:00')
            ->where("tstamp", "<=",  $date_to  . ' : 23:59:59')
            ->where("tonnage", ">", 0)
            ->where("kwh_motor", ">", 0)
            ->where("kwh_sys", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')
            ->get();
        $tstamp_pm2 = [];
        $data_tonnage_pm2 = [];
        $data_system_kwh_pm2 = [];
        $data_motor_kwh_pm2 = [];
        $data_current_pm2 = [];
        $data_current_motor_pm2 = [];
        $data_voltage_pm2 = [];
        $data_kwh_ton_pm2 = [];


        foreach ($data_pm2 as $pm2) {
            array_push($tstamp_pm2, $pm2->datetime);
            array_push($data_tonnage_pm2, $pm2->avg_tonnage);
            array_push($data_system_kwh_pm2, $pm2->sys_kwh + $pm2->motor_kwh);
            array_push($data_motor_kwh_pm2, $pm2->motor_kwh);
            array_push($data_current_pm2, $pm2->avg_current + $pm2->avg_current_motor);
            array_push($data_current_motor_pm2, $pm2->avg_current_motor);
            array_push($data_voltage_pm2, $pm2->avg_voltage);
            array_push($data_kwh_ton_pm2, (($pm2->kwh_ton) <= 0 ? 1 : $pm2->kwh_ton));
        }
        $data['pm2'] = [
            'tstamp' => $tstamp_pm2,
            'tonnage' => $data_tonnage_pm2,
            'kwh_sys' => $data_system_kwh_pm2,
            'kwh_motor' => $data_motor_kwh_pm2,
            'current' => $data_current_pm2,
            'current_motor' => $data_current_motor_pm2,
            'voltage' => $data_voltage_pm2,
            'kwh_ton' => $data_kwh_ton_pm2,
        ];


        // Pellet Mill 3
        $data_pm3 = DB::table('hp_mill')
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
            ->where('device', 'PELLET MILL 3')
            ->where("tstamp", ">=",  $date_from  . ' :00:00:00')
            ->where("tstamp", "<=",  $date_to  . ' : 23:59:59')
            ->where("tonnage", ">", 0)
            ->where("kwh_motor", ">", 0)
            ->where("kwh_sys", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')
            ->get();
        $tstamp_pm3 = [];
        $data_tonnage_pm3 = [];
        $data_system_kwh_pm3 = [];
        $data_motor_kwh_pm3 = [];
        $data_current_pm3 = [];
        $data_current_motor_pm3 = [];
        $data_voltage_pm3 = [];
        $data_kwh_ton_pm3 = [];
        foreach ($data_pm3 as $pm3) {
            array_push($tstamp_pm3, $pm3->datetime);
            array_push($data_tonnage_pm3, $pm3->avg_tonnage);
            array_push($data_system_kwh_pm3, $pm3->sys_kwh + $pm3->motor_kwh);
            array_push($data_motor_kwh_pm3, $pm3->motor_kwh);
            array_push($data_current_pm3, $pm3->avg_current + $pm3->avg_current_motor);
            array_push($data_current_motor_pm3, $pm3->avg_current_motor);
            array_push($data_voltage_pm3, $pm3->avg_voltage);
            array_push($data_kwh_ton_pm3, (($pm3->kwh_ton) <= 0 ? 1 : $pm3->kwh_ton));
        }
        $data['pm3'] = [
            'tstamp' => $tstamp_pm3,
            'tonnage' => $data_tonnage_pm3,
            'kwh_sys' => $data_system_kwh_pm3,
            'kwh_motor' => $data_motor_kwh_pm3,
            'current' => $data_current_pm3,
            'current_motor' => $data_current_motor_pm3,
            'voltage' => $data_voltage_pm3,
            'kwh_ton' => $data_kwh_ton_pm3,
        ];

        // Pellet Mill 4
        $data_pm4 = DB::table('hp_mill')
            ->select(DB::raw("
            date_trunc('minute',tstamp)  AS datetime , 
             device as device, 
            ROUND(max(tonnage)- min(tonnage),3) as avg_tonnage, 
            CASE when max(kwh_sys) - min(kwh_sys) < 0 
            then 0 
            else max(kwh_sys) - min(kwh_sys) 
            end as sys_kwh, 
            ROUND(CAST( max(kwh_motor) - min(kwh_motor) as numeric),3) as motor_kwh, 
            CASE when max(tonnage)- min(tonnage)< 0.1 
            then 0 
            else ROUND(CAST((max(kwh_sys)-min(kwh_sys)+max(kwh_motor)-min(kwh_motor))/ ROUND(CAST( (max(tonnage)- min(tonnage)) as numeric),5) as numeric),3) 
            end as kwh_ton, 
            ROUND(CAST(avg(current) as numeric ),3) as avg_current, 
            ROUND(CAST(avg(current_motor)as numeric ),3) as avg_current_motor, 
            ROUND(CAST(avg(voltage) as numeric ),3) as avg_voltage 
            "))
            ->where('device', 'PELLET MILL 4')
            ->where("tstamp", ">=",  $date_from  . ' :00:00:00')
            ->where("tstamp", "<=",  $date_to  . ' : 23:59:59')
            ->where("tonnage", ">", 0)
            ->where("kwh_motor", ">", 0)
            // ->where("kwh_sys", ">", 0)
            ->groupBy('datetime', 'device')
            ->orderBy('datetime', 'asc')
            ->get();
        $tstamp_pm4 = [];
        $data_tonnage_pm4 = [];
        $data_system_kwh_pm4 = [];
        $data_motor_kwh_pm4 = [];
        $data_current_pm4 = [];
        $data_current_motor_pm4 = [];
        $data_voltage_pm4 = [];
        $data_kwh_ton_pm4 = [];

        foreach ($data_pm4 as $pm4) {
            array_push($tstamp_pm4, $pm4->datetime);
            array_push($data_tonnage_pm4, $pm4->avg_tonnage);
            array_push($data_system_kwh_pm4, $pm4->sys_kwh + $pm4->motor_kwh);
            array_push($data_motor_kwh_pm4, $pm4->motor_kwh);
            array_push($data_current_pm4, $pm4->avg_current + ($pm4->avg_current_motor / 1000));
            array_push($data_current_motor_pm4, $pm4->avg_current_motor / 1000);
            array_push($data_voltage_pm4, $pm4->avg_voltage);
            array_push($data_kwh_ton_pm4, (($pm4->kwh_ton) <= 0 ? 1 : $pm4->kwh_ton));
        }
        $data['pm4'] = [
            'tstamp' => $tstamp_pm4,
            'tonnage' => $data_tonnage_pm4,
            'kwh_sys' => $data_system_kwh_pm4,
            'kwh_motor' => $data_motor_kwh_pm4,
            'current' => $data_current_pm4,
            'current_motor' => $data_current_motor_pm4,
            'voltage' => $data_voltage_pm4,
            'kwh_ton' => $data_kwh_ton_pm4,
        ];





        return view('reports/pellet-mill/trend', $data);
    }
}
