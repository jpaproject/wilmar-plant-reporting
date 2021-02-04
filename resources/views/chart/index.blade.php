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

    #loader {
        position: relative;
        width: 50px;
        height: 50px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        top: 100px;
        left: 50%;
        margin-left: -25px;
        animation-name: spinner 0.4s linear infinite;
        -webkit-animation: spinner 0.4s linear infinite;
        -moz-animation: spinner 0.4s linear infinite;
    }

    #loader:before {
        position: absolute;
        content: '';
        display: block;
        background-color: rgba(0, 0, 0, 0.2);
        width: 80px;
        height: 80px;
        border-radius: 80px;
        top: -15px;
        left: -15px;
    }

    #loader:after {
        position: absolute;
        content: '';
        width: 50px;
        height: 50px;
        border-radius: 50px;
        border-top: 2px solid white;
        border-bottom: 2px solid white;
        border-left: 2px solid white;
        border-right: 2px solid transparent;
        top: -2px;
        left: -2px;
    }

    @keyframes spinner {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes spinner {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @-moz-keyframes spinner {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
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


        <div class="col-md-12 mg-t-20">
            <div class="card bd-0 shadow-base  rounded-20 sensor-data" style="cursor: pointer;">
                <div class="card-header tx-medium bd-0 tx-white bg-mantle d-flex justify-content-between align-items-center"
                    style="border-radius: 122px;border-bottom-left-radius: 0px;">
                    <h6 class="card-title tx-uppercase text-white tx-12 mg-b-0">Chart Example</h6>
                    <span class="tx-12 tx-uppercase" id="dateTag1"></span>
                </div><!-- card-header -->
                <div class="card-body  justify-content-between align-items-center">
                    <p>{{ $echart->id }}</p>
                    {!! $echart->container() !!}
                    {{-- <span id="spark1"></span> --}}
                </div><!-- card-body -->
            </div><!-- card -->
        </div>

        <div class="col-md-12 mg-t-20">
                <div class="card bd-0 shadow-base  rounded-20 sensor-data" style="cursor: pointer;">
                    <div class="card-header tx-medium bd-0 tx-white bg-mantle d-flex justify-content-between align-items-center"
                        style="border-radius: 122px;border-bottom-left-radius: 0px;">
                        <h6 class="card-title tx-uppercase text-white tx-12 mg-b-0">Chart Example</h6>
                        <span class="tx-12 tx-uppercase" id="dateTag1"></span>
                    </div><!-- card-header -->
                    <div class="card-body  justify-content-between align-items-center">
                        {!! $echart2->container() !!}
                        {{-- <span id="spark1"></span> --}}
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>

    </div>
 

</div><!-- br-pagebody -->
 
@include('layouts.partials.footer')
</div><!-- br-mainpanel -->
@endsection



@push('js')

{!! $echart->script() !!}
{!! $echart2->script() !!}

<script>
    // LOADD
window.{{ $echart2->id}};
// {{ $echart2->id}}_api_url = '{{ $echart2->api_url }}';
// {{ $echart2->id }}_refresh('{{ $echart2->api_url }}');
        // 
    //     {{ $echart2->id }}_refresh('{{ $echart2->api_url }}');
    setInterval(function(){
        {{ $echart2->id}}_api_url = "{{ $echart2->api_url}}";
        {{ $echart2->id}}_refresh();

        //  {{ $echart2->id }}_api_url = '{{ $echart2->api_url }}';
        // window.{{ $echart2->id }}_load;
        // $.ajax({
        //     type: 'GET',
        //     url: "{{ $echart2->api_url }}",
        //     dataType: 'json',
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     data: {
        //         "_token": "{{ csrf_token() }}"
        //     },
        //     success: function (res) {

        //         // $.each(data, function (k, v) {
        //         //     $('.value' + v.tag.tag_name).text(v.tag.value);
        //         //     $('.tstamp' + v.tag.tag_name).text(v.tag.created_at);

        //         // });
        //         {{ $echart2->id }}_create([{"data":res[0].data,"name":"My dataset","type":"line","smooth":true}]);




        //     },
        //     error: function (data) {
        //         console.log(data);

        //     }
        // });
        // {{ $echart2->id }}_create([{"data":[{{ $echart2->id }}_api_url],"name":"My dataset","type":"line","smooth":true}]);
        // {{ $echart2->id }}_refresh('{{ $echart2->api_url }}');

    },3000);
</script>

@endpush
