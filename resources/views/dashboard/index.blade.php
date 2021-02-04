@extends('layouts.main')

@section('page_title',$page_title)

@section('css')
<style>
    .extra-bold {
        text-shadow: 0px 1px, 1px 0px, 1px 1px;
        letter-spacing: 1px;
    }

    .select2-container .select2-selection {
        height: 40px;
        overflow: auto;
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
        <div class="text-center bg-teal text-white rounded-20 pd-20">
            <h4>Daily</h4>
        </div>
    </div> --}}
    <div class="br-pagebody">
        <div class="bg-crystal-clear text-white rounded-20 pd-20 mg-t-50">
            <div class="text-center d-flex  bg-royal rounded-20 pd-10 text-white "
                style="margin-top: -40px;width:fit-content;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
                <img src="{{asset('backend/images/dashboard/month.png')}}" class="ht-50 mg-r-5 " alt="">

                {{-- <button class="btn btn-oblong btn-teal wd-100 mg-r-10 active">Daily</button>
                <button class="btn btn-oblong btn-teal wd-100  ">Monthly</button> --}}
                <form method="get">
                    <div class="form-group mg-b-0">
                        <div class="input-group " id="datepicker-area">
                            <input type="text" name="date_from"
                                value="{{ Request::input('date_from') ?: date('Y-m-d')  }}" autocomplete="off"
                                class="datepicker form-control mg-r-10" required placeholder="Date From">
                            <input type="text" name="date_to" value="{{ Request::input('date_to')  ?: date('Y-m-d')  }}"
                                autocomplete="off" class="datepicker form-control" required placeholder="Date To">
                            <button class="btn btn-info btn-flat">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            {{-- <p class="text-right hidden-sm-down" style="margin-top: -40px;">Daily : {{date('l ,d F Y')}}</p> --}}
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>

            <div class="row ">

                <div class="col-sm-6 col-lg-4  mg-t-60">
                    <div class="card shadow-base  bd-0  rounded-20 ">
                        <div class="card-body tx-center">
                            <div class="pos-relative">
                                <div class="pos-absolute x-0 t--60">
                                    <a href=""><img src="{{asset('backend/images/dashboard/corn.png')}}"
                                            class="wd-100 rounded-circle" alt=""></a>
                                </div><!-- pos-relative -->
                            </div>
                            <h4 class="tx-bold tx-24  mg-t-60 mg-b-5 tx-inverse  extra-bold">Corn</h4>
                        </div><!-- card-body -->
                        <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                            <div class="row no-gutters tx-center">
                                <div class="col pd-y-15">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($corn_wb,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($corn_total,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Intake
                                        {{$is_floor['corn'] ? '+ FLOOR' : ''}}</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($corn_diff,2,',','.')}}
                                        %</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                                </div><!-- col -->
                            </div><!-- row -->
                        </div><!-- card-footer -->
                    </div><!-- card -->

                    <div class="card shadow-base mg-t-10 bd-0  rounded-20 ">
                        <span class="mg-t-5 mg-b-5 text-center tx-gray-800">Date : {{$date_before}}</span>
                        <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                            <div class="row no-gutters tx-center">
                                <div class="col pd-y-15">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($corn_wb_before,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($corn_total_before->sum,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Intake
                                        {{$is_floor_before['corn'] ? '+ FLOOR' : ''}}</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($corn_diff_before,2,',','.')}}
                                        %</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                                </div><!-- col -->
                            </div><!-- row -->
                        </div><!-- card-footer -->
                    </div><!-- card -->
                </div>

                <div class="col-sm-6 col-lg-4  mg-t-60">
                    <div class="card shadow-base  bd-0   rounded-20 ">

                        <div class="card-body tx-center">
                            <div class="pos-relative">
                                <div class="pos-absolute x-0 t--60">
                                    <a href=""><img src="{{asset('backend/images/dashboard/soya.png')}}"
                                            class="wd-100 rounded-circle" alt=""></a>
                                </div><!-- pos-relative -->
                            </div>
                            <h4 class="tx-bold tx-24  mg-t-60 mg-b-5 tx-inverse extra-bold">Soya</h4>


                        </div><!-- card-body -->
                        <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                            <div class="row no-gutters tx-center">
                                <div class="col pd-y-15">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($soya_wb,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($soya_total,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Intake
                                        {{$is_floor['soya'] ? '+ FLOOR' : ''}}</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($soya_diff,2,',','.')}}
                                        %</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                                </div><!-- col -->
                            </div><!-- row -->
                        </div><!-- card-footer -->
                    </div><!-- card -->
                    <div class="card shadow-base mg-t-10 bd-0  rounded-20 ">
                        <span class="mg-t-5 mg-b-5 text-center tx-gray-800">Date : {{$date_before}}</span>
                        <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                            <div class="row no-gutters tx-center">
                                <div class="col pd-y-15">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($soya_wb_before,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($soya_total_before->sum,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Intake
                                        {{$is_floor_before['soya'] ? '+ FLOOR' : ''}}</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($soya_diff_before,2,',','.')}}
                                        %</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                                </div><!-- col -->
                            </div><!-- row -->
                        </div><!-- card-footer -->
                    </div><!-- card -->
                </div>

                <div class="col-sm-6 col-lg-4  mg-t-60">
                    <div class="card shadow-base  bd-0   rounded-20 ">

                        <div class="card-body tx-center">
                            <div class="pos-relative">
                                <div class="pos-absolute x-0 t--60">
                                    <a href=""><img src="{{asset('backend/images/dashboard/wheat.png')}}"
                                            class="wd-100 rounded-circle" alt=""></a>
                                </div><!-- pos-relative -->
                            </div>
                            <h4 class="tx-bold tx-24  mg-t-60 mg-b-5 tx-inverse extra-bold">BBPT</h4>
                            {{-- <div class="">
                                <small class="text-left tx-gray-800">Select All</small>
                                <input type="checkbox" id="checkbox-wheat">
                                <select name="" class="select2 form-control select-wheat" id="" multiple>
                                    <option value="1">WHEAT 1</option>
                                    <option value="2">WHEAT 2</option>
                                    <option value="3">WHEAT 3</option>
                                    <option value="4">WHEAT 4</option>
                                    <option value="5">WHEAT 5</option>
                                    <option value="6">WHEAT 6</option>
                                    <option value="7">WHEAT 7</option>
                                    <option value="8">WHEAT 8</option>
                                    <option value="8">WHEAT 8</option>
                                    <option value="10">WHEAT 10</option>
                                </select>
                            </div> --}}

                        </div><!-- card-body -->
                        <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                            <div class="row no-gutters tx-center">
                                <div class="col pd-y-15">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($wheat_wb,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($wheat_total,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Intake
                                        {{$is_floor['wheat'] ? '+ FLOOR' : ''}}</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($wheat_diff,2,',','.')}}
                                        %</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                                </div><!-- col -->
                            </div><!-- row -->
                        </div><!-- card-footer -->
                    </div><!-- card -->

                    <div class="card shadow-base mg-t-10 bd-0  rounded-20 ">
                        <span class="mg-t-5 mg-b-5 text-center tx-gray-800">Date : {{$date_before}}</span>
                        <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                            <div class="row no-gutters tx-center">
                                <div class="col pd-y-15">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($wheat_wb_before,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($wheat_total_before->sum,0,',','.')}}
                                        KG</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Intake
                                        {{$is_floor_before['wheat'] ? '+ FLOOR' : ''}}</small>
                                </div><!-- col -->
                                <div class="col pd-y-15 bd-l bd-gray-200">
                                    <span href=""
                                        class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{number_format($wheat_diff_before,2,',','.')}}
                                        %</span>
                                    <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                                </div><!-- col -->
                            </div><!-- row -->
                        </div><!-- card-footer -->
                    </div><!-- card -->
                </div>



            </div>
        </div>

      


        <div class=" text-white rounded-20 pd-20 mg-t-50" style="border-top: dotted 7px #20354d1a;">
            <div class="text-center d-flex  bg-royal rounded-20 pd-10 text-white wd-200"
                style=" margin:0 auto;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
                <img src="{{asset('backend/images/dashboard/storange.png')}}" class="ht-50 " alt="">
                <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                    style="text-shadow: -3px 2px 9px #4CAF50;letter-spacing: 1px;">Storage</h4>
            </div>
            {{-- <div class="row ">
                <div class="col-sm-12 col-lg-12  mg-t-60 ">
                    <div class="card shadow-base card__one bd-0 ht-100p rounded-20 bg-crystal-clear">

                        <div class="card-body tx-center">
                            <div class="pos-relative">
                                <div class="pos-absolute x-0 t--60">
                                    <a href=""><img src="{{asset('backend/images/dashboard/wsilo.png')}}"
            class="wd-100 " alt=""></a>
        </div><!-- pos-relative -->
    </div>
    <h4 class="tx-bold tx-24  mg-t-60 mg-b-5 tx-inverse text-white extra-bold">W-STORAGE</h4>
    <div class="row row-xs">
        <div class="col-lg-4">
            <div class="card shadow-base  tx-gray-800 bd-0 ht-100p rounded-20">
                <div class="card-body tx-center">
                    <span for="">W-1</span>
                    <h5 class="tx-gray-800 tx-bold">{{$w_storage['w1']}}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-base  tx-gray-800 bd-0 ht-100p rounded-20">
                <div class="card-body tx-center">
                    <span for="">W-1</span>
                    <h5 class="tx-gray-800 tx-bold">{{$w_storage['w2']}}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-base  tx-gray-800 bd-0 ht-100p rounded-20">
                <div class="card-body tx-center">
                    <span for="">W-1</span>
                    <h5 class="tx-gray-800 tx-bold">{{$w_storage['w3']}}</h5>
                </div>
            </div>
        </div>

    </div>
</div>

</div><!-- card-body -->

</div><!-- card -->
</div> --}}

