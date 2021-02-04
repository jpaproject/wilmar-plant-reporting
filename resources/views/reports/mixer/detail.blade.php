@extends('layouts.main')

@section('page_title',$page_title)
@section('css')
{{-- <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> --}}

<style>
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
            <span class="breadcrumb-item ">{{$page_title}}</span>
            <span class="breadcrumb-item active"> MIX1:051905</span>
        </nav>
    </div><!-- br-pageheader -->
    {{-- <div class="br-pagetitle">
        <i class="icon icon ion-stats-bars"></i>
        <div>
            <h4>{{$page_title}}</h4>
</div>
</div><!-- d-flex --> --}}

<div class="br-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-12 col-md-4 col-lg-4  col-xl-3  ">

            <div class="card   mg-b-20 animated fadeInUp  shadow-base rounded-20 widget-9  "
                style="top:80px;position: sticky">
                <div class="pd-x-20 pd-y-25">
                    <div class="d-block mg-b-30">

                        <a href="{{url('/report/mixer')}}"
                            class="btn btn-info btn-icon mg-r-5 rounded-circle float-right" data-toggle="tooltip"
                            data-placement="left" title="Back">
                            <div><i class="tx-18 icon  ion-ios-undo"></i></div>
                        </a>


                        <h5 class="tx-semibold tx-inverse mg-b-5 ">Raw Details</h5>
                    </div>



                    <div class="list-group list-group-flush mg-t-10">


                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                Job
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">MIX1:051905</span> </span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                IDFormula
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">9203WD00341</span> </span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                Total Batch
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">2</span> </span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                Qty Target
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">9600</span> </span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                Actual
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">9963</span> </span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                Product Ident
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">9203WD00341</span> </span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                Start Date
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">{{date('d/m/d H:i:s')}}</span> </span>
                        </div><!-- list-group-item -->
                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-grid"></i></a>
                                End Date
                            </div>
                            <span class="wt-time"><span class="tx-semibold tx-15">{{date('d/m/d H:i:s')}}</span> </span>
                        </div><!-- list-group-item -->


                        <div class="list-group-item">
                            <div class="tx-13 tx-inverse">
                                <a href="#" class="wt-play"><i class="icon ion-ios-download-outline"></i></a>
                                Download
                            </div>
                            <span class="wt-time">
                                <a href="{{url('/report')}}" class="btn btn-danger btn-icon  float-right"
                                    data-toggle="tooltip" data-placement="bottom" title="Download PDF">
                                    <div><i class="tx-18 fa fa-file-pdf"></i></div>
                                </a>
                                <a href="{{url('/report/mixer')}}" class="btn btn-success btn-icon mg-r-5  float-right"
                                    data-toggle="tooltip" data-placement="bottom" title="Download Excel">
                                    <div><i class="tx-18 fa fa-file-excel"></i></div>
                                </a>
                            </span>
                        </div><!-- list-group-item -->

                    </div><!-- list-group -->

                </div><!-- pd-30 -->
            </div><!-- card -->



        </div><!-- col-9 -->
        <div class="col-sm-12 col-md-8 col-lg-8  col-xl-9  ">
            <div class="card bd-0 shadow-base  rounded-20">
                <div class="card-header tx-medium bd-0 tx-white bg-mantle d-flex justify-content-between align-items-center"
                    style="border-radius: 122px;border-bottom-left-radius: 0px;">
                    <h6 class="card-title tx-uppercase text-white tx-12 mg-b-0">Raw Details : MIX1:051905</h6>
                    <span class="tx-12 tx-uppercase" id="dateTag1"></span>
                </div><!-- card-header -->
                <div class="card-body pd-t-20 pd-b-20 d-xs-flex justify-content-between align-items-center">

                    <div class="wd-100p  table-responsive">



                        <table class="table datatable2" id="">
                            <thead>
                                <th class="wd-1p " width="1%">No</th>
                                <th class=" ">IDRawmate</th>
                                <th class=" ">Rawmate Name</th>
                                <th class=" ">Qty Target</th>
                                <th class=" ">Qty Actual</th>
                               
                            </thead>
                            <tbody>
                                @php
                                $no=1;
                                $time=1;

                                $raws =array(
                                    (object)array('IDRawmate' => "9999_0034 ",  'RawmateName'=>"R/C G1+G4",'QtyTarget'=>399.994,'QtyActual'=>401 ),
                                    (object)array('IDRawmate' => "128_211500*3W1", 'RawmateName'=>"Material_02",'QtyTarget'=>4838.544,'QtyActual'=>4833 ),  
                                    (object)array('IDRawmate' => "294_024100*3E3", 'RawmateName'=>"Material_01",'QtyTarget'=>1578,'QtyActual'=>1578 ),  
                                    (object)array('IDRawmate' => "067_349700FG*3S12", 'RawmateName'=>"Material_03",'QtyTarget'=>1440,'QtyActual'=>1444 ),  
                                    (object)array('IDRawmate' => "539_007100*T2", 'RawmateName'=>"Material_04",'QtyTarget'=>595.2,'QtyActual'=>595.7 ),  
                                    (object)array('IDRawmate' => "621_905326 ",  'RawmateName'=>"Material_05",'QtyTarget'=>480,'QtyActual'=>480 ),
                                    (object)array('IDRawmate' => "238_905450 ",  'RawmateName'=>"Material_06",'QtyTarget'=>220.004,'QtyActual'=>222 ),
                                    (object)array('IDRawmate' => "176_115460 ",  'RawmateName'=>"Material_07",'QtyTarget'=>102,'QtyActual'=>101 ),
                                    (object)array('IDRawmate' => "796_511000 ",  'RawmateName'=>"Material_08",'QtyTarget'=>82.004,'QtyActual'=>83 ),
                                    (object)array('IDRawmate' => "705_510700 ",  'RawmateName'=>"Material_09",'QtyTarget'=>62.62,'QtyActual'=>62 ),
                                    (object)array('IDRawmate' => "820_060203 ",  'RawmateName'=>"PREMIX_04",'QtyTarget'=>48,'QtyActual'=>48.4 ),
                                    (object)array('IDRawmate' => "446_345400 ",  'RawmateName'=>"Material_24",'QtyTarget'=>37.996,'QtyActual'=>0.3 ),
                                    (object)array('IDRawmate' => "705_560880 ",  'RawmateName'=>"Material_10",'QtyTarget'=>31.66,'QtyActual'=>31.8 ),
                                    (object)array('IDRawmate' => "796_790270 ",  'RawmateName'=>"Material_11",'QtyTarget'=>27.196,'QtyActual'=>28.2 ),
                                    (object)array('IDRawmate' => "705_830990 ",  'RawmateName'=>"Material_12",'QtyTarget'=>14.342,'QtyActual'=>14.6 ),
                                    (object)array('IDRawmate' => "796_740000 ",  'RawmateName'=>"Material_14",'QtyTarget'=>13.804,'QtyActual'=>13.6 ),
                                    (object)array('IDRawmate' => "701_410000 ",  'RawmateName'=>"Material_15",'QtyTarget'=>9.6,'QtyActual'=>9.6 ),
                                    (object)array('IDRawmate' => "801_320000 ",  'RawmateName'=>"Material_13",'QtyTarget'=>9.6,'QtyActual'=>7.4 ),
                                    (object)array('IDRawmate' => "845_110750 ",  'RawmateName'=>"Material_17",'QtyTarget'=>7.68,'QtyActual'=>7.7 ),
                                    (object)array('IDRawmate' => "819_500020 ",  'RawmateName'=>"Material_16",'QtyTarget'=>1.748,'QtyActual'=>1.7 ),
                                );
                                @endphp

                               

                                @foreach ($raws as $raw)
                                <tr>
                                <td>{{$no++}}</td>
                                <td>{{$raw->IDRawmate}}</td>
                                <td>{{$raw->RawmateName}}</td>
                                <td>{{$raw->QtyTarget}}</td>
                                <td>{{$raw->QtyActual}}</td>
                                </tr>
                                    
                                @endforeach

                                
                            </tbody>
                        </table>

                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
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
{{-- <script src="{{asset('backend/js/trending/trending.js')}}"></script> --}}

<script>
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
            $('.datepicker').removeClass('hilang');
            $('.datepicker-month').addClass('hilang');
            $('.datepicker-year').addClass('hilang');
        } else if (val == 'month') {
            $('.datepicker').addClass('hilang');
            $('.datepicker-month').removeClass('hilang');
            $('.datepicker-year').addClass('hilang');
        } else if (val == 'year') {
            $('.datepicker').addClass('hilang');
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

</script>
@endpush
