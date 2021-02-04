<div class="br-header">
    <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a>
        </div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i
                    class="icon ion-navicon-round"></i></a></div>

        <div class="input-group   wd-200 transition " style="    border-right: 0px !Important">
            <div class="wd-100p ht-100p   pd-5 pd-x-15">
                <img class="img-fluid " style="height:-webkit-fill-available" src="{{asset('backend/logo.png')}}"
                    alt="">
            </div>
            {{-- <span> BAGGING C<i class=" icon ion-ios-timer-outline"></i>UNTING SYSTEM --}}
        </div>

    </div><!-- br-header-left -->
    <div class="br-header-right">
        <nav class="nav">

            <a href="#" class="nav-link " >
                    <span class="logged-name hidden-md-down" style="margin-top:5px" id="time">
                        {{-- {{date('Y-m-d H:i:s')}} --}}
                    </span>
                </a>

            <div class="dropdown">
                
                <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name hidden-md-down">
                        @php
                        $fullName = explode(' ',Auth::user()->name);
                        echo $fullName[0];
                        @endphp
                    </span>
                    <img src="{{ asset('backend/')}}/images/users/{{ Auth::user()->avatar }}"
                        class="wd-32 rounded-circle" alt="">
                    {{-- <img src="{{ asset('backend/')}}/images/users/1582088463.jpg" class="wd-32 rounded-circle"
                    alt=""> --}}
                    <span class="square-10 bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-250">
                    <div class="tx-center">
                        <a href="#"><img src="{{ asset('backend/')}}/images/users/{{ Auth::user()->avatar }}"
                                class="wd-80 rounded-circle" alt=""></a>
                        <h6 class="logged-fullname">{{ Auth::user()->name }}</h6>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                    <hr>
                    <div class="tx-center">
                        <span class="profile-earning-label">{{ Auth::user()->departement->name }}</span>

                    </div>
                    <hr>

                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="{{url('users/'.Auth::user()->id.'/edit')}}"><i class="icon ion-ios-person"></i>
                                Edit Profile</a></li>

                        <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="icon ion-power"></i> Sign Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </li>
                    </ul>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </nav>
        {{-- <div class="navicon-right">
            <a id="theButton" href="{{url('monitor')}}" target="_blank" class="pos-relative">
                <button class="btn pd-y-5  btn-info " data-toggle="tooltip" data-placement="bottom"
                    title="Full Monitoring">
                    <i class="tx-20 icon  ion-ios-monitor-outline"></i>
                </button>
            </a>
        </div><!-- navicon-right --> --}}
    </div><!-- br-header-right -->
</div><!-- br-header -->
