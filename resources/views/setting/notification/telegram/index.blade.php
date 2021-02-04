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
                            <a href="{{route('create_telegram') }}">
                                <button class="btn btn-sm btn-info float-right"><i
                                        class="icon ion ion-ios-plus-outline"></i>
                                    New
                                    Data</button>
                            </a>
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
                        <div class="col-lg-8">
                            <div class="card rounded-20">
                                <div class="card-body">
                                {{-- <form action="{{route('store_telegram')}}" method="post">
                                    @csrf
                                    <small class="tx-bold">TELEGRAM SETTING</small>
                                        <div class="form-group">
                                            <label for="">BOT TOKEN :</label>
                                             <input type="text" placeholder="" value="{{($data_settings)?$data_settings->bot_token:''}}" name="bot_token" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">CHANNEL ID :</label>
                                             <input type="text" placeholder="" value="{{ ($data_settings)?$data_settings->channel_id:''}}" name="channel_id" class="form-control">
                                            <small>Ex : @username</small>
                                            </div>
                                        <button class="btn btn-success" type="submit">Save Config</button>
                                </form> --}}
                                    <div class="table-wrapper ">
                                        <table class="table display responsive nowrap" id="datatable1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Bot Token</th>
                                                    <th>Channel Id</th>
                                                    <th width="15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($telegrams as $telegram)

                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $telegram->bot_token }}</td>
                                                    <td>{{ $telegram->channel_id }}</td>
                                                    <td>
                                                    
                                                        <a href="{{route('edit_telegram', $telegram->id) }}">
                                                            <button class="btn btn-warning btn-sm text-white">
                                                                <i class="icon icon ion ion-edit"></i> Edit
                
                                                            </button>
                                                        </a>
                                                        {{-- @if (Auth::user()->id != $telegram->id) --}}
                                                            <button class="btn btn-danger btn-sm text-white"
                                                                onclick="deleteData({{$telegram->id}})">
                                                                <i class="icon icon ion ion-ios-trash-outline"></i> Delete
                                                            </button>
                                                        {{-- @endif --}}
                                                        
                                                    </td>
                                                </tr> 
                                                @endforeach
                                            </tbody>
                
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card rounded-20">
                                <div class="card-body">
                                <form action="{{route('test_telegram')}}" method="post">
                                    @csrf
                                        
                                        <div class="form-group">
                                            <label for="">Message</label>
                                            <textarea name="message" id="" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                        <button class="btn btn-warning" type="submit">Test Telegram</button>
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
    var route_url = '/setting/notification/telegram/delete';
</script>
@endpush
