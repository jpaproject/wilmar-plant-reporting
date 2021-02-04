 <!DOCTYPE html>
 <html lang="en">

 <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="shortcut icon" href="{{asset('backend/logo.ico')}}" />
     <title>@yield('page_title') | {{ env('APP_SUBNAME') }}</title>

     <link rel="stylesheet" href="{{ asset('css/app.css') }}">
     <link rel="stylesheet" href="{{ asset('icons/ionicons-2.0.1/css/ionicons.min.css') }}">
     <link rel="stylesheet" href="{{ asset('icons/fontawesome/css/all.min.css') }}">
     <link rel="stylesheet" href="{{ asset('backend/') }}/css/bracket.css">
     <link rel="stylesheet" href="{{ asset('backend/') }}/css/custom.css">
     @yield('css')
 </head>
 @if(!isset($monitor))

 <body id="" class=" style-3">
     @else

     <body id="" class=" style-3">
         @endif
         <div id="preloader">
             <div id="loader"></div>
         </div>

         <!-- ########## START: LEFT PANEL ########## -->
         @include('layouts.partials.left_panel')
         <!-- ########## END: LEFT PANEL ########## -->

         <!-- ########## START: HEAD PANEL ########## -->
         @if(!isset($monitor))
         @include('layouts.partials.head_panel')
         @else
         @include('layouts.partials.head_panel_full')
         @endif
         <!-- ########## END: HEAD PANEL ########## -->

         <!-- ########## START: RIGHT PANEL ########## -->
         @include('layouts.partials.right_panel')
         <!-- ########## END: RIGHT PANEL ########## --->

         <!-- ########## START: MAIN PANEL ########## -->
         @yield('content')
         <!-- ########## END: MAIN PANEL ########## -->
         <audio id="myAudio">
             <source src="{{asset('sound/1.mp3')}}" type="audio/mpeg">
             Your browser does not support the audio element.
         </audio>

         <script src="{{asset('js/app.js')}}"></script>
         <script src="{{asset('backend/js/custom.js')}}"></script>
         <script>
             var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
             $('ul a').each(function () {
                 if (this.href === path) {
                     $(this).addClass('active');
                     $(this).parent().parent().parent().closest('li').find('.with-sub').addClass(
                         'show-sub active');
                 }
             });
             loadProgressBar();
            //  var socket = io('http://192.168.28.11:1010');

             function fix_val(val, del = 2) {
                 if (val != undefined || val != null) {
                     var rounded = val.toFixed(del).toString().replace('.', ","); // Round Number
                     return numberWithCommas(rounded); // Output Result
                 }
             }

             function numberWithCommas(x) {
                 return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
             }

             function deleteData(id) 
             {
                    $.confirm({
                        theme: 'material',
                        title: 'Confirm!',
                        content: 'Are you sure you want to delete data ?',
                        buttons: {
                            confirm: function () {
                                $.ajax({
                                    type: 'DELETE',
                                    url: route_url + '/' + id,
                                    dataType: 'json',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success: function (data) {
                                        location.reload();
                                    },
                                    error: function (data) {
                                        location.reload();
                                        $.alert('Failed! '+id);
                                        console.log(data);
                                    }
                                });
                            },
                            cancel: function () {
                                $.alert('Canceled!');
                            },
                        }
                    });
                }
            function logOut() {
                $.confirm({
                    theme: 'supervan',
                    title: 'Confirm!',
                    
                    content: 'Are you sure you want to exit the web?',
                    buttons: {
                        confirm: function () {
                            // $.alert('OK!');
                            document.getElementById('logout-form').submit();
                        },
                        cancel: function () {
                            location.reload()
                        },
                    }
                });
            }
            var timestamp = '<?=time();?>';
            function updateTime(){
            $('#time').html(Date(timestamp));
            timestamp++;
            }
            $(function(){
            setInterval(updateTime, 1000);
            });
         </script>

         @if($errors->any())
         <script>
             toastr.warning("{{$errors->first()}}");
         </script>
         @endif
         @if (session()->has('privilege'))
         <script>
             $.alert("{{session()->get('privilege')}}");

         </script>
         @endif

          @if (session()->has('sync'))
            <script>
                $.alert(`{{session()->get('sync')}}`);
            </script>
         @endif

         @if (session()->has('sync_fail'))
            <script>
                $.alert(`{{session()->get('sync_fail')}}`);
            </script>
         @endif

         
         {{-- ADD ON --}}
         <!-- <script src="{{asset('/backend/js/device/device.js')}}"></script> -->
         @stack('js')
     </body>

 </html>
