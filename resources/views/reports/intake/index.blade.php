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
    <p class="hidden-lg-up tx-black mg-t-20 mg-b-0" style="">{{date('l ,d F Y')}}</p>
    <div class="bg-dance text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-royal rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/int.png')}}" class="ht-50 rounded-circle" alt="">
            {{-- <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold  mg-r-20 "
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">{{$page_title}} </h4> --}}
            <form method="get">
                <div class="form-group mg-b-0">
                    <div class="input-group " id="datepicker-area">
                        <input type="text" name="date_from" value="{{ Request::input('date_from') ?: date('Y-m-d')  }}" autocomplete="off"
                            class="datepicker form-control mg-r-10" required placeholder="Date From">
                        <input type="text" name="date_to" value="{{ Request::input('date_to')  ?: date('Y-m-d')  }}" autocomplete="off" class="datepicker form-control "
                            required placeholder="Date To">
                        <button class="btn btn-info btn-flat">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
                    <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{ Request::input('date_from') ?: date('Y-m-d')  }} to {{ Request::input('date_to')  ?: date('Y-m-d')  }}</p>

        <div class="row">
            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base  bd-0 ht-100p rounded-20 ">
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
                            {{-- <div class="col pd-y-15">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">30.000
                                    Ton</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                            </div><!-- col --> --}}
                            <div class="col pd-y-15 bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{$corn_total}}
                                    KG</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">INTAKE {{$is_floor['corn'] ? '+ FLOOR' : ''}}</small>
                            </div><!-- col -->
                            {{-- <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">18.18 %</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                            </div><!-- col --> --}}
                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>

            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base  bd-0 ht-100p rounded-20 ">

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
                            {{-- <div class="col pd-y-15">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">30.000
                                    Ton</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                            </div><!-- col --> --}}
                            <div class="col pd-y-15  bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{$soya_total}}
                                    KG</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">INTAKE {{$is_floor['soya'] ? '+ FLOOR' : ''}}</small>
                            </div><!-- col -->
                            {{-- <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">18.18 %</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                            </div><!-- col --> --}}
                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>

            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base  bd-0 ht-100p rounded-20 ">
                    <div class="card-body tx-center">
                        <div class="pos-relative">
                            <div class="pos-absolute x-0 t--60">
                                <a href=""><img src="{{asset('backend/images/dashboard/wheat.png')}}"
                                        class="wd-100 rounded-circle" alt=""></a>
                            </div><!-- pos-relative -->
                        </div>
                        <h4 class="tx-bold tx-24  mg-t-60 mg-b-5 tx-inverse extra-bold">BBPT</h4>


                    </div><!-- card-body -->
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">
                            {{-- <div class="col pd-y-15">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">30.000
                                    Ton</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">Weight Bridge</small>
                            </div><!-- col --> --}}
                            <div class="col pd-y-15  bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">{{$wheat_total}}
                                    KG</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">INTAKE {{$is_floor['wheat'] ? '+ FLOOR' : ''}}</small>
                            </div><!-- col -->
                            {{-- <div class="col pd-y-15 bd-l bd-gray-200">
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info">18.18 %</span>
                                <small class="tx-10  tx-uppercase tx-gray-800 tx-semibold">DIFFERENCE</small>
                            </div><!-- col --> --}}
                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>


        </div>
    </div>

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
                                    <div class="col-lg-12">
                                        <small>Select Condition :</small>
                                        {{-- <form action="">
                                            <div class="form-group mg-b-0">
                                                <div class="input-group " id="datepicker-area">
                                                    <input type="text" name="date_from" i value="" autocomplete="off"
                                                        class="datepicker form-control mg-r-10" required
                                                        placeholder="Date From">
                                                    <input type="text" name="date_to" value="" autocomplete="off"
                                                        class="datepicker form-control " required placeholder="Date To">
                                                    <button class="btn btn-info btn-flat">
                                                        <i class="fa fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form> --}}
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
                                            <a href="{{url('report/intake/create')}}" class="btn btn-info mg-l-20">INTAKE FLOOR</a>


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
                        <h6 class="card-title tx-uppercase text-white tx-12 mg-b-0">All - {{app('request')->input('date')?:date('Y-m-d')}}</h6>
                        <span class="tx-12 tx-uppercase" id="dateTag1"></span>
                    </div><!-- card-header -->
                    <div class="wd-100p mg-t-20 ht-400 hilang" id="data-exist" width=""></div>
                    <div
                        class="card-body tx-gray-700  pd-t-10 pd-b-20 d-xs-flex justify-content-between align-items-center">
                        <div class="wd-100p table-responsive">
                            <div id="buttons" style="padding: 10px; margin-bottom: 10px;width: 100%;">
                                <p>Download :</p>
                            </div>
                            <table class="table nowrap" id="table1">
                                <thead>
                                    <th class="wd-1p " width="1%">No</th>
                                    <th class=" ">Datetime</th>
                                    <th class=" ">Job</th>
                                    <th class=" ">Area</th>
                                    <th class=" ">Receiver Production </th>
                                    <th class=" ">Product Name</th>
                                    <th class=" ">qty (KG)</th>
                                    <th class=" ">startTIme</th>
                                    <th class=" ">endTime</th>
                                    <th class=" ">sender Storage</th>
                                    <th class=" ">Receive Storage</th>
                                </thead>
                                <tbody>

                                    @foreach ($intakes as $intake)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$intake->datetime}}</td>
                                        <td>{{$intake->job}}</td>
                                        <td>{{$intake->type}}</td>
                                        <td>{{$intake->receiver_product_ident}}</td>
                                        <td>{{$intake->product_name}}</td>
                                        <td>{{$intake->qty}}</td>
                                        <td>{{$intake->startDate()}}</td>
                                        <td>{{$intake->endDate()}}</td>
                                        <td>{{$intake->sender}}</td>
                                        <td>{{$intake->receive}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="wd-100p table-responsive hilang ">
                            <div id="buttons" style="padding: 10px; margin-bottom: 10px;width: 100%;">
                                <p>Download :</p>
                            </div>
                            <table class="table" id="table1">
                                <thead>
                                    <th class="wd-1p " width="1%">No</th>
                                    <th class=" ">ProductName</th>
                                    <th class=" ">qty</th>
                                    <th class=" ">Day</th>
                                </thead>
                                <tbody>
                                    @php
                                    $no=1;
                                    $time=1;
                                    $ticket=18040150;
                                    @endphp
                                    @for ($i = 0; $i < 3; $i++) <tr>
                                        <td>{{$no++}}</td>
                                        <td>Meslin 3mm W1 </td>
                                        <td>129.900</td>
                                        <td>{{date('2018-04-03 H:i:s')}}</td>

                                        </tr>
                                        @endfor



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
<script src="{{asset('backend/js/reports/intake.js')}}"></script>

<script>
    totalMaterial();
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
