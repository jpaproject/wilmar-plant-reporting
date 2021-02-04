<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TempHpMill;
use App\CloudHpMill;
use Illuminate\Support\Facades\DB;
class ApiHpMillController extends Controller
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
       

        $temp_hp_mill = TempHpMill::take(8000)->orderby('id','asc')->get()->toarray();
        $temp_id = [];
        $data_temporary_insert = array_map(function ($tmp) use (&$temp_id) {
            array_push($temp_id, $tmp['id']);
            unset($tmp['id']);
            return $tmp;
        }, $temp_hp_mill);
        // dd($temp_id);
        if ($data_temporary_insert) {
            try {
                DB::beginTransaction();
                // MASUKKAN DATA TEMPORARY KE HPMILL UTAMA
                CloudHpMill::insert($data_temporary_insert);
                // KOSONGKAN DATA TEMPORARY
                // TempHpMill::truncate();
                DB::table('temp_hp_mill')
                    ->whereIn('id',  $temp_id)
                    ->delete();
                // array_push($inserted_data, 'Temporary Insert');
                $msg = 'Temporary Insert';
                array_push($inserted_data, 'Temporary Insert');
                DB::commit();
            } catch (\Exception $e) {
                $msg = 'Fail Temporary Insert'. $e->getMessage();
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
        $response['data'] = $temp_hp_mill;
        return response()->json($response);
    }
}
