<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{asset('backend/logo.ico')}}" />


    <title>Login Page - {{ env('APP_SUBNAME') }}</title>

    <!-- vendor css -->
    <link href="{{ asset('backend/') }}/lib/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('backend/') }}/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('icons/ionicons-2.0.1/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/fontawesome/css/all.min.css') }}">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('backend/') }}/css/bracket.css">
    <style>
    .fc-outline-dark {
        border-color: #9E9E9E ;
        color: #0A0A0A;
    }
    .fc-outline-dark:focus, .fc-outline-dark:active {
        /* border-color: #1A73E8 ; */
        border: 1.5px solid #1A73E8;
        color:  #575757 !important;
    }
    .tx-grey{
        color: #9E9E9E !important;
    }
 
</style>
</head>

<body style="overflow:hidden">

    <div class="d-flex align-items-center justify-content-center ht-100v">
        {{-- <video id="headVideo" class="pos-absolute a-0 wd-100p ht-100p object-fit-cover" autoplay muted loop>
            <source src="{{asset('videos/video4.mp4')}}" type="video/mp4">
          
        </video><!-- /video --> --}}
        {{-- <div class=" a-0 wd-100p  "> --}}
        {{-- <img src="{{asset('backend/login.jpg')}}" style="top: -19%;position: absolute;" alt="" class="img-fluid"> --}}
        {{-- </div> --}}
        <img src="{{asset('backend/login.jpg')}}" class="wd-100p ht-100p object-fit-cover" alt="">
        <div class="overlay-body bg-black-6 d-flex align-items-center justify-content-center">
            <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 rounded-20 bg-white tx-black text-center">
                {{-- <div class="signin-logo tx-center tx-18 tx-bold tx-white"><span class="tx-normal">[</span> Power <span class="tx-info">Monitoring</span> <span class="tx-normal">]</span></div> --}}
                <img class="img-fluid mg-b-10" width="70%" src="{{asset('backend/logo.png')}}" alt="">
                <div class=" tx-grey tx-semibold  tx-center mg-b-40">Plant Reporting</div>
                    @if(session()->has('validate'))
                    <span class="text-danger" role="alert">
                        <strong>{{ session()->get('validate') }}</strong>
                    </span>
                    
                    @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} " name="email" value="{{ old('email') }}" placeholder="Enter your Email / Username" required autofocus>
                        
                        @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        {{-- <input type="text" class="form-control fc-outline-dark" placeholder="Enter your username"> --}}
                    </div><!-- form-group -->
                    <div class="form-group">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}  fc-outline-dark" name="password" placeholder="Enter your password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        {{-- <input type="password" class="form-control fc-outline-dark" placeholder="Enter your password"> --}}
                        {{-- <a href="#" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a> --}}
                    </div><!-- form-group -->

                    <div class="form-group row">
                            <div class="col-md-12 tx-left">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label tx-black-6 tx-light " for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    <button type="submit" class="mg-b-10 btn btn-info btn-block">Sign In</button>
                    
                    {{-- <div class="mg-t-60 tx-center">Not yet a member? <a href="#" class="tx-info">Sign Up</a></div> --}}
                </form>
                
            </div><!-- login-wrapper -->
        </div><!-- overlay-body -->
    </div><!-- d-flex -->

    <script src="{{ asset('backend/') }}/lib/jquery/jquery.min.js"></script>
 
        <script>
        $(function () {
            'use strict';

            // Check if video can play, and play it
            var video = document.getElementById('headVideo');
            video.addEventListener('canplay', function () {
                video.play();
            });

        });
        $(window).load(function(){
  $(".col-3 input").val("");
  $(".input-effect input").focusout(function(){
    if($(this).val() != ""){
      $(this).addClass("has-content");
    }else{
    $(this).removeClass("has-content");
    }
  });
});

    </script>

</body>

</html>
