<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\AlarmSetting;
use Illuminate\Support\Facades\Session;

class AlarmSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth');
        $this->middleware('privilege:AlarmSettingView', ['only' => 'index']);
        $this->middleware('privilege:AlarmSettingCreate', ['only' => 'create']);
        $this->middleware('privilege:AlarmSettingEdit', ['only' => 'edit']);
        $this->middleware('privilege:AlarmSettingDelete', ['only' => 'destroy']);
    }

    public function index()
    {
        //
        $data['page_title'] = 'Alarm Settings';
        $data['alarm_settings'] = AlarmSetting::orderBy('id', 'desc')->get();
        return view('alarm.alarm_setting', $data);
    }
    public function create()
    {
        //
        $data['page_title'] = 'Create Alarm Settings';
        return view('alarm.alarm_setting_create', $data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data['tag_name'] = $request->input('tag_name');
        $data['formula'] = $request->input('formula');
        $data['sp'] = $request->input('sp');
        $data['text'] = $request->input('text');

        $request->validate([
            'tag_name' => 'required|min:2',
            'formula' => 'required',
            'text' => 'required',
            'sp' => 'required',
        ]);

        AlarmSetting::create($data);
        return redirect('alarm-setting')->with(['create' => 'Data saved successfully!']);
    }

    public function edit($id)
    {
        //
        $data['page_title'] = 'Edit Alarm Settings';
        $data['alarm_setting'] = AlarmSetting::findOrFail($id);
        return view('alarm.alarm_setting_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tag_name' => 'required|min:2',
            'formula' => 'required',
            'text' => 'required',
            'sp' => 'required',
        ]);

        $data = $request->all();
        $alarm_setting = AlarmSetting::findOrFail($id);
        $alarm_setting->update($data);

        return redirect('alarm-setting')->with(['update' => 'Data changed saved successfully!']);
    }

    public function destroy($id)
    {
        AlarmSetting::destroy($id);

        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
