@extends('layouts.main')

@section('page_title',$page_title)


@section('content')
<div class="br-mainpanel">
    <div class="br-pageheader">
        <div>
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="index.html">{{ env('APP_SUBNAME') }}</a>
                <span class="breadcrumb-item active">{{$page_title}}</span>

            </nav>

        </div>
    </div><!-- br-pageheader -->


    <div class="br-pagebody  mg-t-20">

        <div class="row">

            <div class="col-lg-8 mg-b-20">
                <div class="br-section-wrapper" style="padding: 30px 20px">
                    <div style="align">
                        <span class="tx-bold tx-18"><i class="icon ion ion-android-alarm-clock tx-22"></i>
                            {{$page_title}}</span>
                        <a href="{{url('setting/mixer-alarm/create') }}">
                            <button class="btn btn-sm btn-info float-right"><i
                                    class="icon ion ion-ios-plus-outline"></i>
                                New
                                Data</button>
                        </a>
                    </div>
                    <hr>
                    @if(session()->has('create'))
                    <div class="alert alert-success wd-50p">
                        {{ session()->get('create') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session()->has('update'))
                    <div class="alert alert-warning wd-50p">
                        {{ session()->get('update') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif


                    @if(session()->has('delete'))
                    <div class="alert alert-danger wd-50p">
                        {{ session()->get('delete') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif
                    <div class="table-wrapper ">
                        <div id="buttons" style="padding: 10px; margin-bottom: 10px;width: 100%;">
                            <p>Download :</p>
                        </div>
                        <table class="table display responsive nowrap" id="tableAlarmMixer">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Material</th>
                                    {{-- <th>formula</th> --}}
                                    <th>SP</th>
                                    <th>text</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($alarm_mixers as $alarm_mixer)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$alarm_mixer->material}}</td>
                                    {{-- <td>{{$alarm_setting->formula}}</td> --}}
                                    <td>{{$alarm_mixer->sp}}</td>
                                    <td>
                                        {{$alarm_mixer->text}}
                                    </td>
                                    <td>
                                    <a href="{{url('setting/mixer-alarm/'.$alarm_mixer->id.'/edit/') }}">
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                        </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteData({{$alarm_mixer->id}})">Delete</button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                    {{-- {{ $users->link    s() }} --}}
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
    var route_url = 'mixer-alarm';
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

    var table = $('#tableAlarmMixer').DataTable();
    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [{
            extend: 'pdfHtml5',
            title: 'Alarm Mixer',
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
            title: 'Alarm Mixer',
            className: 'btn btn-success btn-sm btn-corner',
            titleAttr: 'Download as Excel'
        }, {
            extend: 'csv',
            text: '<i class="fas fa-file-csv"></i>&nbsp; CSV',
            title: 'Alarm Mixer',
            className: 'btn btn-info btn-sm btn-corner',
            titleAttr: 'Download as Csv'
        }, ],
    }).container().appendTo($('#buttons'));
</script>
@endpush
