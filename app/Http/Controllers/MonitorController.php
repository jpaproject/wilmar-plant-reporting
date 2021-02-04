<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function index()
    {

        $data['page_title'] = 'Product Overview';
        $data['monitor'] = true;

        return view('product-overview.monitor-mode', $data);
    }
}
