@extends('layouts.main')

@section('page_title',$page_title)
@section('css')
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

</style>
@endsection

@section('content')
<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">{{config('app.name')}}</a>
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
    <div class="row row-sm mg-t-20">
        <div class="col-md-10 mg-t-20">
            <div class="card bd-0 shadow-base  rounded-20">
                <div class="card-header tx-medium bd-0 tx-white bg-mantle d-flex justify-content-between align-items-center"
                    style="border-radius: 122px;border-bottom-left-radius: 0px;">
                    <h6 class="card-title tx-uppercase text-white tx-12 mg-b-0">{{$page_title}}</h6>
                    <span class="tx-12 tx-uppercase" id=""></span>
                </div><!-- card-header -->
                <div class="card-body">
                    <div class="">
                        <div class="">
                            <table class="table datatable1">
                                <thead>
                                    <th width="1%">NO</th>
                                    <th>TSTAMP</th>
                                    <th width="10%">DATA</th>
                                    <th width="10%">PAYLOAD</th>
                                    <th>RESPONSE</th>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($logs_api as $log)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$log->tstamp}}</td>
                                        <td><button onclick="detail('Data',{{$log->data}})" class="btn btn-info btn-sm">View</button></td>
                                        <td><button onclick="detail('Payload Token',{{$log->payload}})" class="btn btn-info btn-sm">View</button></td>
                                        {{-- <td>{{$log->payload}}</td> --}}
                                        <td>{{$log->response}}</td>
                                    </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                           
                        

                    </div>

                </div><!-- card-body -->
            </div><!-- card -->
        </div>
       

    </div>







</div><!-- br-pagebody -->

<div id="modaldemo1" class="modal fade">
        <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header  pd-y-20 pd-x-25">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail - <span id="title-trending"></span>
                    </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
    
                    <div class="card bd-0 shadow-base  rounded-20 ">
                            <textarea id="detail_json" class="form-control" rows="10"></textarea>
                    </div><!-- card -->
    
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" onclick="destroyChart()"
                        class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save
                        changes</button> --}}
                    <button type="button" class="btn btn-sm btn-danger tx-11 tx-uppercase tx-mont tx-medium"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->

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
<script src="{{url('/backend')}}/lib/jquery-ui/ui/widgets/datepicker.js"></script>
<script>
    let $select = jQuery("#bmg_monday_start_hour");

    var route_url = '{{url("api-page")}}'
    // Datepicker
    $('.fc-datepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeYear: true
    });


    function detail(param){
        
    }

    function detail(title,param) {
        $('.loader').show('fast');

        // Trigger Model
        $('#modaldemo1').modal({
            show: true
        });
        
        $('#title-trending').text(title);
         

        var str = JSON.stringify(param, undefined, 4);
        // display pretty printed object in text area:
        $('#detail_json').val(str);

      
    }

    $('#datepickerNoOfMonths').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2
    });
    for (let hr = 0; hr < 24; hr++) {

        // let hrStr = hr.toString().padStart(2, "0") + ":";
        let hrStr = hr.toString().padStart(2, "0") ;

        let val = hrStr + ":00";
        $select.append('<option value="' + hrStr + '">' + val + '</option>');

        // val = hrStr + "30";
        // $select.append('<option val="' + val + '">' + val + '</option>')

    }

    $("#e1").select2();
    $("#checkbox").click(function () {
        if ($("#checkbox").is(':checked')) {
            $("#e1 > option").prop("selected", "selected");
            $("#e1").trigger("change");
        } else {
            $("#e1 > option").removeAttr("selected");
            $("#e1").val("");
            $("#e1").trigger("change");
        }
    });

    $("#button").click(function () {
        alert($("#e1").val());
    });

    $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });
 
   


</script>
@endpush
