<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Wbfile;
use App\TempWb;
class ApiWeightBridgeController extends Controller
{
    public function index(Request $request){

        if($request->input('date'))
            $date_month = $request->input('date');
        else
            $date_month = date('Y-m-d');

        $corn = "'" . implode("','", config('global.materials.corn')) . "'";
        $soya = "'" . implode("','", config('global.materials.soya')) . "'";
        $wheat = "'" . implode("','", config('global.materials.wheat')) . "'";
        $all_material = $corn . ',' . $soya . ',' . $wheat;
        $wbfiles =  DB::connection('sqlsrv')->select("SET NOCOUNT ON;  use feedmill
            select  a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
           
            from(
            select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett
           
            from wbfile a
            where a.statusax = 'Y' and a.flag = 'Y'
            ) a  WHERE itemno  IN ($all_material ) and  dateout like  '%$date_month%'");

        $inserted_data = [];
        $duplicate_data = [];
        $temporary_data = [];
        //-- CHECK DATA TEMPORARY
        if (TempWb::get()->count() > 0) {
            // JIKA ADA DATA TEMPORARY
            $data_temporary = TempWb::get()->toarray();
            $data_temporary_insert = array_map(function ($tmp) {
                unset($tmp['id']);
                return $tmp;
            }, $data_temporary);
            try {
                try {
                    \DB::beginTransaction();
                    // MASUKKAN DATA TEMPORARY KE WB UTAMA
                    WbFile::insert($data_temporary_insert);
                    // KOSONGKAN DATA TEMPORARY
                    TempWb::truncate();
                    array_push($inserted_data, 'Temporary Insert');
                    $msg = 'Temporary Insert';
                    \DB::commit();
                } catch (Throwable $e) {
                    $msg = 'Fail Temporary Insert';
                    \DB::rollback();
                }
               
            } catch (\Throwable $th) {
                $msg=$th->getMessage();
            }
        }


        //-- CHECK DATA TEMPORARY
        $count = 1;
        foreach ($wbfiles as $wbfile) {
            $data['ticket'] = trim($wbfile->ticket, " ");
            $data['itemno'] = $wbfile->itemno;
            $data['datein'] = $wbfile->datein;
            $data['dateout'] = $wbfile->dateout;
            $data['timein'] = $wbfile->timein;
            $data['timeout'] = $wbfile->timeout;
            $data['nett'] = $wbfile->nett;
            $data['start_tstamp'] = substr($wbfile->datein, 0, 10) . ' ' . $wbfile->timein;
            $data['end_tstamp'] = substr($wbfile->dateout, 0, 10) . ' ' . $wbfile->timeout;
            try {
                // -- CHECK KONEKSI CLOUD
                DB::connection('pgsql_cloud')->getPdo();
                try {
                    // -- INSERT DATA CLOUD
                    WbFile::insert($data);
                     $msg = 'Inserted ' . $count++ . ' Data ';
                    array_push($inserted_data, $data['ticket']);
                } catch (\Throwable $th) {
                    $msg = $th->getMessage();
                    array_push($duplicate_data, $data['ticket']);
                }
            } catch (\Throwable $th) {
                $msg = $th->getMessage();
                // -- HANDLE DATA YANG GAGAL KE KIRIM
                try {
                    // -- INSERT DATA KE TEMP_FEEDMILS
                    TempWb::insert($data);
                    $msg = 'Inserted to temporary' . $count++ . ' Data ';
                    array_push($temporary_data, $data['ticket']);
                } catch (\Throwable $th) {
                    $msg = $th->getMessage();
                    array_push($duplicate_data, $data['ticket']);
                }
            }
        }
        

        $response['duplicate'] = $duplicate_data;
        $response['inserted'] = $inserted_data;
        $response['temporary'] = $temporary_data;
        $response['msg'] = $msg;
        $response['date'] = date('Y-m-d');
        $response['datetime'] = date('YmdHis');
        $response['data'] = $wbfiles;
        
        return response()->json($response);
    }
}
