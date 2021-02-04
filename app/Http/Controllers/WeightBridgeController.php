<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Wbfile;
use Illuminate\Support\Facades\DB;

class WeightBridgeController extends Controller
{

    public function __construct()
    {
        setlocale(LC_CTYPE, 'en_US');

        $this->middleware('auth');
        $this->middleware('privilege:weightBridgeView', ['only' => 'index']);
    }


    public function index(Request $request)
    {



        $data['page_title'] = 'Weight Bridge';
        $data['process'] = 'Weight Bridge';

        if ($request->input('period') == 'day') {
            $date_month = $request->input('date');
        } elseif ($request->input('period') == 'month') {
            $date_month = $request->input('month');
        } else {
            $date_month = date('Y-m-d');
        }


        if (env('DB_WB') == 'SQLSERVER') {
            $corn = "'" . implode("','", config('global.materials.corn')) . "'";
            $soya = "'" . implode("','", config('global.materials.soya')) . "'";
            $wheat = "'" . implode("','", config('global.materials.wheat')) . "'";
            $all_material = $corn . ',' . $soya . ',' . $wheat;
            // $data['wbfiles'] =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            // select  a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett, a.jumlah_bag ,a.potongan, a.nett - a.potongan as 'nett_potong'
            // from(
            // select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett, b.jumlah_bag,
            // case when  b.jumlah_bag >=1 and   b.jumlah_bag<=19 then 0
            // when  b.jumlah_bag >=1 and   b.jumlah_bag<=19 then 0
            // when  b.jumlah_bag >=20 and   b.jumlah_bag<=80 then 10
            // when  b.jumlah_bag >=81 and   b.jumlah_bag<=150 then 20
            // when  b.jumlah_bag >=151 and   b.jumlah_bag<=230 then 30
            // when  b.jumlah_bag >=231 and   b.jumlah_bag<=300 then 40
            // when  b.jumlah_bag >=301 and   b.jumlah_bag<=400 then 50
            // when  b.jumlah_bag >=401 and   b.jumlah_bag<=460 then 60
            // when  b.jumlah_bag >=461 and   b.jumlah_bag<=540 then 70
            // when  b.jumlah_bag >=541 and   b.jumlah_bag<=699 then 80
            // when  b.jumlah_bag >=700 and   b.jumlah_bag<=1000 then 80
            // else 0 end as 'potongan'
            // from wbfile a, t_barcode b
            // where a.barcode = b.barcode and a.statusax = 'Y' and a.flag = 'Y'
            // ) a  WHERE itemno  IN ($all_material ) and  dateout like  '%$date_month%'");

            $data['wbfiles'] =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            select  a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
           
            from(
            select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
           
            from wbfile a
            where a.statusax = 'Y' and a.flag = 'Y'
            ) a  WHERE itemno  IN ($all_material ) and  dateout like  '%$date_month%'");
        } else {
            $corn = config('global.materials.corn');
            $soya = config('global.materials.soya');
            $wheat = config('global.materials.wheat');
            $all_material = array_merge($corn, $soya, $wheat);

            $data['wbfiles'] = Wbfile::Where(function ($query) use ($all_material) {
                for ($i = 0; $i < count($all_material); $i++) {
                    $query->orwhere('itemno', 'like',  '%' . $all_material[$i] . '%');
                }
            })
                ->where('dateout', 'like', '%' . $date_month . '%')
                ->get();
        }

        $data['corn_total'] = number_format($this->countMaterial($corn, $date_month), 0, ',', '.');
        $data['soya_total'] = number_format($this->countMaterial($soya, $date_month), 0, ',', '.');
        $data['wheat_total'] = number_format($this->countMaterial($wheat, $date_month), 0, ',', '.');




        return view('reports.weight-bridge.index', $data);
    }

    private function countMaterial($material, $date_month)
    {


        if (env('DB_WB') == 'SQLSERVER') {
            // $count =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            // select sum(a.nett) as sum
            // from(
            // select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett, b.jumlah_bag,
            // case when  b.jumlah_bag >=1 and   b.jumlah_bag<=19 then 0
            // when  b.jumlah_bag >=1 and   b.jumlah_bag<=19 then 0
            // when  b.jumlah_bag >=20 and   b.jumlah_bag<=80 then 10
            // when  b.jumlah_bag >=81 and   b.jumlah_bag<=150 then 20
            // when  b.jumlah_bag >=151 and   b.jumlah_bag<=230 then 30
            // when  b.jumlah_bag >=231 and   b.jumlah_bag<=300 then 40
            // when  b.jumlah_bag >=301 and   b.jumlah_bag<=400 then 50
            // when  b.jumlah_bag >=401 and   b.jumlah_bag<=460 then 60
            // when  b.jumlah_bag >=461 and   b.jumlah_bag<=540 then 70
            // when  b.jumlah_bag >=541 and   b.jumlah_bag<=699 then 80
            // when  b.jumlah_bag >=700 and   b.jumlah_bag<=1000 then 80
            // else 0 end as 'potongan'
            // from wbfile a, t_barcode b
            // where a.barcode = b.barcode and a.statusax = 'Y' and a.flag = 'Y'
            // ) a WHERE itemno  IN ($material) and dateout like  '%$date_month%'");

            $count =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            select sum(a.nett) as sum
            from(
            select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
            from wbfile a
            where a.statusax = 'Y' and a.flag = 'Y'
            ) a WHERE itemno  IN ($material) and dateout like  '%$date_month%'");

            return $count[0]->sum;
        } else {
            $count = DB::table('feedmills')
                ->select(DB::raw("sum(nett)"))
                ->where(
                    function ($query) use ($material) {
                        for ($i = 0; $i < count($material); $i++) {
                            $query->orwhere('itemno', 'like',  '%' . $material[$i] . '%');
                        }
                    }
                )
                ->where("end_tstamp", "like",  $date_month  . '%')
                ->first();
            return $count->sum;
        }
    }
}
