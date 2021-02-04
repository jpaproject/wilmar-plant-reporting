<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trf;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:TransferView', ['only' => 'index']);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Transfer';
        $data['process'] = 'Transfer';


        $date_from = date('Y-m-d');
        $date_to = date('Y-m-d');
        // summary
        // -- corn
        $date_from  = $request->input('date_from')  ?: date('Y-m-d');
        $date_to    = $request->input('date_to') ?: date('Y-m-d');
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $corn = config('global.materials.corn');
        $total_corn = DB::table('trf')
            ->select(DB::raw("sum(qty) 
            "))
            // ->orwhere("type", "LIKE", 'INT2%')
            ->where("receiver_product_ident", '123')
            ->where(
                function ($query) use ($corn) {
                    for ($i = 0; $i < count($corn); $i++) {
                        $query->orwhere('receiver_product_ident', 'like',  '%' . $corn[$i] . '%');
                    }
                }
            )
            ->where("end_date_actual", ">=",  $date_from  . '000000')
            ->where("end_date_actual", "<=",  $date_to  . '235959')
            ->orwhere("type", "LIKE", 'TRP%')
            ->where(
                function ($query) use ($corn) {
                    for ($i = 0; $i < count($corn); $i++) {
                        $query->orwhere('receiver_product_ident', 'like',  '%' . $corn[$i] . '%');
                    }
                }
            )
            ->where("end_date_actual", ">=",  $date_from  . '000000')
            ->where("end_date_actual", "<=",  $date_to  . '235959')
            ->first();

        // -- soya
        $date_from  = $request->input('date_from')  ?: date('Y-m-d');
        $date_to    = $request->input('date_to') ?: date('Y-m-d');
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $soya = config('global.materials.soya');
        $total_soya = DB::table('trf')
            ->select(DB::raw("sum(qty) 
            "))
            // ->where("type", "LIKE", 'TRP%')
            // ->orwhere("type", "LIKE", 'INT2%')
            ->where("receiver_product_ident", '123')
            ->where(
                function ($query) use ($soya) {
                    for ($i = 0; $i < count($soya); $i++) {
                        $query->orwhere('receiver_product_ident', 'like',  '%' . $soya[$i] . '%');
                    }
                }
            )
            ->where("end_date_actual", ">=",  $date_from  . '000000')
            ->where("end_date_actual", "<=",  $date_to  . '235959')

            ->orwhere("type", "LIKE", 'TRP%')
            ->where(
                function ($query) use ($soya) {
                    for ($i = 0; $i < count($soya); $i++) {
                        $query->orwhere('receiver_product_ident', 'like',  '%' . $soya[$i] . '%');
                    }
                }
            )
            ->where("end_date_actual", ">=",  $date_from  . '000000')
            ->where("end_date_actual", "<=",  $date_to  . '235959')
            ->first();


        // -- wheat
        $date_from  = $request->input('date_from')  ?: date('Y-m-d');
        $date_to    = $request->input('date_to') ?: date('Y-m-d');
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $wheat = config('global.materials.wheat');
        $total_wheat = DB::table('trf')
            ->select(DB::raw("sum(qty) 
            "))
            // ->where("type", "LIKE", 'TRP%')
            // ->orwhere("type", "LIKE", 'INT2%')
            ->where("receiver_product_ident", '123')
            ->where(
                function ($query) use ($wheat) {
                    for ($i = 0; $i < count($wheat); $i++) {
                        $query->orwhere('receiver_product_ident', 'like',  '%' . $wheat[$i] . '%');
                    }
                }
            )
            ->where("end_date_actual", ">=",  $date_from  . '000000')
            ->where("end_date_actual", "<=",  $date_to  . '235959')
            ->orwhere("type", "LIKE", 'TRP%')

            ->where(
                function ($query) use ($wheat) {
                    for ($i = 0; $i < count($wheat); $i++) {
                        $query->orwhere('receiver_product_ident', 'like',  '%' . $wheat[$i] . '%');
                    }
                }
            )
            ->where("end_date_actual", ">=",  $date_from  . '000000')
            ->where("end_date_actual", "<=",  $date_to  . '235959')
            ->first();

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
        $date_month = str_replace("-", "", $date_month);



        $data['transfers'] = Trf::where("receiver_product_ident", '123')
            ->where("end_date_actual", "LIKE", '%' . $date_month . '%')
            ->orwhere("type", "LIKE", 'TRP%')
            ->where("end_date_actual", "LIKE", '%' . $date_month . '%')
            ->orderBy('id', 'desc')->get();

        // $data['transfers'] = Trf::where('type', 'like', '%TRP%')
        //     ->orwhere("type", "LIKE", 'INT2%')
        //     ->where("receiver_product_ident", '123')
        //     ->where("end_date_actual", "LIKE", '%' . $date_month . '%')
        //     ->orderBy('id', 'desc')->get();




        $data['corn_total'] = number_format($total_corn->sum, 0, ',', '.');
        $data['soya_total'] = number_format($total_soya->sum, 0, ',', '.');
        $data['wheat_total'] = number_format($total_wheat->sum, 0, ',', '.');

        return view('reports.transfer.index', $data);
    }
}