<div class="col-sm-12 col-lg-12  mg-t-60">
    <div class="card shadow-base card__one bd-0 ht-100p rounded-20 bg-grandeur">

        <div class="card-body tx-center">
            <div class="pos-relative">
                <div class="pos-absolute x-0 t--60">
                    <a href=""><img src="{{asset('backend/images/dashboard/silo.png')}}" class="wd-100 " alt=""></a>
                </div><!-- pos-relative -->
            </div>
            <h4 class="tx-bold tx-24 text-white  mg-t-60 mg-b-5 tx-inverse  extra-bold">SILO-STORAGE</h4>
            <h5 class='badge badge-dark tx-14'>{{$date_silo}}</h5>
            @php
            $no=1;
            @endphp
            <div class="row row-xs mg-b-10">
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s1'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s1'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name1 ?: 'Silo 1'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s1']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos : {{ $silo_storage['s1'] ?: '0'}}</h6>

                            @if ($different['s1'] < 0) <small class="d-block text-danger tx-12">
                                <i class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s1']}}</small>
                                @elseif ($different['s1'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s1']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s1']}}</small>
                                @endif
                                {{-- <small class="d-block text-dark"></i>
                                    {{$alarm['s1']}}</small> --}}
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s1'] ?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s2'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s2'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name2 ?: 'Silo 2'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s2']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s2'] }}</h6>
                            @if ($different['s2'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s2']}}</small>
                                @elseif ($different['s2'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s2']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s2']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s2']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s3'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s3'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name3 ?: 'Silo 3'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s3']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s3'] }}</h6>
                            @if ($different['s3'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s3']}}</small>
                                @elseif ($different['s3'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s3']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s3']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s3']?: '0'}}</h6>


                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s4'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s4'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name4 ?: 'Silo 4'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s4']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s4'] }}</h6>
                            @if ($different['s4'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s4']}}</small>
                                @elseif ($different['s4'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s4']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s4']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s4']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s5'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s5'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name5 ?: 'Silo 5'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s5']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s5'] }}</h6>
                            @if ($different['s5'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s5']}}</small>
                                @elseif ($different['s5'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s5']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s5']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s5']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s6'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s6'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name6 ?: 'Silo 6'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s6']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s6'] }}</h6>
                            @if ($different['s6'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s6']}}</small>
                                @elseif ($different['s6'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s6']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s6']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s6']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s7'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s7'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif

                            <span for="">{{$silo_name7 ?: 'Silo 7'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s7']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s7'] }}</h6>
                            @if ($different['s7'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s7']}}</small>
                                @elseif ($different['s7'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s7']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s7']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s7']?: '0'}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-xs mg-b-10">
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s8'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s8'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name8 ?: 'Silo 8'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s8']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s8'] }}</h6>
                            @if ($different['s8'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s8']}}</small>
                                @elseif ($different['s8'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s8']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s8']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s8']?: '0'}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s9'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s9'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name9 ?: 'Silo 9'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s9']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s9'] }}</h6>
                            @if ($different['s9'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s9']}}</small>
                                @elseif ($different['s9'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s9']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s9']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s9']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s10'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s10'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name10 ?: 'Silo 10'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s10']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s10'] }}</h6>
                            @if ($different['s10'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s10']}}</small>
                                @elseif ($different['s10'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s10']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s10']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s10']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s11'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s11'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name11 ?: 'Silo 11'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s11']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s11'] }}</h6>
                            @if ($different['s11'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s11']}}</small>
                                @elseif ($different['s11'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s11']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s11']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s11']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s12'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s12'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name12 ?: 'Silo 12'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s12']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s12'] }}</h6>
                            @if ($different['s12'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s12']}}</small>
                                @elseif ($different['s12'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s12']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s12']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s12']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">

                            @if ($alarm['s13'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s13'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name13 ?: 'Silo 13'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s13']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s13'] }}</h6>
                            @if ($different['s13'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s13']}}</small>
                                @elseif ($different['s13'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s13']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s13']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s13']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
                <div class="col mg-b-5 ">
                    <div class="card shadow-base tx-gray-800  bd-0 ht-100p rounded-20">
                        <div class="card-body tx-center">
                            @if ($alarm['s14'] == 'gt')
                            <span class="square-10 animated fadeIn bg-success rounded-circle"></span>
                            @elseif($alarm['s14'] == 'lt')
                            <span class="square-10 animated fadeIn bg-danger rounded-circle"></span>
                            @else
                            <span class="square-10 animated fadeIn bg-info rounded-circle"></span>
                            @endif
                            <span for="">{{$silo_name14 ?: 'Silo 14'}}</span>
                            <h5 class="pd-t-10 tx-gray-800 tx-bold tx-16">ERP : {{$actual['s14']}}</h5>
                            <h6 class="tx-gray-800 tx-bold">Wincos {{ $silo_storage['s14'] }}</h6>
                            @if ($different['s14'] < 0) <small class="d-block text-danger tx-12"><i
                                    class="icon ion-arrow-graph-down-right"></i>
                                Variance {{$different['s14']}}</small>
                                @elseif ($different['s14'] == 0)
                                <small class="d-block text-primary tx-12"><i class="icon ion-checkmark-round"></i>
                                    Variance {{$different['s14']}}</small>
                                @else
                                <small class="d-block text-success tx-12"><i class="icon ion-arrow-graph-up-right"></i>
                                    Variance {{$different['s14']}}</small>
                                @endif
                                <br>
                                <h6 class="tx-gray-800 tx-bold">Actual : {{$actualMan['s14']?: '0'}}</h6>

                        </div>
                    </div>
                </div>
            </div>

        </div><!-- card-body -->

    </div><!-- card -->
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
                    <div id="buttons" style="padding: 10px; margin-bottom: 10px;width: 100%;">
                        <p>Download :</p>
                    </div>
                    <table class="table  nowrap" id="table1">
                        <thead>
                            {{-- <td class="wd-1p " width="1%">No</td> --}}

                            <tr>
                                <th class=" ">Datetime</th>
                                <th style="background:#EA890C">
                                    <p class="tx-bold">CORN</p> Weight Bridge
                                </th>
                                <th style="background:#EA890C">
                                    <p class="tx-bold">CORN</p> Intake
                                </th>
                                <th style="background:#EA890C">
                                    <p class="tx-bold">CORN</p> Diff
                                </th>
                                <th style="background: #398E3D">
                                    <p class="tx-bold">SOYA</p> Weight Bridge
                                </th>
                                <th style="background: #398E3D">
                                    <p class="tx-bold">SOYA</p> Intake
                                </th>
                                <th style="background: #398E3D">
                                    <p class="tx-bold">SOYA</p> Diff
                                </th>
                                <th style="background: #CD8D29">
                                    <p class="tx-bold">BBPT</p> Weight Bridge
                                </th>
                                <th style="background: #CD8D29">
                                    <p class="tx-bold">BBPT</p> Intake
                                </th>
                                <th style="background: #CD8D29">
                                    <p class="tx-bold">BBPT</p> Diff
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($akumulasi_hour as $ah)
                            <tr>
                                <td>{{$ah['hour']}}</td>
                                <td style="background:#ffc10659" class=" tx-15">
                                    {{number_format($ah['wb_corn'],0,',','.')}}</td>
                                <td style="background:#ffc10659" class=" tx-15">
                                    {{number_format($ah['intake_corn'],0,',','.')}}</td>
                                <td style="background:#ffc10659" class=" tx-15">
                                    {{number_format($ah['diff_corn'],2,',','.')}} %</td>
                                <td style="background: #9acd6496" class=" tx-15">
                                    {{number_format($ah['wb_soya'],0,',','.')}}</td>
                                <td style="background: #9acd6496" class=" tx-15">
                                    {{number_format($ah['intake_soya'],0,',','.')}}</td>
                                <td style="background: #9acd6496" class=" tx-15">
                                    {{number_format($ah['diff_soya'],2,',','.')}} %</td>
                                <td style="background: #f8a7228c" class=" tx-15">
                                    {{number_format($ah['wb_wheat'],0,',','.')}}</td>
                                <td style="background: #f8a7228c" class=" tx-15">
                                    {{number_format($ah['intake_wheat'],0,',','.')}}</td>
                                <td style="background: #f8a7228c" class=" tx-15">
                                    {{number_format($ah['diff_wheat'],2,',','.')}} %</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>



            </div><!-- card-body -->
        </div><!-- card -->
        @endif





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
<script>
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

    var table = $('#table1').DataTable({
        paging: false,
        'iDisplayLength': 100
    });
    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [{
            extend: 'pdfHtml5',
            title: 'Dashboard Detail',
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
            title: 'Dashboard Detail',
            className: 'btn btn-success btn-sm btn-corner',
            titleAttr: 'Download as Excel'
        }, {
            extend: 'csv',
            text: '<i class="fas fa-file-csv"></i>&nbsp; CSV',
            title: 'Dashboard Detail',
            className: 'btn btn-info btn-sm btn-corner',
            titleAttr: 'Download as Csv'
        }, ],
    }).container().appendTo($('#buttons'));
    $("#checkbox-corn").click(function () {
        if ($("#checkbox-corn").is(':checked')) {
            $(".select-corn > option").prop("selected", "selected");
            $(".select-corn").trigger("change");
        } else {
            $(".select-corn > option").removeAttr("selected");
            $(".select-corn").val("");
            $(".select-corn").trigger("change");
        }
    });

    $("#checkbox-soya").click(function () {
        if ($("#checkbox-soya").is(':checked')) {
            $(".select-soya > option").prop("selected", "selected");
            $(".select-soya").trigger("change");
        } else {
            $(".select-soya > option").removeAttr("selected");
            $(".select-soya").val("");
            $(".select-soya").trigger("change");
        }
    });

    $("#checkbox-wheat").click(function () {
        if ($("#checkbox-wheat").is(':checked')) {
            $(".select-wheat > option").prop("selected", "selected");
            $(".select-wheat").trigger("change");
        } else {
            $(".select-wheat > option").removeAttr("selected");
            $(".select-wheat").val("");
            $(".select-wheat").trigger("change");
        }
    });

</script>
@endpush
