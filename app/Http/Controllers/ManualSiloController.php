<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\SiloActual;
use App\SiloActualCloud;
use Illuminate\Support\Facades\Session;

class ManualSiloController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:ActualSiloView', ['only' => 'index']);
        $this->middleware('privilege:ActualSiloCreate', ['only' => 'create']);
        $this->middleware('privilege:ActualSiloEdit', ['only' => 'edit']);
        $this->middleware('privilege:ActualSiloDelete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Silo Actual Manual';
        $data['silo_actuals'] =
            \App\SiloActual::orderby('storage_code', 'asc')
            ->get();
        return view('setting.silo-manual.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Create Silo Actual';
        return view('setting.silo-manual.create', $data);
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
            'storage_code' => ['required', 'max:255', 'unique:silo_actuals'],
            'date' => ['required'],
            'value_actual' => ['required'],
        ]);

        $silo = SiloActual::create($request->except('_token'));
        try {
            $request->request->add(['id' => $silo->id]);
            SiloActualCloud::create($request->except('_token'));
        } catch (\Throwable $th) {
            return redirect('setting/silo-manual')->with(['update' => 'Data saved successfully!']);
        }
        return redirect('setting/silo-manual')->with(['create' => 'Data saved successfully!']);
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
        $data['page_title'] = 'Edit Silo Actual';
        $data['silo_actual'] = SiloActual::findOrFail($id);
        // dd($departement);
        return view('setting.silo-manual.edit', $data);
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
            'storage_code' => ['required', 'max:255', 'unique:silo_actuals,storage_code,' . $id],
            'date' => ['required'],
            'value_actual' => ['required'],
        ]);


        SiloActual::where('id', $id)->update($request->except('_token', '_method'));
        try {
            SiloActualCloud::where('id', $id)->update($request->except('_token', '_method'));
        } catch (\Throwable $th) {
            return redirect('setting/silo-manual')->with(['update' => 'Data updated successfully! + ' . $th->getMessage()]);
        }
        return redirect('setting/silo-manual')->with(['update' => 'Data updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // SiloActual::destroy($id);
        SiloActual::destroy($id);
        try {
            SiloActualCloud::destroy($id);
            Session::flash('delete', 'Data deleted successfully!');
        } catch (\Throwable $th) {
            Session::flash('delete', 'Data deleted successfully! + ' . $th->getMessage());
        }
        return response()->json(['status' => '200']);
    }
}
