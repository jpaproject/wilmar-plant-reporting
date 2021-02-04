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
        <div>
            <nav class="breadcrumb pd-0 mg-0 tx-12">
                <a class="breadcrumb-item" href="index.html">{{ env('APP_SUBNAME') }}</a>
                <span class="breadcrumb-item active">{{$page_title}}</span>
            </nav>
        </div>
    </div><!-- br-pageheader -->
    

    <div class="br-pagebody mg-t-30">

        <div class="row">

            <div class="col-lg-6 mg-b-20">
                <div class="br-section-wrapper" style="padding: 30px 20px">
                    <div style="align">
                        <span class="tx-bold tx-18">{{$page_title}}</span>
                        <hr>
                        <form method="POST" action="{{ route('silo-alarm.update', $silo_alarm->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="form-group hilang">
                                <label for="">Storage</label>
                                <input class="form-control{{ $errors->has('storage_code') ? ' is-invalid' : '' }}" type="text"
                                    name="storage_code" placeholder="input storage code" value="{{$silo_alarm->storage_code}}">
                                @if ($errors->has('storage_code'))
                                <small class="text-danger">{{ $errors->first('storage_code') }}</small>
                                @endif
                            </div>

                            <div class="form-group hilang">
                                <label for="">Date</label>
                                <div class="input-group " id="datepicker-area">
                                    <input type="text" name="date" id="date" value="{{$silo_alarm->date}}" autocomplete="off" class="datepicker day form-control time {{ $errors->has('date') ? ' is-invalid' : '' }}">
                                    <br>
                                    @if ($errors->has('date'))
                                    <small class="text-danger">{{ $errors->first('date') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group hilang">
                                <label for="">Range Minimal</label>
                                <input class="form-control{{ $errors->has('range_min') ? ' is-invalid' : '' }}" type="text"
                                    name="range_min" placeholder="input Range Minimal" value="{{$silo_alarm->range_min}}">
                                @if ($errors->has('range_min'))
                                <small class="text-danger">{{ $errors->first('range_min') }}</small>
                                @endif
                            </div>

                            <div class="form-group   {{ $errors->has('formula') ? ' has-danger' : '' }}">
                                <label for="">Formula</label>
                                <br>
                                <select class="form-control  " name="formula"
                                    data-placeholder="Choose one  ">
                                   
                                   
                                    <option value="<"
                                        @if ($silo_alarm->formula =='<')
                                            {{ 'selected=selected'}}
                                        @endif
                                        >< (Lower Than)</option>
                                    <option value=">"
                                        @if ($silo_alarm->formula =='>')
                                            {{ 'selected=selected'}}
                                        @endif
                                        >> (Greater Than)</option>

                                  
                                </select>
                                @if ($errors->has('name'))
                                <small class="text-danger">{{ $errors->first('privileges') }}</small>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="">Value</label>
                                <div class="input-group">
                                    <input class="form-control{{ $errors->has('range_max') ? ' is-invalid' : '' }}" type="text"
                                    name="range_max" placeholder="input Value" value="{{$silo_alarm->range_max}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @if ($errors->has('range_max'))
                                <small class="text-danger">{{ $errors->first('range_max') }}</small>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="">Text</label>
                                <textarea name="text" class="form-control {{ $errors->has('text)') ? ' is-invalid' : '' }}" id="" cols="30" rows="3">{{$silo_alarm->text}}</textarea>
                                @if ($errors->has('text'))
                                <small class="text-danger">{{ $errors->first('text') }}</small>
                                @endif
                            </div>


                            <div class="form-group">
                                <button class="btn   btn-success" type="submit"><i class="far fa-save"></i>
                                    Save</button>
                                <a href="{{ url('setting/silo-alarm') }}"><button class="btn   btn-danger" type="button"><i
                                            class="far fa-arrow-alt-circle-left"></i> Cancel</button></a>
                            </div>
                        </form>
                    </div>
                    <hr>

                </div>

            </div>

        </div>

    </div><!-- br-pagebody -->

    @include('layouts.partials.footer')
</div><!-- br-mainpanel -->
@endsection
