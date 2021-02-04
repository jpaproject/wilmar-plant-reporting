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
            <span class="breadcrumb-item active">Trend</span>
        </nav>
    </div><!-- br-pageheader -->
    {{-- <div class="br-pagetitle">
        <i class="icon icon ion-stats-bars"></i>
        <div>
            <h4>{{$page_title}}</h4>
</div>
</div><!-- d-flex --> --}}

<div class="br-pagebody">
    <p class="hidden-lg-up tx-black mg-t-20 mg-b-0" style="">{{date('l ,d F Y')}}</p>

    <div class="bg-royal text-white rounded-20 pd-20 mg-t-40">
        <div class="row text-white pd-20">
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
    </div>

    <div class="bg-royal text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-grandeur rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/hm.png')}}" class="ht-50 rounded-circle" alt="">
            <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">kWh/Ton </h4>
        </div>
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
        <div class="row text-white">
            <div class="wd-100p mg-t-20 ht-400" id="kwh_ton" width=""></div>
        </div>
    </div>
    
    <div class="bg-royal text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-grandeur rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/hm.png')}}" class="ht-50 rounded-circle" alt="">
            <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">Tonnage </h4>
        </div>
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
        <div class="row text-white">
            <div class="wd-100p mg-t-20 ht-400" id="tonnage" width=""></div>
        </div>
    </div>

    <div class="bg-royal text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-grandeur rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/hm.png')}}" class="ht-50 rounded-circle" alt="">
            <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">System kWh </h4>
        </div>
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
        <div class="row text-white">
            <div class="wd-100p mg-t-20 ht-400" id="system-kwh" width=""></div>
        </div>
    </div>

    <div class="bg-royal text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-grandeur rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/hm.png')}}" class="ht-50 rounded-circle" alt="">
            <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">Motor kWh </h4>
        </div>
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
        <div class="row text-white">
            <div class="wd-100p mg-t-20 ht-400" id="motor-kwh" width=""></div>
        </div>
    </div>

    <div class="bg-royal text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-grandeur rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/hm.png')}}" class="ht-50 rounded-circle" alt="">
            <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">Current System</h4>
        </div>
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
        <div class="row text-white">
            <div class="wd-100p mg-t-20 ht-400" id="current" width=""></div>
        </div>
    </div>

    <div class="bg-royal text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-grandeur rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/hm.png')}}" class="ht-50 rounded-circle" alt="">
            <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">Current Motor</h4>
        </div>
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
        <div class="row text-white">
            <div class="wd-100p mg-t-20 ht-400" id="current-motor" width=""></div>
        </div>
    </div>

    <div class="bg-royal text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-grandeur rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/hm.png')}}" class="ht-50 rounded-circle" alt="">
            <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">Voltage </h4>
        </div>
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>
        <div class="row text-white">
            <div class="wd-100p mg-t-20 ht-400" id="voltage" width="" style="z-index: 99"></div>
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
    var hm1 = @json($hm1);
    var hm2 = @json($hm2);
    var hm3 = @json($hm3);

</script>
<script src="{{asset('backend/js/reports/hammer-mill-trend.js')}}"></script>

<script>
    tonnage();
    systemKwh();
    motorKwh();
    current();
    current_motor();
    voltage();
    kwhTon();
    $('.datatableG').dataTable({
        "searching": false,
        paginate: false,
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

    var table = $('#table1').DataTable({
        paging: false
    });
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
