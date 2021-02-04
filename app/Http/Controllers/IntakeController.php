<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trf;
use Illuminate\Support\Facades\DB;

class IntakeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:IntakeView', ['only' => 'index']);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Intake';
        $data['process'] = 'Intake';

        $date_from = date('Y-m-d');
        $date_to = date('Y-m-d');
        // summary
        // -- corn
        $date_from  = $request->input('date_from')  ?: date('Y-m-d');
        $date_to    = $request->input('date_to') ?: date('Y-m-d');
        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $corn = config('global.materials.corn');
        $total_corn = $this->sumMaterial($corn, $date_from, $date_to);

        // -- soya

        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $soya = config('global.materials.soya');
        $total_soya = $this->sumMaterial($soya, $date_from, $date_to);


        // -- wheat

        $date_from = str_replace("-", "", $date_from);
        $date_to = str_replace("-", "", $date_to);
        $wheat = config('global.materials.wheat');
        $total_wheat = $this->sumMaterial($wheat, $date_from, $date_to);

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


        $data['intakes'] = Trf::where('type', 'like', '%INT%')
            // ->orwhere('type','INT2')
            ->where('receiver_product_ident', '!=', '123')
            // ->where('receiver_product_ident','!=','123456')
            ->where("end_date_actual", "LIKE", '%' . $date_month . '%')
            ->orderBy('job', 'asc')->get();


        $data['corn_total'] = number_format($total_corn->sum, 0, ',', '.');
        $data['soya_total'] = number_format($total_soya->sum, 0, ',', '.');
        $data['wheat_total'] = number_format($total_wheat->sum, 0, ',', '.');
        $data['is_floor'] = $this->isFloor($date_from, $date_to);
        return view('reports.intake.index', $data);
    }

    private function isFloor($date_from, $date_to)
    {
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

    private function sumMaterial($material, $date_from, $date_to)
    {
        return DB::table('trf')
            ->select(DB::raw("sum(qty)"))
            ->where("type", "LIKE", '%INT%')
            // ->orwhere('type',  "LIKE", '%INT2%')
            ->where('receiver_product_ident', '!=', '123')
            // ->where('receiver_product_ident', '!=', '123456')
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
    }

    public function create()
    {
        $data['page_title'] = 'Create Intake Floor';
        return view('reports.intake.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'job' => ['required'],
            'area' => ['required'],
            'receiver_production' => ['required'],
            'product_name' => ['required'],
            'qty' => ['required'],
            'start_date' => ['required'],
            'start_time' => ['required'],
            'end_date' => ['required'],
            'end_time' => ['required'],
            'sender' => ['required'],
            'receive' => ['required'],
        ]);

        $data['job'] = $request->input('job');
        $data['receiver_product_ident'] = $request->input('receiver_production');
        $data['product_name'] = $request->input('product_name');
        $data['qty'] = $request->input('qty');
        $data['start_date_actual'] = str_replace('-', '', $request->input('start_date')) . str_replace(':', '', $request->input('start_time')) . '00';
        $data['end_date_actual'] = str_replace('-', '', $request->input('end_date')) . str_replace(':', '', $request->input('end_time')) . '00';
        $data['datetime'] = date('Y-m-d H:i:s');
        $data['type'] = $request->input('area');
        $data['file_name'] = 'MANUAL_FLOOR';
        $data['sender'] = $request->input('sender');
        $data['receive'] = $request->input('receive');

        try {
            DB::beginTransaction();
            DB::table('trf')->insert($data);
            $data['sender_storage_ident_enumeration'] = '0';
            $data['receiver_storage_ident_enumeration'] = '0';
            \App\TempTrf::insert($data);
            DB::commit();
            return redirect('report/intake')->with(['create' => 'Data saved successfully!']);
        } catch (\Exception $e) {
            DB::rollback();
             dd($e->getMessage());
            return redirect('report/intake/create')->with(['create' => $th->getMessage()]);
        }
        
    }
}
