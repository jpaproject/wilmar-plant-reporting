<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('privilege:weightBridgeView', ['only' => 'weightBridge']);
        $this->middleware('privilege:intakeView', ['only' => 'intake']);
        $this->middleware('privilege:HammerMillView', ['only' => 'hammerMill']);
        $this->middleware('privilege:PelletView', ['only' => 'pellet']);
        $this->middleware('privilege:MixerView', ['only' => 'mixer']);
        $this->middleware('privilege:MixerDetailView', ['only' => 'mixerDetail']);
    }

    public function weightBridge()
    {

        $data['page_title'] = 'Report';
        $data['process'] = 'Weight Bidge';

        return view('reports.index', $data);
    }

    public function intake()
    {

        $data['page_title'] = 'Intake Report';
        $data['process'] = 'Intake';

        return view('reports.index', $data);
    }

    public function hammerMill()
    {

        $data['page_title'] = 'Hammer Mill Report';
        $data['process'] = 'Hammer Mill';

        return view('reports.index', $data);
    }

    public function pellet()
    {

        $data['page_title'] = 'Pellet Report';
        $data['process'] = 'Pellet';

        return view('reports.index', $data);
    }

    public function mixer()
    {

        $data['page_title'] = 'Mixer Report';
        $data['process'] = 'Mixer';

        return view('reports.mixer.index', $data);
    }
    public function mixerDetail($id)
    {

        $data['page_title'] = 'Mixer Detail Report';
        $data['process'] = 'Mixer Detail';

        return view('reports.mixer.detail', $data);
    }
}
