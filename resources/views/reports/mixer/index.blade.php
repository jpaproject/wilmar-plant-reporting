@extends('layouts.main')

@section('page_title',$page_title)
@section('css')
{{-- <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> --}}

<style>
    .table-responsive::-webkit-scrollbar {
        -webkit-appearance: none;
    }

    .table-responsive::-webkit-scrollbar:vertical {
        width: 12px;
    }

    .table-responsive::-webkit-scrollbar:horizontal {
        height: 12px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, .5);
        border-radius: 10px;
        border: 2px solid #ffffff;
    }

    .table-responsive::-webkit-scrollbar-track {
        border-radius: 10px;
        background-color: #ffffff;
    }

    a {
        color: inherit;
    }

    .card__one {
        transition: transform .5s;


    }

    .card__one::after {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transition: opacity 2s cubic-bezier(.165, .84, .44, 1);
        box-shadow: 0 8px 17px 0 rgba(0, 0, 0, .2), 0 6px 20px 0 rgba(0, 0, 0, .15);
        content: '';
        opacity: 0;
        z-index: -1;
    }

    .card__one:hover,
    .card__one:focus {
        transform: scale3d(1.036, 1.036, 1);
        -webkit-box-shadow: -1px -1px 16px -4px rgba(0, 0, 0, 0.53);
        -moz-box-shadow: -1px -1px 16px -4px rgba(0, 0, 0, 0.53);
        box-shadow: -1px -1px 16px -4px rgba(0, 0, 0, 0.53);


    }



    a:hover {
        color: inherit;
        text-decoration: none;
        cursor: pointer;
    }

    .hilang {
        display: none;
    }

</style>
@endsection

@section('content')
<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">{{ env('APP_SUBNAME') }}</a>
            <span class="breadcrumb-item active">{{$page_title}}</span>
        </nav>
    </div><!-- br-pageheader -->
    {{-- <div class="br-pagetitle">
        <i class="icon icon ion-stats-bars"></i>
        <div>
            <h4>{{$page_title}}</h4>
</div>
</div><!-- d-flex --> --}}

