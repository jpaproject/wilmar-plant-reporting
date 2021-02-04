@extends('layouts.main')

@section('page_title',$page_title)

@section('css')
    <link href="{{asset('backend')}}/lib/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <style>
        .bootstrap-tagsinput{
            width: 100%;
        }
    </style>
@endsection

    

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


    <div class="br-pagebody mg-t-30">

        <div class="row">

            <div class="col-lg-12 mg-b-20">
                <div class="br-section-wrapper" style="padding: 30px 20px">
                    <div style="align">
                        <span class="tx-bold tx-18"><i class="icon ion ion-android-options tx-22"></i>
                            {{$page_title}}</span>
                    </div>
                    <hr>
                    @if(session()->has('success-test'))
                    <div class="alert alert-success wd-100p">
                        {{ session()->get('success-test') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                     @if(session()->has('fail-test'))
                    <div class="alert alert-danger wd-100p">
                        {{ session()->get('fail-test') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif

                    @if(session()->has('create'))
                    <div class="alert alert-success wd-100p">
                        {{ session()->get('create') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session()->has('update'))
                    <div class="alert alert-warning wd-100p">
                        {{ session()->get('update') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif
                    @if(session()->has('delete'))
                    <div class="alert alert-danger wd-100p">
                        {{ session()->get('delete') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif
                    <div class="row row-sm">
                        <div class="col-lg-6">
                            <div class="card rounded-20">
                                <div class="card-body">
                                <form action="{{route('store_email')}}" method="post">
                                    @csrf
                                    <small class="tx-bold">SMTP SETTING</small>
                                        <div class="form-group">
                                            <label for="">HOST :</label>
                                             <input type="text" placeholder="" value="{{($data_settings)?$data_settings->host:''}}" name="host" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">PORT :</label>
                                             <input type="number" placeholder="" value="{{ ($data_settings)?$data_settings->port:''}}" name="port" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">USERNAME/EMAIL :</label>
                                             <input type="text" placeholder="" value="{{ ($data_settings)?$data_settings->username:''}}" name="username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">PASSWORD :</label>
                                             <input type="password" placeholder="" value="{{ ($data_settings)?$data_settings->password:''}}" name="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">ENCRYPTION :</label>
                                             <input type="text" placeholder="" value="{{ ($data_settings)?$data_settings->encryption:''}}" name="encryption" class="form-control">
                                        </div>
                                       
                                         <small class="tx-bold">FORMAT SETTING</small>
                                         <div class="form-group">
                                            <label for="" class="d-block">RECEIVERS :</label>
                                            <input class="" name="receiver" placeholder=""  type="text" value="{{ ($data_settings)?$data_settings->receiver:''}}" data-role="tagsinput">
                                            <small>Separator with coma (,)</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="">SENDER :</label>
                                             <input type="text" placeholder="" value="{{ ($data_settings)?$data_settings->sender:''}}" name="sender" class="form-control">
                                        </div>
                                        
                                        <button class="btn btn-success" type="submit">Save Config</button>
                                    </form>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card rounded-20">
                                <div class="card-body">
                                <form action="{{route('test_email')}}" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <label for="">Event :</label>
                                            <input type="text" name="event" placeholder="event name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Subject</label>
                                            <input type="text" placeholder="email subject" name="subject" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Message</label>
                                            <textarea name="message" id="" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                        <button class="btn btn-warning" type="submit">Test Email</button>
                                    </form>

                                </div>

                            </div>
                        </div>

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
<script src="{{asset('backend')}}/lib/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

<script>
    var route_url = 'silo-adjustment';

</script>
@endpush
