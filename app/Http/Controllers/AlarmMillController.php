<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\AlarmMill;
use Illuminate\Support\Facades\Session;

class AlarmMillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:AlarmMillView', ['only' => 'index']);
        $this->middleware('privilege:AlarmMillCreate', ['only' => 'create']);
        $this->middleware('privilege:AlarmMillEdit', ['only' => 'edit']);
        $this->middleware('privilege:AlarmMillDelete', ['only' => 'destroy']);
    }

    public function index()
    {
        $data['page_title'] = 'Alarm Mill';
        $data['mill_alarms'] = AlarmMill::all();
        return view('setting.alarm-mill.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Alarm Mill';
        $data['materials'] = config('global.materials');
        return view('setting.alarm-mill.create', $data);
    }

    private function MaterialName($code)
    {
        foreach (config('global.materials') as $key => $value) {
            foreach ($value as $sKey) {
                if (stripos($code, $sKey) !== false) {
                    return strtoupper($key);
                }
            }
        }
        return false;
    }

    public function store(Request $request)
    {
        $request->validate([
            'device' => ['required'],
            'pakan' => ['required'],
            'set_point' => ['required', 'numeric'],
            'text' => ['required'],
        ]);

        // if (AlarmMill::where('device', $request->device)->first()) {
        //     AlarmMill::where('device', $request->device)->update($request->except('_token'));
        // } else {
        AlarmMill::create($request->except('_token'));
        // }
        return redirect('setting/mill-alarm')->with(['create' => 'Data saved successfully!']);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'device' => ['required'],
            'pakan' => ['required'],
            'set_point' => ['required', 'numeric'],
            'text' => ['required'],
        ]);

        $data = $request->all();
        $alarm_mill = AlarmMill::findOrFail($id);
        $alarm_mill->update($data);

        return redirect('setting/mill-alarm')->with(['update' => 'Data changed saved successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Alarm Mill';
        $data['mill_alarm'] = AlarmMill::findOrFail($id);
        $data['materials'] = config('global.materials');
        return view('setting.alarm-mill.edit', $data);
    }

    public function destroy($id)
    {
        AlarmMill::destroy($id);
        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