<div class="br-pagebody">
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
    <div class="bg-dance text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-royal rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/mx.png')}}" class="ht-50 rounded-circle" alt="">
            {{-- <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">{{$page_title}} </h4> --}}
            <form method="get">
                <div class="form-group mg-b-0">
                    <div class="input-group " id="datepicker-area">
                        <input type="text" name="date_from" value="{{ Request::input('date_from') ?: date('Y-m-d')  }}"
                            autocomplete="off" class="datepicker form-control mg-r-10" required placeholder="Date From">
                        <input type="text" name="date_to" value="{{ Request::input('date_to')  ?: date('Y-m-d')  }}"
                            autocomplete="off" class="datepicker form-control " required placeholder="Date To">
                        <button class="btn btn-info btn-flat">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
        <div class="row ">
            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base card__one bd-0  rounded-20 ">
                    <div class="card-body tx-center">
                        <div class="pos-relative">
                            <div class="pos-absolute x-0 t--60">
                                <a href=""><img src="{{asset('backend/images/icon/total_product.png')}}" class="wd-100 "
                                        alt=""></a>
                            </div><!-- pos-relative -->
                        </div>
                        <h4 class="tx-bold tx-24  mg-t-60 mg-b-5 tx-inverse extra-bold">Batch / Hour</h4>
                        
                    </div><!-- card-body -->
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">
                            <div class="col pd-y-15 bd-r  bd-gray-200">
                                 @if ($total_hour_3 != 0 and $total_hour_3!=null and $total_batch!= 0 and $total_batch != null)
                                
                                    <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format(($total_batch/$total_hour_3),2,',','.')}}</span>
                               
                                @else
                                  <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">0</span>
                               
                                @endif
                                
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Batch / Hour</small>
                            </div><!-- col -->
                            <div class="col pd-y-15   bd-gray-200">
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{$total_batch}}</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Batch</small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{$total_hour_2}}</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Hour</small>
                            </div><!-- col -->
                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->

                <div class="card shadow-base card__one mg-t-10 bd-0  rounded-20 ">
                    <span class="mg-t-5 mg-b-5 text-center tx-gray-800">Date : {{$date_before}}</span>
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">
                            <div class="col pd-y-15">
                                @if ($total_hour_3_before != 0 and $total_hour_3_before!=null and $total_batch_before!= 0 and $total_batch_before !=
                                null)
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format(($total_batch_before/$total_hour_3_before),2,',','.')}}
                                    </span>
                                @else
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">0
                                    </span>
                                @endif

                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Batch / Hour</small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{$total_batch_before}}
                                    </span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">BATCH
                                </small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{$total_hour_2_before}}
                                   </span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">HOUR</small>
                            </div><!-- col -->
                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>
            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base card__one bd-0   rounded-20 ">
                    <div class="card-body tx-center">
                        <div class="pos-relative">
                            <div class="pos-absolute x-0 t--60">
                                <a href=""><img src="{{asset('backend/images/icon/total_batch.png')}}" class="wd-100 "
                                        alt=""></a>
                            </div><!-- pos-relative -->
                        </div>
                        <h4 class="tx-bold tx-24  mg-t-60 mg-b-5 tx-inverse extra-bold">Tonnage (kg)</h4>

                    </div><!-- card-body -->
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">

                            <div class="col pd-y-15 bd-r bd-gray-200">
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_tonTarget, 0,',','.')}}
                                    <span class="tx-15"></span></span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Target</small>
                            </div><!-- col -->

                            <div class="col pd-y-15   bd-gray-200">
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_tonActual, 0,',','.')}}
                                    <span class="tx-15"></span></span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Actual</small>
                            </div><!-- col -->

                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($tonn_diff, 2,',','.')}}
                                     % <span class="tx-15"></span></span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Difference</small>
                            </div><!-- col -->


                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->

                <div class="card shadow-base card__one mg-t-10 bd-0  rounded-20 ">
                    <span class="mg-t-5 mg-b-5 text-center tx-gray-800">Date : {{$date_before}}</span>
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">
                            <div class="col pd-y-15">
                                
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_tonTarget_before, 0,',','.')}}
                                    </span>
                               

                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">TARGET</small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_tonActual_before, 0,',','.')}}
                                    </span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">ACTUAL
                                </small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($tonn_diff_before, 2,',','.')}}
                                     %</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                            </div><!-- col -->
                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>

            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base card__one bd-0  rounded-20 ">

                    <div class="card-body tx-center">
                        <div class="pos-relative">
                            <div class="pos-absolute x-0 t--60">
                                <a href=""><img src="{{asset('backend/images/icon/farm.png')}}" class="wd-100 "
                                        alt=""></a>
                            </div><!-- pos-relative -->
                        </div>
                        <h4 class="tx-bold tx-24  mg-t-60 mg-b-5 tx-inverse extra-bold">Raw Material (kg)</h4>

                    </div><!-- card-body -->
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">
                            <div class="col pd-y-15   bd-gray-200">
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_corn,0,',','.')}}
                                    <span class="tx-15"></span></span>
                                {{-- <span href="" class="tx-12 tx-bold d-block tx-gray-800 hover-info">Actual</span> --}}
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Corn</small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_soya,0,',','.')}}
                                    <span class="tx-15"></span></span>
                                {{-- <span href="" class="tx-12 tx-bold d-block tx-gray-800 hover-info">Actual</span> --}}
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Soya</small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href=""
                                    class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_wheat,0,',','.')}}
                                    <span class="tx-15"></span></span>
                                {{-- <span href="" class="tx-12 tx-bold d-block tx-gray-800 hover-info">Actual</span> --}}
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">BBPT</small>
                            </div><!-- col -->

                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
                <div class="card shadow-base card__one mg-t-10 bd-0  rounded-20 ">
                    <span class="mg-t-5 mg-b-5 text-center tx-gray-800">Date : {{$date_before}}</span>
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">
                            <div class="col pd-y-15">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_corn_before,0,',','.')}}
                                    </span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">CORN</small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_soya_before,0,',','.')}}
                                    </span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">SOYA
                                </small>
                            </div><!-- col -->
                            <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($total_wheat_before,0,',','.')}}
                                   </span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">BBPT</small>
                            </div><!-- col -->
                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>



        </div>
    </div>
     @if (Request::input('date_from'))
        <div class="card bd-0 shadow-base rounded-20  mg-t-40">
            <div class="card-header tx-medium bd-0 bg-crystal-clear  d-flex justify-content-between align-items-center"
                style="border-radius: 122px;border-bottom-left-radius: 0px;">
                <h6 class="card-title tx-uppercase text-white tx-12 mg-b-0"> Detail Summary -
                    {{ Request::input('date_from') ?: date('Y-m-d')  }}</h6>
                <span class="tx-12 tx-uppercase" id="dateTag1"></span>
            </div><!-- card-header -->
            <div class="wd-100p mg-t-20 ht-400 hilang" id="data-exist" width=""></div>
            <div class="card-body tx-gray-700  pd-t-10 pd-b-20 d-xs-flex justify-content-between align-items-center">
                <div class="wd-100p table-responsive">
                    <div id="buttons2" style="padding: 10px; margin-bottom: 10px;width: 100%;">
                        <p>Download :</p>
                    </div>
                    <table class="table  nowrap" id="table2">
                        <thead>
                            {{-- <td class="wd-1p " width="1%">No</td> --}}

                            <tr>
                                <th class=" ">Datetime</th>
                                <th style="background:">
                                    <p class="tx-bold">BATCH / HOUR</p> BATCH/HOUR
                                </th>
                                <th style="background:">
                                    <p class="tx-bold">BATCH</p> 
                                </th>
                                <th style="background:">
                                    <p class="tx-bold">HOUR</p> 
                                </th>
                                <th style="background: ">
                                    <p class="tx-bold">TONNAGE</p> TARGET (KG)
                                </th>
                                <th style="background: ">
                                    <p class="tx-bold">TONNAGE</p> ACTUAL (KG)
                                </th>
                                <th style="background: ">
                                    <p class="tx-bold">TONNAGE</p> DIFFERENCE
                                </th>
                                <th style="background: ">
                                    <p class="tx-bold">RAW MATERIAL</p> CORN (KG)
                                </th>
                                <th style="background: ">
                                    <p class="tx-bold">RAW MATERIAL</p> SOYA (KG)
                                                                </th>
                                <th style="background: ">
                                    <p class="tx-bold">RAW MATERIAL</p> BBPT (KG)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($akumulasi_hour as $ah)
                                <tr>
                                    <td>{{$ah['hour']}}</td>
                                
                                    <td>{{number_format($ah['total_batch_per_hour'], 2,',','.')}}</td>
                                    <td>{{number_format($ah['total_batch_hour'], 0,',','.')}}</td>
                                    <td>{{number_format($ah['total_hour_hour'], 2,'.','.')}}</td>

                                    <td>{{number_format($ah['tonn_target'], 0,',','.')}}</td>
                                    <td>{{number_format($ah['tonn_actual'], 0,',','.')}}</td>
                                    <td>{{number_format($ah['tonn_diff'], 1,',','.')}} %</td>

                                    <td>{{number_format($ah['corn_hour'], 0,',','.')}}</td>
                                    <td>{{number_format($ah['soya_hour'], 0,',','.')}}</td>
                                    <td>{{number_format($ah['wheat_hour'], 0,',','.')}}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>



            </div><!-- card-body -->
        </div><!-- card -->
        @endif

    <div class="bd-gray-200 text-white rounded-20 pd-0 mg-t-60" style="border-top: dotted 7px #20354d1a;">
        <div class="text-center d-flex  bg-royal rounded-20 pd-10 text-white" style="    width: fit-content;
    margin-top: -40px;
    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);
    text-align: center;
    display: table;
    margin-left: auto;
    margin-right: auto;">
            <img src="{{asset('backend/images/icon/trend.png')}}" class="ht-30 rounded-circle" alt="">
            <h5 class="tx-bold mg-b-0 mg-t-5 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;"> Report </h4>
        </div>
        <div class="row row-sm mg-t-20">
            <div class="col-md-6 mg-t-20">
                <div class="card bd-0 shadow-base    rounded-20">
                    <div class="card-header tx-medium bd-0 tx-black bg-royal d-flex justify-content-between align-items-center"
                        style="border-radius: 122px;border-bottom-left-radius: 0px;">
                        {{-- <i class="icon ion-arrow-graph-up-right tx-12"></i> --}}
                        <span class="card-title tx-uppercase text-white tx-12 mg-b-0">Report : {{$process}}</span>
                        <span class="tx-12 tx-uppercase" id=""></span>
                    </div><!-- card-header -->
                    <div class="card-body  d-xs-flex justify-content-between align-items-center">
                        <div class="d-md-flex pd-y-20 pd-md-y-0">
                            <form action="" method="get">
                                <div class="row  tx-gray-700">
                                    {{-- <div class="col-lg-4">
                                        <small>Data :</small>
                                        <select name="" class="form-control" id="daterange">
                                            <option value="all">All </option>
                                            <option value="system">Total Batch</option>
                                            <option value="motor">Batch / Jam</option>
                                        </select>
                                    </div> --}}
                                    <div class="col-lg-12">

                                        <small>Select Condition :</small>

                                        <div class="input-group " id="datepicker-area">

                                            <span class="input-group-append">
                                                <select name="period" class="form-control select2" id="daterange">
                                                    <option value="day"
                                                        {{ Request::input('period') == 'day' ? 'selected=selected' : ''  }}>
                                                        Day (H) </option>
                                                    <option value="month"
                                                        {{ Request::input('period') == 'month' ? 'selected=selected' : ''  }}>
                                                        Month</option>
                                                </select>
                                            </span>
                                            <form action="">
                                                <input type="text" name="date" id="date"
                                                    value="{{ Request::input('date') == '' ? date('Y-m-d') : Request::input('date')  }}"
                                                    autocomplete="off"
                                                    class="datepicker day form-control  {{ Request::input('period') == 'day' ? '' : (Request::input('period') == '' ? '' : 'hilang')   }} time">

                                                <input type="text" name="month" id="month"
                                                    value="{{ Request::input('month') == '' ? date('Y-m') : Request::input('month')  }}"
                                                    autocomplete="off"
                                                    class="datepicker-month form-control  {{ Request::input('period') == 'month' ? '' : 'hilang'  }} time">

                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-info btn-flat">
                                                        <div><i class="fa fa-paper-plane"></i></div>
                                                    </button>
                                                </span>
                                                <span class="input-group-append">
                                                    <a href=" "><button type="button" class="btn btn-danger btn-flat">
                                                            <div><i class="fa fa-sync"></i></div>
                                                        </button></a>
                                                </span>
                                            </form>

                                        </div>
                                        <small class="text-muted"><i>*Default ,this date</i></small>


                                    </div>
                                </div>
                            </form>

                        </div>

                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

        </div>
        <div class="row row-sm mg-t-20">

            <div class="col-md-12 mg-t-20">
                <div class="card bd-0 shadow-base    rounded-20">
                    <div class="card-header tx-medium bd-0 bg-royal d-flex justify-content-between align-items-center"
                        style="border-radius: 122px;border-bottom-left-radius: 0px;">
                        <h6 class="card-title tx-uppercase text-white tx-12 mg-b-0">All -
                            {{app('request')->input('date')?:date('Y-m-d')}}</h6>
                        <span class="tx-12 tx-uppercase" id="dateTag1"></span>
                    </div><!-- card-header -->
                    <div class="wd-100p mg-t-20 ht-400 hilang" id="data-exist" width=""></div>
                    <div
                        class="card-body tx-gray-700  pd-t-10 pd-b-20 d-xs-flex justify-content-between align-items-center">
                        <div class="wd-100p table-responsive">
                            <div id="buttons" style="padding: 10px; margin-bottom: 10px;width: 100%;">
                                <p>Download :</p>
                            </div>
                            <table class="table  " id="table1">
                                <thead>
                                    <th class="wd-1p " width="1%">No</th>
                                    <th class=" ">Date Create</th>
                                    <th class=" ">Mix</th>
                                    <th class=" ">Start Time</th>
                                    <th class=" ">End Time</th>
                                    <th class=" ">Total Batch </th>
                                    <th class=" ">Total Time (Minute) </th>
                                    <th class=" ">Total Product (Kg)</th>
                                    <th class=" ">Corn</th>
                                    <th class=" ">Soya</th>
                                    <th class=" ">BBPT</th>

                                </thead>
                                <tbody>
                                    @foreach ($mixers as $mixer)
                                    @if ($mixer->total_actualproduct()>0)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$mixer->tstamp}}</td>
                                            <td>{{$mixer->job}}</td>
                                            <td>{{$mixer->start_tstamp}}</td>
                                            <td>{{$mixer->end_tstamp}}</td>
                                            <td>{{$mixer->total_batch}}</td>
                                            <td>{{$mixer->totalTime()}}</td>
                                            <td>{{number_format($mixer->total_actualproduct(),2,',','.') }} </td>
                                            <td>{{$mixer->total_corn()}}</td>
                                            <td>{{$mixer->total_soya()}}</td>
                                            <td>{{$mixer->total_wheat()}}</td>
                                            {{-- <td>
                                                <ul>
                                                    @foreach ($mixer->total_corn() as $item)
                                                <li>{{$item}}</li>
                                            @endforeach
                                            </ul>
                                            </td> --}}
                                        </tr>
                                    @endif

                                    @endforeach
                                    {{-- @php
                                        $no=1;
                                        $time=1;
                                        @endphp
                                        @for ($i = 0; $i < 3; $i++) <tr>
                                            <td>{{$no++}}</td>
                                    <td>{{date('Y-m-d H:i:s')}}</td>
                                    <td>{{ number_format(rand(1000,5000),0,',','.') }}</td>
                                    <td>{{ number_format(rand(1000,3000),0,',','.') }}</td>
                                    <td>{{ number_format(rand(1000,3000),0,',','.') }}</td>
                                    <td>{{ number_format(rand(1000,3000),0,',','.') }}</td>
                                    <td>{{ number_format(rand(1000,3000),0,',','.') }}</td>

                                    </tr>
                                    @endfor --}}


                                </tbody>
                            </table>

                        </div>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>
    </div>









