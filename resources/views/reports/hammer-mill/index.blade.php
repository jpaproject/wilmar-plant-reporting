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
    <p class="hidden-lg-up tx-black mg-t-20 mg-b-0" style="">{{Request::input('date') == '' ? date('Y-m-d') : Request::input('date') }}</p>
    <div class="bg-dance text-white rounded-20 pd-20 mg-t-40">
        <div class="text-center d-flex  bg-royal rounded-20 pd-10 text-white"
            style="width:fit-content;margin-top: -40px;    box-shadow: -2px 13px 16px 0px rgba(0, 0, 0, 0.21);">
            <img src="{{asset('backend/images/icon/hm.png')}}" class="ht-50 rounded-circle" alt="">
            {{-- <h4 class="tx-bold mg-b-0 mg-t-10 mg-l-10 extra-bold"
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">{{$page_title}} </h4> --}}
            {{-- <form action="">
                <div class="form-group mg-b-0">
                    <div class="input-group " id="datepicker-area">
                        <input type="text" name="date" i value="" autocomplete="off"
                            class="datepicker form-control mg-r-10" required placeholder="Date From">
                        <input type="text" name="date" value="" autocomplete="off" class="datepicker form-control "
                            required placeholder="Date To">
                        <button class="btn btn-info btn-flat">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form> --}}
        </div>
        {{-- <p class="text-right hidden-sm-down" style="margin-top: -40px;">{{date('l ,d F Y')}}</p> --}}
            <p class="text-right hidden-sm-down" style="margin-top: -40px;">Date : {{Request::input('date') == '' ? date('Y-m-d') : Request::input('date') }}</p>

        <div class="row ">


            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base card__one bd-0 ht-100p rounded-20 ">

                    <div class="card-body tx-center">
                        <div class="pos-relative">
                            <div class="pos-absolute x-0 t--60">
                                <a href=""><img src="{{asset('backend/images/icon/system.png')}}" class="wd-100  "
                                        alt=""></a>
                            </div><!-- pos-relative -->
                        </div>
                        <h4 class="tx-bold tx-24  mg-t-50 tx-inverse extra-bold">Hammer Mill 1</h4>
                        <h5 class="tx-bold tx-18  mg-t-20  tx-gray-800 hover-info kwh_ton_hm1-old">{{number_format($hm1_kwh_ton ?? 0, 0,',','.')}} kWh/Ton</h5>
                        <h5 class="tx-bold tx-18  mg-t-20  tx-gray-800 hover-info kwh_ton_hm1-old">{{$pakan_hm1}}</h5>

                    </div><!-- card-body -->
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">

                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">System kWh</label>
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info kwh_hm1-old">{{number_format(($data_akumulasi_hm1->sys_kwh + $data_akumulasi_hm1->motor_kwh) ?? 0,0,',','.')}}  </span>
                            </div><!-- col -->
                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">Motor kWh</label>
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info m_kwh_hm1-old">{{number_format($data_akumulasi_hm1->motor_kwh ?? 0,0,',','.')}}  </span>
                            </div><!-- col -->
                            
                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">Tonnage</label>
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info ton_hm1-old">{{number_format($data_akumulasi_hm1->akumulasi_tonnage ?? 0,0,',','.')}} </span>
                            </div><!-- col -->


                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>

            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base card__one bd-0 ht-100p rounded-20 ">

                    <div class="card-body tx-center">
                        <div class="pos-relative">
                            <div class="pos-absolute x-0 t--60">
                                <a href=""><img src="{{asset('backend/images/icon/system.png')}}" class="wd-100  "
                                        alt=""></a>
                            </div><!-- pos-relative -->
                        </div>
                        <h4 class="tx-bold tx-24  mg-t-50 tx-inverse extra-bold">Hammer Mill 2</h4>
                        <h5 class="tx-bold tx-18  mg-t-20  tx-gray-800 hover-info kwh_ton_hm2">{{number_format($hm2_kwh_ton ?? 0, 0,',','.')}} kWh/Ton</h5>
                        <h5 class="tx-bold tx-18  mg-t-20  tx-gray-800 hover-info kwh_ton_hm2-old">{{$pakan_hm2}}</h5>

                    </div><!-- card-body -->
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">

                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">System kWh</label>
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info kwh_hm2-old">{{number_format(($data_akumulasi_hm2->sys_kwh + $data_akumulasi_hm2->motor_kwh) ?? 0,0,',','.')}}  </span>
                            </div><!-- col -->
                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">Motor kWh</label>
                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info m_kwh_hm2-old">{{number_format($data_akumulasi_hm2->motor_kwh ?? 0,0,',','.')}}  </span>
                            </div><!-- col -->

                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">Tonnage</label>

                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info ton_hm2-old">{{number_format($data_akumulasi_hm2->akumulasi_tonnage ?? 0,0,',','.')}} </span>
                            </div><!-- col -->


                        </div><!-- row -->
                    </div><!-- card-footer -->
                </div><!-- card -->
            </div>

            <div class="col-sm-6 col-lg-4  mg-t-60">
                <div class="card shadow-base card__one bd-0 ht-100p rounded-20 ">

                    <div class="card-body tx-center">
                        <div class="pos-relative">
                            <div class="pos-absolute x-0 t--60">
                                <a href=""><img src="{{asset('backend/images/icon/system.png')}}" class="wd-100  "
                                        alt=""></a>
                            </div><!-- pos-relative -->
                        </div>
                        <h4 class="tx-bold tx-24  mg-t-50 tx-inverse extra-bold">Hammer Mill 3</h4>
                        <h5 class="tx-bold tx-18  mg-t-20  tx-gray-800 hover-info kwh_ton_hm3">{{number_format($hm3_kwh_ton ?? 0, 0,',','.')}} kWh/Ton</h5>
                        <h5 class="tx-bold tx-18  mg-t-20  tx-gray-800 hover-info kwh_ton_hm3-old">{{$pakan_hm3}}</h5>

                    </div><!-- card-body -->
                    <div class="card-footer bg-transparent pd-0 bd-gray-200 mg-t-auto">
                        <div class="row no-gutters tx-center">

                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">System kWh</label>

                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info kwh_hm3-old">{{number_format(($data_akumulasi_hm3->sys_kwh + $data_akumulasi_hm3->motor_kwh)?? 0,0,',','.')}}  </span>
                            </div><!-- col -->
                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">Motor kWh</label>

                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info m_kwh_hm3-old">{{number_format($data_akumulasi_hm3->motor_kwh ?? 0,0,',','.')}}  </span>
                            </div><!-- col -->

                            <div class="col pd-y-15   bd-gray-200">
                                <label for="" class="tx-13 tx-bold   tx-gray-500">Tonnage</label>

                                <span href="" class="tx-18 tx-bold  d-block tx-gray-800 hover-info ton_hm3-old">{{number_format($data_akumulasi_hm3->akumulasi_tonnage ?? 0,0,',','.')}} </span>
                            </div><!-- col -->


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
                style="text-shadow: -3px 2px 9px #0000;letter-spacing: 1px;">Report </h4>
        </div>
        <div class="row row-sm mg-t-20">
            <div class="col-lg-6 mg-t-20">
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
                                                    <option value="day" {{ Request::input('period') == 'day' ? 'selected=selected' : ''  }}>Day (H) </option>
                                                    <option value="month" {{ Request::input('period') == 'month' ? 'selected=selected' : ''  }}>Month</option>
                                                </select>
                                            </span>
                                            <form action="">
                                                <input type="text" name="date" id="date" value="{{ Request::input('date') == '' ? date('Y-m-d') : Request::input('date')  }}" autocomplete="off"
                                                    class="datepicker form-control  {{ Request::input('period') == 'day' ? '' : (Request::input('period') == '' ? '' : 'hilang')   }} time">

                                                <input type="text" name="month" id="month" value="{{ Request::input('month') == '' ? date('Y-m') : Request::input('month')  }}" autocomplete="off"
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
            {{-- <div class="col-md-4 mg-t-20">
                <div class="card tx-gray-700 card widget-13 bd-0 shadow-base    rounded-20">

                    <div class="card-body  pd-10">
                        <div class=" ">
                            <ul class="list-group list-group-flush wd-100p">
                                <li class="list-group-item">
                                    <span class="tx-14 valign-top">
                                        Status :
                                    </span>
                                    <span id='status' class="badge badge-success">
                                        Success
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="tx-14 valign-top">
                                        Periode :
                                    </span>
                                    <span class="tx-12 align-self-center badge " id="periode">
                                        2020
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <span class="tx-14 valign-top">
                                        Process :
                                    </span>
                                    <span class="tx-12 align-self-center badge " id="voltage-t-r">
                                        {{$process}}
                                    </span>
                                </li>


                            </ul>
                        </div>

                    </div><!-- card-body -->
                </div><!-- card -->
            </div> --}}
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
                            <table class="table  " id="table1">
                                <thead>
                                    <th class="wd-1p " width="1%">No</th>
                                    <th class=" ">Date</th>
                                    <th class=" ">Hammer Mill </th>
                                    <th class=" ">Total Tonnage</th>
                                    <th class=" ">System kWh</th>
                                    <th class=" ">Motor kWh</th>
                                    <th class=" ">kWh/Ton</th>
                                    <th class=" ">Material</th>

                                </thead>
                                <tbody>
                                    {{-- @php
                                    $no=1;
                                    $time=1;
                                    $hammerMill = ['Hammer Mill 1','Hammer Mill 2','Hammer Mill 3',];
                                    @endphp
                                    @for ($i = 0; $i < 3; $i++) <tr>
                                        <td>{{$no++}}</td>
                                    <td>{{date('Y-m-d H:i:s')}}</td>
                                    <td>{{$hammerMill[$i]}}</td>
                                    <td>{{ number_format(rand(1000,5000),0,',','.') }}</td>
                                    <td>{{ number_format(rand(1000,3000),0,',','.') }}</td>
                                    <td>{{ number_format(rand(1000,3000),0,',','.') }}</td>
                                    <td>{{ number_format(rand(1000,3000),0,',','.') }}</td>

                                    </tr>
                                    @endfor --}}


                                    @foreach ($data_hms as $data_hm)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data_hm->datetime}}</td>
                                        <td>{{$data_hm->device}}</td>
                                        <td>{{number_format($data_hm->avg_tonnage ?? 0,0,',','.')}}</td>
                                        <td>{{number_format($data_hm->sys_kwh ?? 0,0,',','.')}}</td>
                                        <td>{{number_format($data_hm->motor_kwh ?? 0,0,',','.')}}</td>
                                        <td>{{number_format(($data_hm->kwh_ton?:1),0,',','.')}}
                                        </td>
                                        <td>{{$data_hm->material}}</td>

                                    </tr>
                                    @endforeach


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

