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

            <div class="col-lg-7 mg-b-20">
                <div class="br-section-wrapper" style="padding: 30px 20px">
                    <div style="align">
                        <span class="tx-bold tx-18">
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
                        <div class="col-lg-12">
                            <div class="card rounded-20">
                                <div class="card-body">
                                <form action="{{route('store_telegram')}}" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <label for="">BOT TOKEN :</label>
                                             <input type="text" placeholder="" value="{{old('bot_token')}}" name="bot_token" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">CHANNEL ID :</label>
                                             <input type="text" placeholder="" value="{{ old('channel_id') }}" name="channel_id" class="form-control">
                                            <small>Ex : @username</small>
                                            </div>
                                        <div class="form-group">
                                            <button class="btn   btn-success" type="submit"><i class="far fa-save"></i>
                                                Save</button>
                                            <a href="{{ url('setting/notification/telegram') }}"><button class="btn   btn-danger" type="button"><i
                                                        class="far fa-arrow-alt-circle-left"></i> Cancel</button></a>
            
                                        </div>
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
