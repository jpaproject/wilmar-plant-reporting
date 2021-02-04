<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlarmList;
class AlarmListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('privilege:Monitoring');
    }
    public function index()
    {
        $data['page_title'] = 'Alarm List';
        $data['alarm_lists'] = AlarmList::orderBy('id', 'desc')->get();
        return view('reports.alarm-list.index', $data);
    }
}
