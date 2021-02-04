<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TempTrf;
use App\CloudTrf;
use Illuminate\Support\Facades\DB;
class ApiTrfController extends Controller
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


        $temp_trf = TempTrf::get()->toarray();
        $data_temporary_insert = array_map(function ($tmp) {
            unset($tmp['id']);
            return $tmp;
        }, $temp_trf);

        if ($temp_trf) {
            try {
                DB::beginTransaction();
                    // MASUKKAN DATA TEMPORARY KE WB UTAMA
                    CloudTrf::insert($data_temporary_insert);
                    // KOSONGKAN DATA TEMPORARY
                    TempTrf::truncate();
                    // array_push($inserted_data, 'Temporary Insert');
                    $msg = 'Temporary Insert';
                    array_push($inserted_data, 'Temporary Insert');
                DB::commit();
            } catch (\Exception $e) {
                $msg = 'Fail Temporary Insert';
                DB::rollback();
            }
            
        }else{
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
