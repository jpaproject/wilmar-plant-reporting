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


    <div class="br-pagebody mg-t-20">

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
                        <form method="POST" action="{{ route('alarm-setting.update', $alarm_setting->id) }}">
                            @method('PUT')
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
                            <div class="form-group {{ $errors->has('tag_name') ? ' has-danger' : '' }}">
                                <label for="">Tag Name</label>
                                <br>
                                <select class="form-control select2 " name="tag_name">
                                    <option value="tonnage_hm1" {{$alarm_setting->tag_name=="tonnage_hm1"? 'selected':''}}>Tonnage Hammer Mill 1</option>
                                    <option value="kwh_ton_hm1" {{$alarm_setting->tag_name=="kwh_ton_hm1"? 'selected':''}}>kWh/Ton Hammer Mill 1</option>
                                </select>
                                @if ($errors->has('tag_name'))
                                <small class="text-danger">{{ $errors->first('tag_name') }}</small>
                                @endif
                            </div>
                            <div class="form-group  {{ $errors->has('formula') ? ' has-danger' : '' }}">
                                <label for="">Formula</label>
                                <br>
                                <select class="form-control select2 " name="formula">
                                    <option value=">" {{$alarm_setting->formula==">"? 'selected':''}}>></option>
                                    <option value=">=" {{$alarm_setting->formula==">="? 'selected':''}}>>=</option>
                                    <option value="==" {{$alarm_setting->formula=="=="? 'selected':''}}>==</option>
                                    <option value="<" {{$alarm_setting->formula=="<"? 'selected':''}}><</option>
                                    <option value="<=" {{$alarm_setting->formula=="<="? 'selected':''}}><=</option>
                                </select>
                                @if ($errors->has('formula'))
                                <small class="text-danger">{{ $errors->first('formula') }}</small>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label for="">Set Point</label>
                                <input class="form-control{{ $errors->has('sp') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" lang="en" 
                                    name="sp" placeholder="input sp" value="{{$alarm_setting->sp}}">
                                @if ($errors->has('sp'))
                                <small class="text-danger">{{ $errors->first('sp') }}</small>
                                @endif
                            </div>


                            <div class="form-group ">
                                <label for="">Text</label>
                                <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" type="text"
                                    name="text" placeholder="input text" value="{{$alarm_setting->text}}">
                                @if ($errors->has('text'))
                                <small class="text-danger">{{ $errors->first('text') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <button class="btn   btn-success" type="submit"><i class="far fa-save"></i>
                                    Save</button>
                                <a href="{{ url('alarm-setting') }}"><button class="btn   btn-danger" type="button"><i
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


@push('js')
<script>

</script>

 
@endpush
