<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Masharee3') }}</title>
        @include ('layouts.tag-manager')
        
        <!-- Styles -->
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/7305a65f5a.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        @if(app()->getLocale() == 'en')
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        @else
        <link rel="stylesheet" href="{{ asset('css/ar/vendor.css') }}">
        <link rel="stylesheet" href="{{ asset('css/ar/main.css') }}">
        @endif
        <script src="{{ asset('js/vendor/modernizr.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABsCTZNfAFh0fwNrBB213BX8ROnGLUVYQ&libraries=places"></script>
        
        <link rel="stylesheet" href="{{ asset('css/bootstrap-tagsinput.css') }}">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
        <!-- Start of Masharee3 Zendesk Widget script -->
        <script>/*<![CDATA[*/window.zE||(function(e,t,s){var n=window.zE=window.zEmbed=function(){n._.push(arguments)}, a=n.s=e.createElement(t),r=e.getElementsByTagName(t)[0];n.set=function(e){ n.set._.push(e)},n._=[],n.set._=[],a.async=true,a.setAttribute("charset","utf-8"), a.src="https://static.zdassets.com/ekr/asset_composer.js?key="+s, n.t=+new Date,a.type="text/javascript",r.parentNode.insertBefore(a,r)})(document,"script","e18d3a93-b688-450b-b2d9-7a9c303f912f");/*]]>*/</script>
        <!-- End of Masharee3 Zendesk Widget script -->
        
        
    </head>
    <body class="home">
        @include ('layouts.another-tag-manager')
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        @if(app()->getLocale() == 'en')
        <script src="{{ asset('js/vendor.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        @else
        <script src="{{ asset('js/ar/vendor.js') }}"></script>
        <script src="{{ asset('js/ar/main.js') }}"></script>
        @endif
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
        <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
        <script src="{{ asset('js/bloodhound.min.js') }}"></script>
        

        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', function () {
                var places = new google.maps.places.Autocomplete(document.getElementById('location'));
                google.maps.event.addListener(places, 'place_changed', function () {

                });
            });
            
        </script>
    </body>
</html>
