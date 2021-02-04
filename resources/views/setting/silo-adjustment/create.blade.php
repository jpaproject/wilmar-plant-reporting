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
                        <form method="POST" action="{{ url('setting/silo-adjustment') }}" enctype="multipart/form-data">
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
                            <div class="form-group ">
                                <label for="">Storage</label>
                                <input class="form-control{{ $errors->has('storage') ? ' is-invalid' : '' }}" type="text"
                                    name="storage" placeholder="input storage code" value="{{old('storage')}}">
                                @if ($errors->has('storage'))
                                <small class="text-danger">{{ $errors->first('storage') }}</small>
                                @endif
                            </div>
                            <div class="form-group   {{ $errors->has('formula') ? ' has-danger' : '' }}">
                                <label for="">Formula</label>
                                <br>
                                <select class="form-control  " name="formula"
                                    data-placeholder="Choose one  ">
                                   
                                   
                                    <option value="-"
                                        @if (old('formula') =='-')
                                            {{ 'selected=selected'}}
                                        @endif
                                        >- (Minus)</option>
                                    <option value="+"
                                        @if (old('formula') =='+')
                                            {{ 'selected=selected'}}
                                        @endif
                                        >+ (Plus)</option>

                                  
                                </select>
                                @if ($errors->has('name'))
                                <small class="text-danger">{{ $errors->first('privileges') }}</small>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="">Value Adjustment</label>
                                <input class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" type="number" step="0.1"
                                    name="value" placeholder="input value" value="{{old('value')}}">
                                @if ($errors->has('value'))
                                <small class="text-danger">{{ $errors->first('value') }}</small>
                                @endif
                            </div>


                            <div class="form-group">
                                <button class="btn   btn-success" type="submit"><i class="far fa-save"></i>
                                    Save</button>
                                <a href="{{ url('setting/silo-adjustment') }}"><button class="btn   btn-danger" type="button"><i
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
