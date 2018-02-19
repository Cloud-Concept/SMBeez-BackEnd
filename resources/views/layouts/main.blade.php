<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SMBeez') }}</title>

        <!-- Styles -->
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
        <script src="https://use.fontawesome.com/7305a65f5a.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <script src="{{ asset('js/vendor/modernizr.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABsCTZNfAFh0fwNrBB213BX8ROnGLUVYQ&libraries=places"></script>
    
        <!--Start of Zendesk Chat Script-->
        <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
        $.src="https://v2.zopim.com/?5Mjk89MR6gceGG9ydjLh1DPMMqDW6aT4";z.t=+new Date;$.
        type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
        </script>
        <!--End of Zendesk Chat Script-->
        
    </head>
    <body class="home">
        <header class="cd-main-header animate-search">
            <div class="cd-logo"><a href="{{route('home')}}"><img src="{{ asset('images/common/logo.svg') }}" alt="Logo"></a></div>
            <nav class="cd-main-nav-wrapper">
                <a href="#search" class="cd-search-trigger"></a>
                @include ('layouts.main-menu')
            </nav>
            <a href="#" class="cd-nav-trigger cd-text-replace">Menu<span></span></a>
        </header>
        
        @yield('content')
        @include('layouts.footer')
        <!-- Scripts -->
        <script src="{{ asset('js/vendor.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', function () {
                var places = new google.maps.places.Autocomplete(document.getElementById('location'));
                google.maps.event.addListener(places, 'place_changed', function () {

                });
            });
        </script>
    </body>
</html>
