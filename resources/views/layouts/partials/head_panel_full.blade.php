<div class="br-header">
    <div class="br-header-left">
        {{-- <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a>
        </div> --}}
        {{-- <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i
                    class="icon ion-navicon-round"></i></a></div> --}}

        <div class="input-group   wd-200 transition " style="    border-right: 0px !Important">
            <div class="wd-100p ht-100p   pd-5">
                <img class="img-fluid " style="height:-webkit-fill-available" src="{{asset('backend/logo.png')}}"
                    alt="">
            </div>
            {{-- <span> BAGGING C<i class=" icon ion-ios-timer-outline"></i>UNTING SYSTEM --}}
        </div>

    </div><!-- br-header-left -->
    <div class="br-header-right">
        <nav class="nav">



           
        </nav>
        <div class="navicon-right">
            {{-- <button class="btn   btn-info float-right">Full Mode</button> --}}
            <a id="theButton" href="{{url('/')}}" target="_blank" class="pos-relative">
                <button class="btn pd-y-5  btn-info " data-toggle="tooltip" data-placement="bottom"
                    title="Main Display">
                    <i class="tx-20 icon  ion-log-in"></i>
                </button>
                <!-- start: if statement -->
                {{-- <span class="square-8 bg-danger pos-absolute t-10 r--5 rounded-circle"></span> --}}
                <!-- end: if statement -->
            </a>
        </div><!-- navicon-right -->
    </div><!-- br-header-right -->
</div><!-- br-header -->
