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
                        <form method="POST" action="{{ route('voltage-alarm.update', $voltage_alarm->id) }}" enctype="multipart/form-data">
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
                             

                             

                            <div class="form-group ">
                                <label for="">Normal (V)</label>
                                <div class="input-group">
                                    <input class="form-control{{ $errors->has('normal') ? ' is-invalid' : '' }}" type="text"
                                    name="normal" placeholder="input Value" value="{{$voltage_alarm->normal}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">KG</span>
                                    </div>
                                </div>
                                @if ($errors->has('normal'))
                                <small class="text-danger">{{ $errors->first('normal') }}</small>
                                @endif
                            </div>
                            <div class="form-group ">
                                <label for="">Range (V)</label>
                                <div class="input-group">
                                    <input class="form-control{{ $errors->has('range') ? ' is-invalid' : '' }}" type="text"
                                    name="range" placeholder="input Value" value="{{$voltage_alarm->range}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">KG</span>
                                    </div>
                                </div>
                                @if ($errors->has('range'))
                                <small class="text-danger">{{ $errors->first('range') }}</small>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="">Text</label>
                                <textarea name="text" class="form-control {{ $errors->has('text)') ? ' is-invalid' : '' }}" id="" cols="30" rows="3">{{$voltage_alarm->text}}</textarea>
                                @if ($errors->has('text'))
                                <small class="text-danger">{{ $errors->first('text') }}</small>
                                @endif
                            </div>


                            <div class="form-group">
                                <button class="btn   btn-success" type="submit"><i class="far fa-save"></i>
                                    Save</button>
                                <a href="{{ url('setting/voltage-alarm') }}"><button class="btn   btn-danger" type="button"><i
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