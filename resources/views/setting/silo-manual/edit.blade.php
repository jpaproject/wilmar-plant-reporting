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
                        {{-- <a href="{{url('departements/create')}}"> <button
                            class="btn btn-sm btn-danger float-right"><i class="icon ion ion-ios-plus-outline"></i>
                            New
                            Data</button>
                        </a> --}}
                        <hr>
                        <form method="POST" action="{{ route('silo-manual.update', $silo_actual->id) }}" enctype="multipart/form-data">
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
                                <label for="">Storage</label>
                                <input class="form-control{{ $errors->has('storage_code') ? ' is-invalid' : '' }}" type="text"
                                    name="storage_code" placeholder="input storage code" value="{{$silo_actual->storage_code}}">
                                @if ($errors->has('storage_code'))
                                <small class="text-danger">{{ $errors->first('storage_code') }}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Date</label>
                                <div class="input-group " id="datepicker-area">
                                    <input type="text" name="date" id="date" value="{{$silo_actual->date}}" autocomplete="off" class="datepicker day form-control time {{ $errors->has('date') ? ' is-invalid' : '' }}">
                                    <br>
                                    @if ($errors->has('date'))
                                    <small class="text-danger">{{ $errors->first('date') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="">Value Actual</label>
                                <div class="input-group">
                                <input class="form-control{{ $errors->has('value_actual') ? ' is-invalid' : '' }}" type="number" step="0.1"
                                    name="value_actual" placeholder="input value" value="{{$silo_actual->value_actual}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">KG</span>
                                    </div>
                                </div>
                                @if ($errors->has('value_actual'))
                                <small class="text-danger">{{ $errors->first('value_actual') }}</small>
                                @endif
                            </div>


                            <div class="form-group">
                                <button class="btn   btn-success" type="submit"><i class="far fa-save"></i>
                                    Save</button>
                                <a href="{{ url('setting/silo-manual') }}"><button class="btn   btn-danger" type="button"><i
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
