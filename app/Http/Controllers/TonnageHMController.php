<?php

namespace App\Http\Controllers;

use App\TonnageHM;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TonnageHMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['page_title'] = 'Tonnage Hammer Mill';


        $data_tms = DB::table('totalizer')
            // ->select(DB::raw("
            // date_trunc('" . 'hour' . "',tstamp)  AS datetime
            //     ", 'job', 'tonnage'))
            ->select('*')
            // ->where("job", "LIKE", '%PELLET MILL%')
            // ->where("tstamp", "LIKE", '%' . $date_month . '%')
            // ->where("kwh_motor", ">", 0)
            ->where("tonnage", ">", 0)
            // ->where("tonnage", "<", 1)
            // ->where("tonnage", ">", 0)
            // ->groupBy('datetime', 'job')
            ->orderBy('id', 'desc')
            ->take(100)
            ->get();



        $data['tonnages'] =  $data_tms;
        // dd($data['tonnages']);

        return view('tonnage.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }
}
