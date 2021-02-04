<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\TempMixer;
use App\CloudMixer;
use App\CloudMixerDetail;
use App\TempMixerDetail;
class ApiMixerController extends Controller
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


        $temp_mixer = TempMixer::get()->toarray();
        $temp_mixer_detail = TempMixerDetail::get()->toarray();
        
        $data_temporary_insert = array_map(function ($tmp)  {
            // unset($tmp['id']);
            return $tmp;
        }, $temp_mixer);

        $data_temporary_details_insert = array_map(function ($tmp_detail)  {
           
            unset($tmp_detail['id']);
            return $tmp_detail;
        }, $temp_mixer_detail);


        if ($temp_mixer) {
            try {
                DB::beginTransaction();
                // MASUKKAN DATA MIXER 
                CloudMixer::insert($data_temporary_insert);
                // MASUKKAN DATA MIXER DETAIL 
                CloudMixerDetail::insert($data_temporary_details_insert);


                // KOSONGKAN DATA TEMPORARY
                TempMixerDetail::truncate();
                TempMixer::truncate();
               
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
        $response['data'] = $temp_mixer;
        return response()->json($response);
    }
}
