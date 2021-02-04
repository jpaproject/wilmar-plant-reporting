<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TempHpMaterial;
use Illuminate\Support\Facades\DB;
use App\CloudHpMaterial;
class ApiHpMaterialController extends Controller
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

      

        $temp = TempHpMaterial::get()->toarray();
        
        
        $data_temporary_insert = array_map(function ($tmp) {
            unset($tmp['id']);
            return $tmp;
        }, $temp);
        if ($data_temporary_insert) {
            try {
                DB::beginTransaction();
                // MASUKKAN DATA TEMPORARY KE WB UTAMA
                CloudHpMaterial::insert($data_temporary_insert);
                // KOSONGKAN DATA TEMPORARY
                TempHpMaterial::truncate();
                // array_push($inserted_data, 'Temporary Insert');
                $msg = 'Temporary Insert';
                array_push($inserted_data, 'Temporary Insert');
                DB::commit();
            } catch (\Exception $e) {
                $msg = 'Fail Temporary Insert' . $e->getMessage();
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
        $response['data'] = $temp;
        return response()->json($response);
    }
}
