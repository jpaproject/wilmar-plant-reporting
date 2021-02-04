<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\AlarmWb;
class AlarmWBController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:AlarmWBView', ['only' => 'index']);
        $this->middleware('privilege:AlarmWBCreate', ['only' => 'create']);
        $this->middleware('privilege:AlarmWBEdit', ['only' => 'edit']);
        $this->middleware('privilege:AlarmWBDelete', ['only' => 'destroy']);
    }

    public function index()
    {
        $data['page_title'] = 'Alarm Weight Bridge';
        $data['wb_alarms'] = AlarmWb::orderby('id','desc')->get();
        return view('setting.alarm-wb.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Alarm Weight Bridge';
        return view('setting.alarm-wb.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'duration' => ['required', 'numeric'],
            'text' => ['required'],
        ]);
        $request->merge(['event'=>'ALARM WEIGHT BRIDGE']);
        AlarmWb::create($request->except('_token'));
        return redirect('setting/wb-alarm')->with(['create' => 'Data saved successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Alarm Weight Bridge';
        $data['wb_alarm'] = AlarmWb::findOrFail($id);
        return view('setting.alarm-wb.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'duration' => ['required', 'numeric'],
            'text' => ['required'],
        ]);
        try {
            AlarmWb::where('id', $id)->update($request->except('_token', '_method'));
        } catch (\Throwable $th) {
            return redirect('setting/wb-alarm')->with(['update' => 'Data updated successfully! + ' . $th->getMessage()]);
        }
        return redirect('setting/wb-alarm')->with(['update' => 'Data updated successfully!']);
    }

    public function destroy($id)
    {
        AlarmWb::destroy($id);
        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
