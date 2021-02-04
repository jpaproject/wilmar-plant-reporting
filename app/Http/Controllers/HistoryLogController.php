<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:historyLogView', ['only' => 'index']);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'History Log';
        $data['process'] = 'History Log';

        $date  = $request->input('date')  ?: date('Y-m-d');
        if ($request->input('period') == 'day') {
            $date = $request->input('date');
        } elseif ($request->input('period') == 'month') {
            $date = $request->input('month');
        } else {
            $date = date('Y-m-d');
        }

        $data['histories'] = DB::table('csv_imports')
        ->where('datetime', '>=',  $date . ' 00:00:00')
        ->where('datetime', '<=',  $date . ' 23:59:00')
        ->get();

        return view('reports.history-log.index', $data);
    }
}
