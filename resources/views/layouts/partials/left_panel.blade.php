<div class="br-logo tx-18"><a href="#"><span></span>
        PLANT REP<i class=" icon ion-android-clipboard"></i>RTING<span></span>
        {{-- BAGGING C<i class=" icon ion-ios-pie-outline "></i>UNTING<span></span> --}}
    </a></div>
<div class="br-sideleft sideleft-scrollbar">
    <ul class="br-sideleft-menu">
        <label class="sidebar-label pd-x-10 mg-t-20 op-3">Summary</label>

        <li class="br-menu-item">
            <a href="{{url('dashboard')}}" class="br-menu-link rounded-10">
                <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
                <span class="menu-item-label">Dashboard</span>
            </a><!-- br-menu-link -->
        </li><!-- br-menu-item -->

        <label class="sidebar-label pd-x-10 mg-t-20 op-3">Report</label>

        <li class="br-menu-item">
            <a href="{{url('report/weight-bridge')}}" class="br-menu-link rounded-10">
                <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/wb-white.png')}}"
                    alt="">
                {{-- <i class="menu-item-icon icon ion-clipboard tx-20"></i> --}}
                <span class="menu-item-label">Weight Bridge</span>
            </a><!-- br-menu-link -->
            {{-- <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{url('')}}" class="sub-link">Summary</a></li>
        <li class="sub-item"><a href="{{url('')}}" class="sub-link">Trend</a></li>
        <li class="sub-item"><a href="{{url('')}}" class="sub-link">Report</a></li>

    </ul> --}}
    </li>

    {{-- <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/int.png')}}" alt="">

    <span class="menu-item-label">Intake</span>
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub">
        <li class="sub-item"><a href="{{url('')}}" class="sub-link">Summary</a></li>
        <li class="sub-item"><a href="{{url('')}}" class="sub-link">Trend</a></li>
        <li class="sub-item"><a href="{{url('')}}" class="sub-link">Report</a></li>
    </ul>
    </li> --}}

    <li class="br-menu-item">
        <a href="{{url('report/intake')}}" class="br-menu-link rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/int.png')}}" alt="">
            <span class="menu-item-label">Intake</span>
        </a><!-- br-menu-link -->
    </li>

    <li class="br-menu-item">
        <a href="{{url('report/transfer')}}" class="br-menu-link rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/int.png')}}" alt="">
            <span class="menu-item-label">Transfer</span>
        </a><!-- br-menu-link -->
    </li>


    {{-- <li class="br-menu-item">
        <a href="{{url('report/hammer-mill')}}" class="br-menu-link  rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/hm.png')}}" alt="">
            <span class="menu-item-label">Hammer Mill</span>
        </a><!-- br-menu-link -->
    </li> --}}

    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/hm.png')}}" alt="">
            <span class="menu-item-label">Hammer Mill</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item"><a href="{{url('report/hammer-mill')}}" class="sub-link">Report</a></li>
            <li class="sub-item"><a href="{{url('report/hammer-mill/trend')}}" class="sub-link">Trend</a></li>
        </ul>
    </li>

    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/pm.png')}}" alt="">
            <span class="menu-item-label">Pellet Mill</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item"><a href="{{url('report/pellet-mill')}}" class="sub-link">Report</a></li>
            <li class="sub-item"><a href="{{url('report/pellet-mill/trend')}}" class="sub-link">Trend</a></li>
        </ul>
    </li>

   


    <li class="br-menu-item">
        <a href="{{url('report/mixer')}}" class="br-menu-link  rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/mx.png')}}" alt="">
            {{-- <i class="menu-item-icon icon ion-clipboard tx-20"></i> --}}
            <span class="menu-item-label">Mixer</span>
        </a><!-- br-menu-link -->
    </li>

    <li class="br-menu-item">
        <a href="{{url('report/alarm-list')}}" class="br-menu-link  rounded-10">
            {{-- <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/mx.png')}}" alt=""> --}}
            <i class="menu-item-icon icon ion-ios-list tx-20"></i>
            <span class="menu-item-label">Alarm List</span>
        </a><!-- br-menu-link -->
    </li>
    @if (env('IS_VPS') === false)
    <li class="br-menu-item">
        <a href="{{url('report/history-log')}}" class="br-menu-link  rounded-10">
            {{-- <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/mx.png')}}" alt=""> --}}
            <i class="menu-item-icon icon ion-ios-list tx-20"></i>
            <span class="menu-item-label">History Log</span>
        </a><!-- br-menu-link -->
    </li>
    @endif



    {{-- <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub">
                <i class="menu-item-icon icon ion-clipboard tx-20"></i>
                <span class="menu-item-label">Report</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{url('')}}" class="sub-link">Weight Bridge</a>
    </li>
    <li class="sub-item"><a href="{{url('report/intake')}}" class="sub-link">Intake</a></li>
    <li class="sub-item"><a href="{{url('report/hammer-mill')}}" class="sub-link">Hammer Mill</a></li>
    <li class="sub-item"><a href="{{url('report/pellet')}}" class="sub-link">Pellet</a></li>
    <li class="sub-item"><a href="{{url('report/mixer')}}" class="sub-link">Mixer</a></li>
    </ul>
    </li>
    --}}
     {{-- <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub rounded-10">
            <i class="menu-item-icon icon ion-android-alarm-clock tx-20"></i>
            <span class="menu-item-label">Alarm</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item"><a href="{{url('alarm-list')}}" class="sub-link">Alarm Lists</a></li>
            <li class="sub-item"><a href="{{url('alarm-setting')}}" class="sub-link">Alarm Settings</a></li>
        </ul>
    </li> --}}


    @if (env('IS_VPS') === false)
        
    <label class="sidebar-label pd-x-10 mg-t-20 op-3">Setting </label>
    {{-- <li class="br-menu-item">
        <a href="{{url('setting/silo-adjustment')}}" class="br-menu-link  rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/mx.png')}}" alt="">
            <i class="menu-item-icon icon ion-android-options tx-20"></i>
            <span class="menu-item-label">Silo Adjusment <small>(ERP)</small></span>
        </a>
    </li>
    <li class="br-menu-item">
        <a href="{{url('setting/silo-actual')}}" class="br-menu-link  rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/mx.png')}}" alt="">
            <i class="menu-item-icon icon ion-android-options tx-20"></i>
            <span class="menu-item-label">Actual Silo <small>(On Hand)</small></span>
        </a>
        </li>
    <li class="br-menu-item">
        <a href="{{url('setting/silo-manual')}}" class="br-menu-link  rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/mx.png')}}" alt="">
            <i class="menu-item-icon icon ion-android-options tx-20"></i>
            <span class="menu-item-label">Manual Silo <small>(IOT)</small></span>
        </a>
        </li>
    <li class="br-menu-item">
        <a href="{{url('setting/silo-setting')}}" class="br-menu-link  rounded-10">
            <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/mx.png')}}" alt="">
            <i class="menu-item-icon icon ion-android-options tx-20"></i>
            <span class="menu-item-label">Silo Setting</span>
        </a>
    </li> --}}
    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub rounded-10">
            <i class="menu-item-icon icon icon ion-android-options tx-20"></i>
            <span class="menu-item-label">Silo Settings</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item"><a href="{{url('setting/silo-actual')}}" class="sub-link">ERP <small>(On Hand)</small></a></li>
            <li class="sub-item"><a href="{{url('setting/silo-adjustment')}}" class="sub-link">ERP <small>(Adj. Counting)</small></a></li>
            <li class="sub-item"><a href="{{url('setting/silo-manual')}}" class="sub-link">Actual <small>(Manual)</small></a></li>
            <li class="sub-item"><a href="{{url('setting/silo-setting')}}" class="sub-link">Silo Name</a></li>
        </ul>
    </li>
    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub rounded-10">
            <i class="menu-item-icon icon icon ion-ios-bell tx-20"></i>
            <span class="menu-item-label">Alarm Settings</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item"><a href="{{url('setting/dashboard-alarm')}}" class="sub-link">Alarm Dashboard</a></li>
            <li class="sub-item"><a href="{{url('setting/wb-alarm')}}" class="sub-link">Alarm Weight Bridge</a></li>
            <li class="sub-item"><a href="{{url('setting/silo-alarm')}}" class="sub-link">Alarm Silo</a></li>
            <li class="sub-item"><a href="{{url('setting/mill-alarm')}}" class="sub-link">Alarm Mill</a></li>
            <li class="sub-item"><a href="{{url('setting/voltage-alarm')}}" class="sub-link">Alarm Voltage</a></li>
            <li class="sub-item"><a href="{{url('setting/mixer-alarm')}}" class="sub-link">Alarm Mixer</a></li>
        </ul>
    </li>
    <li class="br-menu-item">
        <a href="{{url('setting/sync')}}" class="br-menu-link  rounded-10">
            {{-- <img class="menu-item-icon icon ion-clipboard tx-20" src="{{asset('backend/images/icon/mx.png')}}" alt=""> --}}
            <i class="menu-item-icon icon ion-android-sync tx-20"></i>
            <span class="menu-item-label tx-bold">Sync Setting</span>
        </a><!-- br-menu-link -->
    </li>
    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub rounded-10">
                        <i class="menu-item-icon icon ion-alert tx-20"></i>

            <span class="menu-item-label">Notification</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item"><a href="{{url('setting/notification/email')}}" class="sub-link">Email</a></li>
            <li class="sub-item"><a href="{{url('setting/notification/telegram')}}" class="sub-link">Telegram</a></li>
        </ul>
    </li>
    @endif
    

     
    <label class="sidebar-label pd-x-10 mg-t-20 op-3">master </label>


    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub rounded-10">
            <i class="menu-item-icon icon ion-folder tx-20"></i>
            <span class="menu-item-label">Master Data</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item hilang"><a href="{{url('privileges')}}" class="sub-link">Privileges</a></li>
            <li class="sub-item"><a href="{{url('departements')}}" class="sub-link">Departements</a></li>
            <li class="sub-item"><a href="{{url('users')}}" class="sub-link">Users</a></li>
        </ul>
    </li>
   

    {{-- <li class="br-menu-item">
        <a href="{{url('report/mixer')}}" class="br-menu-link  rounded-10">
            <i class="menu-item-icon icon ion-clipboard tx-20"></i>
            <span class="menu-item-label">Alarm Setting</span>
        </a><!-- br-menu-link -->
    </li> --}}

    <li class="br-menu-item">
        {{-- <a href="{{ route('logout') }}" class="br-menu-link" onclick=" event.preventDefault(); 
                    var r = confirm('Are you sure want Logout?');
                if (r == true) {
                 document.getElementById('logout-form').submit();
                } else {
                 return false
                } 
                 "><i class="menu-item-icon icon ion-power"></i>
            <span class="menu-item-label">Logout</span></a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form> --}}
        <a class=" text-white br-menu-link"
            onclick="logOut()">
            <i class="menu-item-icon icon ion-power"></i> <span class="menu-item-label">Logout</span>
        </a>
    </li><!-- br-menu-item -->

    </ul><!-- br-sideleft-menu -->

    {{-- <label class="sidebar-label pd-x-10 mg-t-25 mg-b-20 tx-info">Information Summary</label> --}}


    <br>
</div><!-- br-sideleft -->
