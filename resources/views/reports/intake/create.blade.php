@extends('layouts.main')

@section('page_title',$page_title)

@section('css')
<style>
    .select2-results__option[aria-selected=true] {
        display: none;
    }

</style>

@endsection

@section('content')
<div class="br-mainpanel">
    <div class="br-pageheader">
        <div w>
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
                        <span class="tx-bold tx-18">{{$page_title}}</span>
                        <hr>
                        <form method="POST" action="{{ url('report/intake') }}" enctype="multipart/form-data" >
                            @csrf
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label for="">Job</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('job') ? ' is-invalid' : '' }}" type="text"
                                            name="job" placeholder="" value="{{old('job')}}">
                                        </div>
                                        @if ($errors->has('job'))
                                        <small class="text-danger">{{ $errors->first('job') }}</small>
                                        @endif
                                    </div>

                                    <div class="form-group ">
                                        <label for="">Area</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('area') ? ' is-invalid' : '' }}" type="text"
                                            name="area" placeholder="" value="{{old('area')}}">
                                        </div>
                                        @if ($errors->has('area'))
                                        <small class="text-danger">{{ $errors->first('area') }}</small>
                                        @endif
                                    </div>

                                    <div class="form-group ">
                                        <label for="">Receiver Production</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('receiver_production') ? ' is-invalid' : '' }}" type="text"
                                            name="receiver_production" placeholder="" value="{{old('receiver_production')}}">
                                        </div>
                                        @if ($errors->has('receiver_production'))
                                        <small class="text-danger">{{ $errors->first('receiver_production') }}</small>
                                        @endif
                                    </div>

                                    <div class="form-group ">
                                        <label for="">Product Name</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('product_name') ? ' is-invalid' : '' }}" type="text"
                                            name="product_name" placeholder="" value="{{old('product_name')}}">
                                        </div>
                                        @if ($errors->has('product_name'))
                                        <small class="text-danger">{{ $errors->first('product_name') }}</small>
                                        @endif
                                    </div>

                                    <div class="form-group ">
                                        <label for="">Quantity</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('qty') ? ' is-invalid' : '' }}" type="text"
                                            name="qty" placeholder="" value="{{old('qty')}}">
                                        </div>
                                        @if ($errors->has('qty'))
                                        <small class="text-danger">{{ $errors->first('qty') }}</small>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group input-group" id="datepicker-area">
                                        <label for="">Start Date</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }} datepicker" type="text"
                                            name="start_date" placeholder="" value="{{old('start_date')}}">
                                        </div>
                                        @if ($errors->has('start_date'))
                                        <small class="text-danger">{{ $errors->first('start_date') }}</small>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">Start Time :</label>
                                        <select name="start_time" id="" class="form-control mg-r-10">

                                            @for ($i = 0; $i < 24; $i++) 
                                                @php $hour=$i; $hour=($hour<10) ? '0' .$hour.':00' : $hour.':00' ;
                                                @endphp 
                                                <option value="{{$hour}}">{{$hour}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="form-group input-group" id="datepicker-area">
                                        <label for="">End Date</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }} datepicker" type="text"
                                            name="end_date" placeholder="" value="{{old('end_date')}}">
                                        </div>
                                        @if ($errors->has('end_date'))
                                        <small class="text-danger">{{ $errors->first('end_date') }}</small>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="">End Time :</label>
                                        <select name="end_time" id="" class="form-control mg-r-10">

                                            @for ($i = 0; $i < 24; $i++) 
                                                @php $hour=$i; $hour=($hour<10) ? '0' .$hour.':00' : $hour.':00' ;
                                                @endphp 
                                                <option value="{{$hour}}">{{$hour}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    
                                    <div class="form-group ">
                                        <label for="">Sender Storage</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('sender') ? ' is-invalid' : '' }}" type="text"
                                            name="sender" placeholder="" value="{{old('sender')}}">
                                        </div>
                                        @if ($errors->has('sender'))
                                        <small class="text-danger">{{ $errors->first('sender') }}</small>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label for="">Receive Storage</label>
                                        <div class="input-group">
                                            <input class="form-control{{ $errors->has('receive') ? ' is-invalid' : '' }}" type="text"
                                            name="receive" placeholder="" value="{{old('receive')}}">
                                        </div>
                                        @if ($errors->has('receive'))
                                        <small class="text-danger">{{ $errors->first('receive') }}</small>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            
                            <div class="form-group float-right">
                                <button class="btn   btn-success" type="submit"><i class="far fa-save"></i>
                                    Save</button>
                                <a href="{{ url('report/intake') }}"><button class="btn   btn-danger" type="button"><i
                                            class="far fa-arrow-alt-circle-left"></i> Cancel</button></a>
                            </div>
                        </form>
                    </div>
                    <hr style="border: 0px">

                </div>

            </div>

        </div>

    </div><!-- br-pagebody -->

    @include('layouts.partials.footer')
</div><!-- br-mainpanel -->
@endsection

@push('js')
    <script>
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
    </script>
@endpush
