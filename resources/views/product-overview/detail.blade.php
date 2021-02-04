@extends('layouts.main')

@section('page_title',$page_title)
@section('css')

<style>
    .machine-name:hover {
        background: #F29201 !important;
        color: #fff;
    }

    .chart {

        position: relative;

        display: inline-block;

        width: 200px;

        height: 200px;

        margin-top: 10px;

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


    /* table.table-hover tbody tr:hover {
        background-color:#fff; 
         color:#000; 
    } */

    .table {
        height: 100px;
        overflow-y: scroll;
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

    /* PROGRES LAYER 0 */
    .o {
        background-color: #37091e33;
    }

    .a {
        background-color: #28363b4d;
    }

    .p {
        background-color: #291d0c42;
    }

    .q {
        background-color: #1d270533;
    }


    /* PROGRES COLOR */
    .progress-bar-light-blue,
    .progress-bar-o {
        background-color: #D90165 !important;
    }

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
        color: #fff;
        /*font-weight:bold;*/
    }

    .tags-percent {
        color: #fff;
        font-weight: bold;
    }

    .scroll {
        /* width: 200px; */
        height: 200px;
        background: #1BAD9D;
        overflow-x: scroll;
        overflow-x: hidden;
    }

    .scroll::-webkit-scrollbar {
        width: 12px;
    }

    .scroll::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    .scroll::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
    }

    .table th,
    .table td {
        border: none;
    }

</style>
@endsection

@section('content')
<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{url('')}}">{{ env('APP_SUBNAME') }}</a>
            <a class="breadcrumb-item" href="{{url('/product-overview')}}">{{$page_title}}</a>
            <span class="breadcrumb-item">Detail</span>
            <span class="breadcrumb-item active">{{$product->name}}</span>
        </nav>

    </div><!-- br-pageheader -->
    {{-- <div class="br-pagetitle">
        <i class="icon icon ion-stats-bars"></i>
        <div>
            <h4>{{$page_title}}</h4>
</div>
</div><!-- d-flex --> --}}

<div class="br-pagebody">


    <div class="row row-sm mg-t-20 ">
        <div class="col-sm-12 col-lg-4  col-xl-3   ">

            <div class="card   mg-b-20 animated fadeInUp  shadow-base rounded-20 widget-9  "
                style="top:80px;position: sticky">
                <div class="pd-x-20 pd-y-25">
                    <div class="d-block mg-b-20">

                         <a href="{{url('/report')}}" class="btn btn-teal btn-icon rounded-circle float-right"
                            data-toggle="tooltip" data-placement="bottom" title="Report">
                            <div><i class="tx-18 icon  ion-clipboard"></i></div>
                        </a>    
                        <a href="{{url('/')}}" class="btn btn-info btn-icon mg-r-5 rounded-circle float-right"
                            data-toggle="tooltip" data-placement="left" title="Product Overview">
                            <div><i class="tx-18 icon  ion-ios-undo"></i></div>
                        </a>
                       

                        <h4 class="    tx-semibold tx-inverse mg-b-5 ">Production Details</h4>
                    </div>
                    <div class="text-center">
                        <span class="d-block">Quality</span>
                        <div class="chart qty-product-1 mg-b-20" data-percent="">
                            <span class="percent"></span>
                            <p class="percent-simbol">%</p>
                        </div>
                    </div>


                    <div class="list-group list-group-flush mg-t-10">
                        <div class="list-group-item">
                            <div class="tx-14 tx-inverse wd-100p ">
                                {{-- <a href="#" class="wt-play"><i class="icon ion-play"></i></a> --}}
                                <span class="d-block"> <i class="fa fa-square"></i> {{$product->name}} </span>
                                <span class="tx-roboto d-block"><i class="fa fa-barcode"></i> {{$product->code}}</span>
                            </div>

                        </div><!-- list-group-item -->

                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                Total Product
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">10.563</span> pcs</span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-happy-outline"></i></a>
                                Good Product
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">9600</span> pcs</span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-sad-outline"></i></a>
                                Reject Product
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">400</span> pcs</span>
                        </div><!-- list-group-item -->

                    </div><!-- list-group -->

                </div><!-- pd-30 -->
            </div><!-- card -->



        </div><!-- col-9 -->



        {{-- MACHINE TRENDING --}}
        <div class="col-sm-12 col-lg-8 col-xl-9  ">
            {{-- TRENDING --}}
            
                <div class="card   shadow-base bd-0 pd-25 rounded-20 animated fadeIn slower" data-select2-id="10">
                    <div class="d-md-flex justify-content-between align-items-center" data-select2-id="9">
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1">{{$product->name}} : TRENDING</h6>
                    </div>
                    <div class=" card-body  text-center" style="padding:0px">
                    <div class="wd-100p ht-500" id="current1" width=""></div>
                </div><!-- card-body -->
                </div><!-- d-flex -->
                
           
        </div>




    </div>


</div>


</div><!-- col-4 -->






















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

<script src="{{asset("/backend/")}}/js/machine-overview/machine-overview-detail.js"></script>

<script>
    

</script>

@endpush
