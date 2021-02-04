<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\DashboardAlarm;
use Illuminate\Support\Facades\Session;

class DashboardAlarmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:DashboardAlarmView', ['only' => 'index']);
        $this->middleware('privilege:DashboardAlarmCreate', ['only' => 'create']);
        $this->middleware('privilege:DashboardAlarmEdit', ['only' => 'edit']);
        $this->middleware('privilege:DashboardAlarmDelete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Dashboard Alarm';
        $data['dashboard_alarms'] = DashboardAlarm::all();
        return view('setting.alarm-dashboard.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Dashboard Alarm';
        return view('setting.alarm-dashboard.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'material' => ['required'],
            'set_point' => ['required', 'numeric'],
            'text' => ['required'],
        ]);

        if (DashboardAlarm::where('material', $request->material)->first()) {
            DashboardAlarm::where('material', $request->material)->update($request->except('_token'));
        } else {
            DashboardAlarm::create($request->except('_token'));
        }
        return redirect('setting/dashboard-alarm')->with(['create' => 'Data saved successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Dashboard Alarm';
        $data['dashboard_alarm'] = DashboardAlarm::findOrFail($id);
        return view('setting.alarm-dashboard.edit', $data);
    }

    public function destroy($id)
    {
        DashboardAlarm::destroy($id);
        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
