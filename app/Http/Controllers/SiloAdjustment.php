<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiloSetting;
use App\SiloSettingCloud;
use Illuminate\Support\Facades\Session;
use App\SiloAdjustmentErp;

class SiloAdjustment extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:adjustView', ['only' => 'index']);
        $this->middleware('privilege:adjustCreate', ['only' => 'create']);
        $this->middleware('privilege:adjustEdit', ['only' => 'edit']);
        $this->middleware('privilege:adjustDelete', ['only' => 'destroy']);
    }
    public function index()
    {
        $data['page_title'] = 'Silo Adjustment';
        $data['silo_settings'] = SiloAdjustmentErp::where('type', '!=', 'On Hand')->orderBy('date', 'desc')->get();
        return view('setting.silo-adjustment.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Create Silo Adjustment';
        return view('setting.silo-adjustment.create', $data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'storage' => ['required', 'max:255', 'unique:silo_settings'],
            'value' => ['required'],
            'formula' => ['required', 'string',],
        ]);


        $data['storage'] = $request->input('storage');
        $data['formula'] = $request->input('formula');
        $data['value'] = $request->input('value');

        $silo =  SiloSetting::create($data);
        try {
            $data['id'] = $silo->id;
            SiloSettingCloud::create($data);
        } catch (\Throwable $th) {
            return redirect('setting/silo-adjustment')->with(['create' => 'Data saved successfully! + ' . $th->getMessage()]);
        }

        return redirect('setting/silo-adjustment')->with(['create' => 'Data saved successfully!']);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Silo Adjustment';
        $data['silo_setting'] = SiloSetting::findOrFail($id);
        // dd($departement);
        return view('setting.silo-adjustment.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'storage' => ['required', 'max:255', 'unique:silo_settings,storage,' . $id],
            'value' => ['required'],
            'formula' => ['required', 'string',],
        ]);
        $data['storage'] = $request->input('storage');
        $data['formula'] = $request->input('formula');
        $data['value'] = $request->input('value');
        SiloSetting::where('id', $id)->update($data);
        try {
            SiloSettingCloud::where('id', $id)->update($data);
        } catch (\Throwable $th) {
            return redirect('setting/silo-adjustment')->with(['update' => 'Data updated successfully! + ' . $th->getMessage()]);
        }
        return redirect('setting/silo-adjustment')->with(['update' => 'Data updated successfully!']);
    }

    public function destroy($id)
    {
        // SiloSetting::destroy($id);
        // dd($siloAdjustment);
        try {

            SiloAdjustmentErp::where('jurnal', 'LIKE', '%' . $id . '%')->delete();
            // SiloSettingCloud::destroy($id);
            Session::flash('delete', 'Data deleted successfully!');
        } catch (\Throwable $th) {
            Session::flash('delete', 'Data deleted successfully! + ' . $th->getMessage());
        }
        return response()->json(['status' => '200']);
    }
}
