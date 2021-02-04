<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Privilege as Privileges;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PrivilegesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['page_title'] = 'Privileges Management';
        $data['privileges'] = Privileges::orderBy('name', 'asc')->get();
        return view('privilege.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['page_title'] = 'Create Privileges';
        $data['privileges'] = Privileges::all();
        return view('privilege.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
        ]);


        $data['name'] = $request->input('name');
        $data['description'] = $request->input('description');

        Privileges::create($data);

        return redirect('privileges')->with(['create' => 'Data saved successfully!']);
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
        //
        $data['page_title'] = 'Edit Privileges';
        // $data['departements'] = Privileges::all();
        $data['privileges'] = Privileges::findOrFail($id);
        // dd($departement);
        return view('privilege.edit', $data);
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
        $data_user = Privileges::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required'],
        ]);

        $data['name'] = $request->input('name');
        $data['description'] = $request->input('description');

        // dd($data);
        Privileges::where('id', $id)->update($data);

        return redirect('privileges')->with(['update' => 'Data updated successfully!']);
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
        DB::transaction(function () use ($id) {
            Privileges::where('id', $id)->delete();
        });

        // redirect('departements')->with(['delete' => 'Data deleted successfully!']);
        Session::flash('delete', 'Data deleted successfully!');
        return response()->json(['status' => '200']);
    }
}
