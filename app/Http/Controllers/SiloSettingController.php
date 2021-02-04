<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiloName;
use Illuminate\Support\Facades\Session;
use App\CloudSiloName;
class SiloSettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:siloSettingView', ['only' => 'index']);
        $this->middleware('privilege:siloSettingCreate', ['only' => 'create']);
        $this->middleware('privilege:siloSettingEdit', ['only' => 'edit']);
        $this->middleware('privilege:siloSettingDelete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Silo Setting';
        $data['silo_settings'] = SiloName::orderby('storage', 'asc')->get();
        return view('setting.silo-setting.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Create Silo Name';
        return view('setting.silo-setting.create', $data);
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
            'storage' => ['required', 'max:255', 'unique:silo_names'],
            'name' => ['required', 'string',]
        ]);

        $data['storage'] = $request->input('storage');
        $data['name'] = $request->input('name');
        $data['tstamp'] = date('Y-m-d H:i:s');

        SiloName::create($data);
        try {
             CloudSiloName::create($data);
        } catch (\Throwable $th) {
            return redirect('setting/silo-setting')->with(['create' => 'Data saved successfully!']);
        }
        return redirect('setting/silo-setting')->with(['create' => 'Data saved successfully!']);
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
        $data['page_title'] = 'Edit Silo Name';
        $data['silo_setting'] = SiloName::findOrFail($id);
        return view('setting.silo-setting.edit', $data);
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
            'storage' => ['required', 'max:255'],
            'name' => ['required', 'string',]
        ]);

        $data['storage'] = $request->input('storage');
        $data['name'] = $request->input('name');

        SiloName::where('id', $id)->update($data);
        try {
             CloudSiloName::where('id', $id)->update($data);
        } catch (\Throwable $th) {
            return redirect('setting/silo-setting')->with(['update' => 'Data updated successfully!']);
        }
        return redirect('setting/silo-setting')->with(['update' => 'Data updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SiloName::destroy($id);
        try {
            CloudSiloName::destroy($id);
            Session::flash('delete', 'Data deleted successfully!');
        } catch (\Throwable $th) {
            Session::flash('delete', 'Data deleted successfully!');
        }
        return response()->json(['status' => '200']);
    }
}