</div><!-- br-pagebody -->

@include('layouts.partials.footer')
</div><!-- br-mainpanel -->
@endsection


@push('js')
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="{{asset('backend/js/reports/mixer.js')}}"></script>

<script>
    dataExist();
    $('.datatableG').dataTable({
        "searching": false,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });

    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        startView: 2,
        minViewMode: 0,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-area'
    });

    $('.datepicker-month').datepicker({
        format: "yyyy-mm",
        startView: 2,
        minViewMode: 1,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-area'
    });

    $('.datepicker-year').datepicker({
        format: "yyyy",
        startView: 2,
        minViewMode: 2,
        language: "id",
        daysOfWeekHighlighted: "0",
        autoclose: true,
        todayHighlight: true,
        toggleActive: true,
        container: '#datepicker-area'
    });

    $('#daterange').on('change', function () {
        val = $(this).val();
        // $('.time').val(' ');
        if (val == 'day' || val == 'minute') {
            $('.day').removeClass('hilang');
            $('.datepicker-month').addClass('hilang');
            $('.datepicker-year').addClass('hilang');
        } else if (val == 'month') {
            $('.day').addClass('hilang');
            $('.datepicker-month').removeClass('hilang');
            $('.datepicker-year').addClass('hilang');
        } else if (val == 'year') {
            $('.day').addClass('hilang');
            $('.datepicker-month').addClass('hilang');
            $('.datepicker-year').removeClass('hilang');
        }

    })


    // DATATABLE
    var base_url = "{{asset('/backend/logo.png')}}"
    var myGlyph = new Image();
    myGlyph.src = base_url;

    function getBase64Image(img) {
        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
        return canvas.toDataURL("image/png");
    }

    var table = $('#table1').DataTable();
    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [{
            extend: 'pdfHtml5',
            title: 'Report',
            orientation: 'potrait',
            pageSize: 'A4',
            className: 'btn btn-danger btn-sm btn-corner',
            text: '<i class="fas fa-file-pdf"></i>&nbsp; PDF',
            titleAttr: 'Download as PDF',
            customize: function (doc) {
                doc.content.splice(0, 0, {
                    margin: [0, 0, 0, 12],
                    alignment: 'center',
                    image: getBase64Image(myGlyph),
                    width: 140,
                    height: 40,
                });
            }
        }, {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i>&nbsp; EXCEL',
            title: 'Report',
            className: 'btn btn-success btn-sm btn-corner',
            titleAttr: 'Download as Excel'
        }, {
            extend: 'csv',
            text: '<i class="fas fa-file-csv"></i>&nbsp; CSV',
            title: 'Report',
            className: 'btn btn-info btn-sm btn-corner',
            titleAttr: 'Download as Csv'
        }, ],
    }).container().appendTo($('#buttons'));


    var table2 = $('#table2').DataTable({
        paging: false,
        'iDisplayLength': 100
    });
    var buttons = new $.fn.dataTable.Buttons(table2, {
        buttons: [{
            extend: 'pdfHtml5',
            title: 'Detail Summary',
            orientation: 'potrait',
            pageSize: 'A4',
            className: 'btn btn-danger btn-sm btn-corner',
            text: '<i class="fas fa-file-pdf"></i>&nbsp; PDF',
            titleAttr: 'Download as PDF',
            customize: function (doc) {
                doc.content.splice(0, 0, {
                    margin: [0, 0, 0, 12],
                    alignment: 'center',
                    image: getBase64Image(myGlyph),
                    width: 140,
                    height: 40,
                });
            }
        }, {
            extend: 'excelHtml5',
            text: '<i class="fas fa-file-excel"></i>&nbsp; EXCEL',
            title: 'Detail Summary',
            className: 'btn btn-success btn-sm btn-corner',
            titleAttr: 'Download as Excel'
        }, {
            extend: 'csv',
            text: '<i class="fas fa-file-csv"></i>&nbsp; CSV',
            title: 'Detail Summary',
            className: 'btn btn-info btn-sm btn-corner',
            titleAttr: 'Download as Csv'
        }, ],
    }).container().appendTo($('#buttons2'));

</script>
@endpush
