<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function device()
    {

        $data['page_title'] = 'Setting Device';
        $data['devices'] = \App\Device::orderBy('id', 'desc')->get();

        return view('setting.device.index', $data);
    }
    public function deviceCreate()
    {

        $data['page_title'] = 'Create Device';

        return view('setting.device.create', $data);
    }

    public function deviceStore(Request $request)
    {
        $data['name'] = $request->input('name');
        $data['device_id'] = $request->input('device_id');
        $data['status'] = 0;

        $request->validate([
            'name' => 'required|min:2',
            'device_id' => 'required',
        ]);

        // Insert Data Departement
        \App\Device::insert($data);

        return redirect('setting/device')->with(['create' => 'Data saved successfully!']);

    }

    public function deviceEdit($id)
    {

        $data['page_title'] = 'Edit Device';
        $data['device'] = \App\Device::findOrFail($id);

        return view('setting.device.edit', $data);
    }

    public function deviceUpdate(Request $request, $id)
    {
        //
        $data['name'] = $request->input('name');
        $data['device_id'] = $request->input('device_id');

        $request->validate([
            'name' => 'required|min:2',
            'device_id' => 'required',
        ]);

        \App\Device::where('id', $id)->update($data);

        return redirect('setting/device')->with(['update' => 'Data updated successfully!']);

    }

    public function deviceDefault($id)
    {
        //
        \App\Device::where('id', '!=', $id)->update(['status' => 0]);
        \App\Device::where('id', $id)->update(['status' => 1]);
        $device = \App\Device::where('id', $id)->first();

        return Redirect::back()->withErrors(['Monitoring on Device : ' . $device->name, 'The Message']);

    }
    public function deviceDestroy($id)
    {
        \App\Device::where('id', $id)->delete();
        // redirect('departements')->with(['delete' => 'Data deleted successfully!']);
        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);

    }

    // --PRICE
    public function price()
    {

        $data['page_title'] = 'Setting Price';
        $data['devices'] = \App\Device::orderBy('id', 'desc')->get();

        return view('setting.price.index', $data);
    }
}