<script>
    var data_chart = @json($data_chart);
</script>

<script src="{{asset('backend/js/reports/hammer-mill.js')}}"></script>

<script>
    dataExist();
    $('.datatableG').dataTable({
        "searching": false,
        paginate: true,
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


    // Websocket Realtime
    // socket.on('realtime', (data) => {
    //     console.log(data)
    //     // Hammer Mill 1
    //     let kwh_ton_hm1 = (data.hm.hm_1.kwh_motor/1000+data.hm.hm_1.kwh_system) / data.hm.hm_1.tonnage;
    //     $('.kwh_ton_hm1').text(fix_val(kwh_ton_hm1, 2) + ' kWh/Ton')
    //     $('.kwh_hm1').text(fix_val(data.hm.hm_1.kwh_system/1000, 2) + ' kWh')
    //     $('.m_kwh_hm1').text(fix_val(data.hm.hm_1.kwh_motor/1000, 2) + ' kWh')
    //     $('.ton_hm1').text(fix_val(data.hm.hm_1.tonnage, 2) + ' Ton')
        
    //     // Hammer Mill 2d
    //     let kwh_ton_hm2 = (data.hm.hm_2.kwh_motor/1000+data.hm.hm_2.kwh_system) / data.hm.hm_2.tonnage;
    //     $('.kwh_ton_hm2').text(fix_val(kwh_ton_hm2, 2) + ' kWh/Ton')
    //     $('.kwh_hm2').text(fix_val(data.hm.hm_2.kwh_system, 2) + ' kWh')
    //     $('.m_kwh_hm2').text(fix_val(data.hm.hm_2.kwh_motor/1000, 2) + ' kWh')
    //     $('.ton_hm2').text(fix_val(data.hm.hm_2.tonnage, 2) + ' Ton')
        
    //     // Hammer Mill 3
    //     let kwh_ton_hm3 = (data.hm.hm_3.kwh_motor/1000+data.hm.hm_3.kwh_system) / data.hm.hm_3.tonnage;
    //     $('.kwh_ton_hm3').text(fix_val(kwh_ton_hm3, 2) + ' kWh/Ton')
    //     $('.kwh_hm3').text(fix_val(data.hm.hm_3.kwh_system, 2) + ' kWh')
    //     $('.m_kwh_hm3').text(fix_val(data.hm.hm_3.kwh_motor/1000, 2) + ' kWh')
    //     $('.ton_hm3').text(fix_val(data.hm.hm_3.tonnage, 2) + ' Ton')
    // })

</script>
@endpush