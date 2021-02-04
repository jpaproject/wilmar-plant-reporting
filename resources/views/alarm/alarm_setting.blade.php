@extends('layouts.main')

@section('page_title',$page_title)


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


    <div class="br-pagebody  mg-t-20">

        <div class="row">

            <div class="col-lg-8 mg-b-20">
                <div class="br-section-wrapper" style="padding: 30px 20px">
                    <div style="align">
                        <span class="tx-bold tx-18"><i class="icon ion ion-android-alarm-clock tx-22"></i>
                            {{$page_title}}</span>
                        <a href="{{url('alarm-setting/create') }}">
                            <button class="btn btn-sm btn-info float-right"><i
                                    class="icon ion ion-ios-plus-outline"></i>
                                New
                                Data</button>
                        </a>
                    </div>
                    <hr>
                    @if(session()->has('create'))
                    <div class="alert alert-success wd-50p">
                        {{ session()->get('create') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session()->has('update'))
                    <div class="alert alert-warning wd-50p">
                        {{ session()->get('update') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif


                    @if(session()->has('delete'))
                    <div class="alert alert-danger wd-50p">
                        {{ session()->get('delete') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    @endif
                    <div class="table-wrapper ">
                        <table class="table display responsive nowrap" id="datatable1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>tag_name</th>
                                    <th>formula</th>
                                    <th>SP</th>
                                    <th>text</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($alarm_settings as $alarm_setting)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$alarm_setting->tag_name}}</td>
                                    <td>{{$alarm_setting->formula}}</td>
                                    <td>{{$alarm_setting->sp}}</td>
                                    <td>
                                        {{$alarm_setting->text}}
                                    </td>
                                    <td>
                                    <a href="{{route('alarm-setting.edit',$alarm_setting->id)}}">
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                        </a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteData({{$alarm_setting->id}})">Delete</button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>
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
<script>
    var route_url = 'alarm-setting';

</script>
@endpush
