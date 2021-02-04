<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TempAdjustment;
use App\CloudAdjustment;
use Illuminate\Support\Facades\DB;
class ApiAdjustmentController extends Controller
{
    public function index(Request $request)
    {

        if ($request->input('date'))
            $date_month = $request->input('date');
        else
            $date_month = date('Y-m-d');


        $inserted_data = [];
        $duplicate_data = [];
        $temporary_data = [];


        $temp_trf = TempAdjustment::take(50)->orderby('id', 'asc')->get()->toarray();
        $temp_id = [];
        $data_temporary_insert = array_map(function ($tmp) use (&$temp_id) {
            array_push($temp_id, $tmp['id']);
            unset($tmp['id']);
            return $tmp;
        }, $temp_trf);
        if ($temp_trf) {
            try {
                DB::beginTransaction();
                // MASUKKAN DATA TEMPORARY KE WB UTAMA
                CloudAdjustment::insert($data_temporary_insert);
                // KOSONGKAN DATA TEMPORARY
                DB::table('temp_silo_adjustments')
                    ->whereIn('id',  $temp_id)
                    ->delete();
                // array_push($inserted_data, 'Temporary Insert');
                $msg = 'Temporary Insert';
                array_push($inserted_data, 'Temporary Insert');
                DB::commit();
            } catch (\Exception $e) {
                $msg = 'Fail Temporary Insert '. $e;
                DB::rollback();
            }
        } else {
            $msg = 'No Data';
        }

        $response['duplicate'] = $duplicate_data;
        $response['inserted'] = $inserted_data;
        $response['temporary'] = $temporary_data;
        $response['msg'] = $msg;
        $response['date'] = date('Y-m-d');
        $response['datetime'] = date('YmdHis');
        $response['data'] = $temp_trf;
        return response()->json($response);
    }
}
