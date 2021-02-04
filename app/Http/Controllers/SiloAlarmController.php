<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\SiloAlarm;
use App\SiloAlarmCloud;
use Illuminate\Support\Facades\Session;

class SiloAlarmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:siloAlarmView', ['only' => 'index']);
        $this->middleware('privilege:siloAlarmCreate', ['only' => 'create']);
        $this->middleware('privilege:siloAlarmEdit', ['only' => 'edit']);
        $this->middleware('privilege:siloAlarmDelete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Silo Alarm';
        $data['silo_alarms'] = SiloAlarm::all();
        return view('setting.silo-alarm.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Create Silo Alarm';
        return view('setting.silo-alarm.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'storage_code' => ['required', 'max:255', 'unique:silo_alarms'],
            'range_max' => ['required', 'numeric'],
            'formula' => ['required'],
            'text' => ['required'],
        ]);

        $silo = SiloAlarm::create($request->except('_token'));

        try {
            $request->request->add(['id' => $silo->id]);
            SiloAlarmCloud::create($request->except('_token'));
        } catch (\Throwable $th) {
            return redirect('setting/silo-alarm')->with(['create' => 'Data saved successfully! + ' . $th->getMessage()]);
        }
        return redirect('setting/silo-alarm')->with(['create' => 'Data saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Edit Silo Alarm';
        $data['silo_alarm'] = SiloAlarm::findOrFail($id);
        // dd($departement);
        return view('setting.silo-alarm.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'storage_code' => ['required', 'max:255', 'unique:silo_alarms,storage_code,' . $id],
            'range_max' => ['required', 'numeric'],
            'formula' => ['required'],
            'text' => ['required'],
        ]);

        SiloAlarm::where('id', $id)->update($request->except('_token','_method'));

        try {
            SiloAlarmCloud::where('id', $id)->update($request->except('_token', '_method'));
        } catch (\Throwable $th) {
            return redirect('setting/silo-alarm')->with(['update' => 'Data updated successfully! + ' . $th->getMessage()]);
        }
        return redirect('setting/silo-alarm')->with(['update' => 'Data updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SiloAlarm::destroy($id);
        try {
            SiloAlarmCloud::destroy($id);
            Session::flash('delete', 'Data deleted successfully!');
        } catch (\Throwable $th) {
            Session::flash('delete', 'Data deleted successfully! + ' . $th->getMessage());
        }
        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
