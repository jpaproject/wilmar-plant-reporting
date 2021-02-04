<?php

namespace App\Http\Controllers;

use App\AlarmMillCloud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SiloSetting;
use App\SiloSettingCloud;
use App\SiloActual;
use App\SiloActualCloud;
use App\DashboardAlarm;
use App\DashboardAlarmCloud;
use App\SiloAlarm;
use App\SiloAlarmCloud;
use App\CloudSiloName;
use App\SiloName;
class SyncController extends Controller
{
    public function sync(){
        // --- Sillo Setting
        // $silo_setting = SiloSetting::all();
        // try {
        //     DB::beginTransaction();
        //     // HAPUS DATA DULU
        //     SiloSettingCloud::truncate();
        //     // SETTING DATA KE CLOUD
        //     $siloSync = [];
        //     foreach ($silo_setting as $item) {
        //         $partial = [
        //             'id'        => $item->id,
        //             'storage'    => $item->storage,
        //             'formula'    => $item->formula,
        //             'value'      => $item->value,
        //             'created_at' => $item->created_at,
        //             'updated_at' => $item->updated_at,
        //         ];
        //         array_push($siloSync, $partial);
        //     }
        //     SiloSettingCloud::insert($siloSync);
        //     DB::commit();
        // } catch (\Throwable $e) {
        //     DB::rollBack();
        //     return redirect()->back()->with(['sync_fail' => $e->getMessage()]);
        // }
        
        // --- Silo Actual
        $silo_actual = SiloActual::all();
        try {
            DB::beginTransaction();
            // HAPUS DATA DULU
            SiloActualCloud::truncate();
            // SETTING DATA KE CLOUD
            $siloActyalSync = [];
            foreach ($silo_actual as $item) {
                $partial = [
                    'id' => $item->id,
                    'storage_code'    => $item->storage_code,
                    'date'    => $item->date,
                    'value_actual'      => $item->value_actual,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
                array_push($siloActyalSync,
                    $partial
                );
            }
            SiloActualCloud::insert($siloActyalSync);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with(['sync_fail' => $e->getMessage()]);
        }


        // --- Silo Name
        $silo_actual = SiloName::all();
        try {
            DB::beginTransaction();
            // HAPUS DATA DULU
            CloudSiloName::truncate();
            // SETTING DATA KE CLOUD
            $siloActyalSync = [];
            foreach ($silo_actual as $item) {
                $partial = [
                    'id' => $item->id,
                    'tstamp'    => $item->tstamp,
                    'storage'    => $item->storage,
                    'name'      => $item->name,
                ];
                array_push(
                    $siloActyalSync,
                    $partial
                );
            }
            CloudSiloName::insert($siloActyalSync);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with(['sync_fail' => $e->getMessage()]);
        }
        
        // --- Alarm Dashboard 
        $alarm_dashboard = DashboardAlarm::all();
        try {
            DB::beginTransaction();

            // HAPUS DATA DULU
            DashboardAlarmCloud::truncate();

            // SETTING DATA KE CLOUD
            $alarmDashboardSync = [];
            foreach ($alarm_dashboard as $item) {
                $partial = [
                    'id' => $item->id,
                    'material'   => $item->material,
                    'set_point'  => $item->set_point,
                    'text'       => $item->text,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
                array_push(
                    $alarmDashboardSync,
                    $partial
                );
            }
            DashboardAlarmCloud::insert($alarmDashboardSync);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with(['sync_fail' => $e->getMessage()]);
            
        }

        // --- Alarm Silo
        $alarm_dashboard = SiloAlarm::all();
        try {
            DB::beginTransaction();

            // HAPUS DATA DULU
            SiloAlarmCloud::truncate();

            // SETTING DATA KE CLOUD
            $alarmSiloSync = [];
            foreach ($alarm_dashboard as $item) {
                $partial = [
                    'id' => $item->id,
                    'storage_code'    => $item->storage_code,
                    'date'    => $item->date,
                    'range_min'      => $item->range_min,
                    'range_max'      => $item->range_max,
                    'formula'       => $item->formula,
                    'text'          => $item->text,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
                array_push(
                    $alarmSiloSync,
                    $partial
                );
            }
            SiloAlarmCloud::insert($alarmSiloSync);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with(['sync_fail' => $e->getMessage()]);
            
        }

        // --- Alarm Mill
        $alarm_mill = \App\AlarmMill::all();
        try {
            DB::beginTransaction();

            // HAPUS DATA DULU
            AlarmMillCloud::truncate();

            // SETTING DATA KE CLOUD
            $alarmMiloSync = [];
            foreach ($alarm_mill as $item) {
                $partial = [
                    'id' => $item->id,
                    'device'    => $item->device,
                    'set_point'    => $item->set_point,
                    'text'      => $item->text,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
                array_push(
                    $alarmMiloSync,
                    $partial
                );
            }
            AlarmMillCloud::insert($alarmMiloSync);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with(['sync_fail' => $e->getMessage()]);
            
        }

        return redirect()->back()->with(['sync' => 'Data sync successfully!']);
        
        
       
    }
}
