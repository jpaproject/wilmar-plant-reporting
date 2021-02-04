<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlarmVoltage;
use Illuminate\Support\Facades\Session;
class AlarmVoltageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:AlarmVoltageView', ['only' => 'index']);
        $this->middleware('privilege:AlarmVoltageCreate', ['only' => 'create']);
        $this->middleware('privilege:AlarmVoltageEdit', ['only' => 'edit']);
        $this->middleware('privilege:AlarmVoltageDelete', ['only' => 'destroy']);
    }

    public function index()
    {
        $data['page_title'] = 'Alarm Voltage';
        $data['voltage_alarms'] = AlarmVoltage::orderby('id', 'desc')->get();
        return view('setting.alarm-voltage.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Alarm Voltage';
        return view('setting.alarm-voltage.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'normal' => ['required', 'numeric'],
            'range' => ['required', 'numeric'],
            'text' => ['required'],
        ]);
        $request->merge(['event' => 'ALARM VOLTAGE']);
        AlarmVoltage::create($request->except('_token'));
        return redirect('setting/voltage-alarm')->with(['create' => 'Data saved successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Alarm Weight Bridge';
        $data['voltage_alarm'] = AlarmVoltage::findOrFail($id);
        return view('setting.alarm-voltage.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'normal' => ['required', 'numeric'],
            'range' => ['required', 'numeric'],
            'text' => ['required'],
        ]);
        try {
            AlarmVoltage::where('id', $id)->update($request->except('_token', '_method'));
        } catch (\Throwable $th) {
            return redirect('setting/voltage-alarm')->with(['update' => 'Data updated successfully! + ' . $th->getMessage()]);
        }
        return redirect('setting/voltage-alarm')->with(['update' => 'Data updated successfully!']);
    }

    public function destroy($id)
    {
        AlarmVoltage::destroy($id);
        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
