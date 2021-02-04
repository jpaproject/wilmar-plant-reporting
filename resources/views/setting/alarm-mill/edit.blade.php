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

            <div class="col-lg-6 mg-b-20">
                <div class="br-section-wrapper" style="padding: 30px 20px">
                    <div style="align">
                        <span class="tx-bold tx-18">{{$page_title}}</span>
                        <hr>
                        <form method="POST" action="{{ route('mill-alarm.update',$mill_alarm->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="">Device :</label>
                                <select readonly name="device" id="device" class="form-control mg-r-10">
                                    <option value="{{$mill_alarm->device}}">{{ucfirst($mill_alarm->device)}}</option>
                                </select>
                                @if ($errors->has('device'))
                                    <small class="text-danger">{{ $errors->first('privileges') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Material :</label>
                                <select readonly name="pakan" id="pakan" class="form-control mg-r-10">
                                    <option value="{{$mill_alarm->pakan}}">{{ucfirst($mill_alarm->pakan)}}</option>
                                    
                                    @foreach ($materials as $material=> $codes)
                                    @foreach ($codes as $code)
                                    <option value="{{$code}}" @if ($code == $mill_alarm->pakan)
                                        {{ 'selected=selected'}}
                                        @endif>{{ strtoUpper($material).' : '.$code}}</option>

                                    @endforeach
                                    @endforeach
                                </select>
                                @if ($errors->has('pakan'))
                                    <small class="text-danger">{{ $errors->first('privileges') }}</small>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="">Set Point</label>
                                <div class="input-group">
                                    <input class="form-control{{ $errors->has('set_point') ? ' is-invalid' : '' }}" type="text"
                                    name="set_point" placeholder="input value" value="{{$mill_alarm->set_point}}">
                                </div>
                                <small>Separator . (dot)</small>
                                @if ($errors->has('set_point'))
                                <small class="text-danger">{{ $errors->first('set_point') }}</small>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="">Text</label>
                                <textarea name="text" class="form-control {{ $errors->has('text)') ? ' is-invalid' : '' }}" id="" cols="30" rows="3">{{$mill_alarm->text}}</textarea>
                                @if ($errors->has('text'))
                                <small class="text-danger">{{ $errors->first('text') }}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <button class="btn   btn-success" type="submit"><i class="far fa-save"></i>
                                    Save</button>
                                <a href="{{ url('setting/mill-alarm') }}"><button class="btn   btn-danger" type="button"><i
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