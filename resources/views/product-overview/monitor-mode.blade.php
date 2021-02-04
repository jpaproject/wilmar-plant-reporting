@extends('layouts.main')

@section('page_title',$page_title)
@section('css')

<style>
    .chart {

        position: relative;

        display: inline-block;

        width: 200px;

        height: 200px;

        margin-top: 20px;

        /*margin-bottom: 20px;*/

        text-align: center;

    }

    .chart canvas {

        position: absolute;

        top: 0;

        left: 0;

    }

    .percent {

        display: inline-block;

        line-height: 200px;

        z-index: 2;

        font-weight: 600;

        font-size: 30px;

        /* color: #BBBBBB; */

    }

    .percent-simbol {

        display: inline-block;

        line-height: 200px;

        z-index: 2;

        font-weight: 600;

        font-size: 30px;

        /* color: #BBBBBB; */

    }

    .progress-group {

        text-align: left;

    }

    .progress,
    .progress>.progress-bar,
    .progress .progress-bar,
    .progress>.progress-bar .progress-bar {

        border-radius: 14px !important;

        /*background: #E288A2 !important;*/

    }

    .progress {
        height: 10px !important;
        background-color: #00bdaf1c;
    }

    .a {
        background-color: #319ec92e;
    }

    .p {
        background-color: #f292001f;
    }

    .q {
        background-color: #94c12024;
    }



    .progress-bar-light-blue,
    .progress-bar-a {
        background-color: #319EC9 !important;

    }

    .progress-bar-p {
        background-color: #F29200 !important;

    }

    .progress-bar-q {
        background-color: #94C120 !important;

    }

    .tags-overview {

        color: #645c5c;

        /*font-weight:bold;*/

    }



    .tags-percent-a {
        color: #645C5C;
        font-weight: bold;
    }

    .tags-percent-p {
        color: #645C5C;
        font-weight: bold;
    }

    .tags-percent-q {
        color: #645C5C;
        font-weight: bold;
    }

</style>
@endsection

@section('content')
<div class="br-mainpanel" >
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{url('')}}">{{ env('APP_SUBNAME') }}</a>

            <span class="breadcrumb-item active">{{$page_title}}</span>
        </nav>
    </div><!-- br-pageheader -->


    <div class="br-pagebody" id="theDiv">

        <div class="row row-sm ">



            @foreach ($products as $product)
            {{-- PRODUCT --}}
            <div class="col-sm-6 col-lg-6 col-xl-3 col-md-4 mg-t-20 animated fadeIn">
                <a href="{{url('product-overview/detail/'.$product->id)}}" data-toggle="tooltip" data-placement="top"
                    title="Product Gula Grade A">
                    <div class="card card__one shadow-base bd-0 rounded-20  mg-b-20 widget-9">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            {{-- <span class="tx-12 tx-uppercase">February 2017</span> --}}
                            <h6 class="    tx-semibold tx-inverse mg-b-5"><i class="fa fa-square"></i>
                                {{$product->name}}
                            </h6>
                            <span class="tx-semibold d-block"><i class="fa fa-barcode"></i> {{$product->code}}</span>
                        </div><!-- card-header -->

                        <div class="card-body pd-y-15">
                            <div class=" ">
                                <div class="text-center">
                                    <span class="  tags-overview text-center d-block">Quality</span>
                                    <div class="chart qty-product-{{$product->id}} mg-b-20" data-percent="">
                                        <span class="percent "></span>
                                        <p class="percent-simbol">%</p>
                                    </div>
                                </div>
                                <div class="list-group list-group-flush mg-t-10">
                                    <div class="list-group-item">
                                        <div class="tx-13 tx-inverse">
                                            <span href="#" class="wt-play"><i class="icon ion-grid"></i></span>
                                            Total Product
                                        </div>
                                        <span class="wt-time"><span class="tx-semibold tx-15"
                                                id="total-product-{{$product->id}}"> - </span> pcs</span>
                                    </div><!-- list-group-item -->
                                    <div class="list-group-item">
                                        <div class="tx-13 tx-inverse">
                                            <span href="#" class="wt-play"><i class="icon ion-happy-outline"></i></span>
                                            Good Product
                                        </div>
                                        <span class="wt-time"><span class="tx-semibold tx-15"
                                                id="good-product-{{$product->id}}"> - </span> pcs</span>
                                    </div><!-- list-group-item -->
                                    <div class="list-group-item">
                                        <div class="tx-13 tx-inverse">
                                            <span href="#" class="wt-play"><i class="icon ion-sad-outline"></i></span>
                                            Reject Product
                                        </div>
                                        <span class="wt-time"><span class="tx-semibold tx-15"
                                                id="reject-product-{{$product->id}}"> - </span> pcs</span>
                                    </div><!-- list-group-item -->
                                </div><!-- list-group -->
                            </div><!-- pd-30 -->
                        </div>

                    </div><!-- card -->
                </a>

            </div><!-- col-4 -->
            @endforeach








            {{-- <div class="col-md-4 mg-t-20">
            <div class="card bd-0 shadow-base card__one rounded-20 sensor-data">
                <div class=" card-header tx-medium bd-0 tx-white bg-mantle d-flex justify-content-between align-items-center"
                    style="border-radius: 122px;border-bottom-left-radius: 0px; ">
                    <h6 class="card-title tx-uppercase text-white  tx-12 mg-b-0">MACHINE 1</h6>
                    <span class="tx-12 tx-uppercase" id="dateTag1"></span>
                </div><!-- card-header -->
                <div class="card-body" style="padding:2px">
                    <div class="wd-100p ht-350" id="current-avg" width=""></div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div> --}}










        </div>



    </div><!-- br-pagebody -->


    @include('layouts.partials.footer')
</div><!-- br-mainpanel -->
@endsection


@push('js')
<script>
    var device = '';

</script>
{{-- <script src="{{asset('/backend/js/monitoring/monitoring.js')}}"></script> --}}
<script src="{{asset("/backend/")}}/lib/jquery-ui/ui/widgets/datepicker.js"></script>
<script src="{{asset("/backend/")}}/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset("/backend/")}}/lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src=".{{asset("/backend/")}}/ib/moment/min/moment.min.js"></script>
<script src="{{asset("/backend/")}}/lib/peity/jquery.peity.min.js"></script>
<script src="{{asset("/backend/")}}/lib/jquery-sparkline/jquery.sparkline.min.js"></script>

<script src="{{asset("/backend/")}}/lib/easypiechart/jquery.easypiechart.min.js"></script>
<script src="{{asset("/backend/")}}/js/machine-overview/machine-overview.js"></script>

<script>
   
        $('#theDiv').css({
            background:'#E8EBEE',
            position: 'fixed',
            top: '60px',
            right: 0,
            bottom: 0,
            left: 0,
            zIndex: 999
        });
   

</script>
@endpush
