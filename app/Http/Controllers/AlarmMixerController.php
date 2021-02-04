<?php

namespace App\Http\Controllers;

use App\AlarmMixer;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AlarmMixerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:AlarmMixerView', ['only' => 'index']);
        $this->middleware('privilege:AlarmMixerCreate', ['only' => 'create']);
        $this->middleware('privilege:AlarmMixerEdit', ['only' => 'edit']);
        $this->middleware('privilege:AlarmMixerDelete', ['only' => 'destroy']);
    }

    public function index()
    {
        //
        $data['page_title'] = 'Alarm Mixer';
        $data['alarm_mixers'] = AlarmMixer::orderBy('id', 'desc')->get();
        return view('setting.alarm-mixer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['page_title'] = 'Create Alarm Mixer';
        return view('setting.alarm-mixer.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['material'] = $request->input('material');
        // $data['formula'] = $request->input('formula');
        $data['sp'] = $request->input('sp');
        $data['text'] = $request->input('text');

        $request->validate([
            'material' => 'required|min:2',
            // 'formula' => 'required',
            'text' => 'required',
            'sp' => 'required|numeric',
        ]);

        AlarmMixer::create($data);
        return redirect('setting/mixer-alarm')->with(['create' => 'Data saved successfully!']);
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
        $data['page_title'] = 'Edit Alarm Mixer';
        $data['mixer_alarm'] = AlarmMixer::findOrFail($id);
        return view('setting.alarm-mixer.edit', $data);
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
        //
        $request->validate([
            'material' => 'required|min:2',
            // 'formula' => 'required',
            'text' => 'required',
            'sp' => 'required',
        ]);

        $data = $request->all();
        $alarm_mixer = AlarmMixer::findOrFail($id);
        $alarm_mixer->update($data);

        return redirect('setting/mixer-alarm')->with(['update' => 'Data changed saved successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        AlarmMixer::destroy($id);

        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
