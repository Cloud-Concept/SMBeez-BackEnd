<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('general.website_title') }}</title>
        @include ('layouts.tag-manager')
        
        <!-- Styles -->
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/7305a65f5a.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <script src="{{ asset('js/vendor/modernizr.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABsCTZNfAFh0fwNrBB213BX8ROnGLUVYQ&libraries=places"></script>
        
        <link rel="stylesheet" href="{{ asset('css/bootstrap-tagsinput.css') }}">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
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
        @include ('layouts.another-tag-manager')
        <div class="home-header-bg">
            <header class="cd-main-header animate-search">
                @if(app()->getLocale() == 'ar')
                <div class="cd-logo"><a href="{{route('home')}}"><img src="{{ asset('images/common/logo-ar.svg') }}" alt="Logo"></a></div>
                @else
                <div class="cd-logo"><a href="{{route('home')}}"><img src="{{ asset('images/common/logo.svg') }}" alt="Logo"></a></div>
                @endif
                <nav class="cd-main-nav-wrapper">
                    <a href="#search" class="cd-search-trigger"></a>
                    @include ('layouts.main-menu')
                </nav>
                <a href="#" class="cd-nav-trigger cd-text-replace">Menu<span></span></a>

            </header>
          
            <section class="hero here-center">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-7 py-5">
                      <img src="images/hero/hero-home.png" alt="Home" class="img-fluid">
                    </div>
                    <div class="col-md-5 py-5">
                      <h1>{{__('home.slider_headline')}}</h1>
                      <p class="mt-3">{{__('home.slider_sub_headline')}}</p>
                      <div class="btn-hero">
                            <!-- @if (!Auth::guest() && $hascompany)
                            <a href="{{route('front.company.all')}}" class="btn btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.browse_companies')}}</a>
                            @elseif(!Auth::guest() && count(Auth::user()->claims) > 0)
                            <a href="{{route('front.company.all')}}" class="btn btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.browse_companies')}}</a>
                            @elseif (!Auth::guest() && !$hascompany)
                            <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                            @elseif (!Auth::guest() && !count(Auth::user()->claims) > 0)
                            <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                            @elseif(Auth::guest())
                            <a href="{{route('login')}}?action=add-company" class="btn btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                            @endif
                            <span>{{__('home.or_title')}}</span> -->
                            @if (!Auth::guest() && !$hascompany)
                            <a href="{{route('front.industry.index')}}" class="btn btn-yellow-2"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {{__('general.browse_opportunities_button')}}</a>
                            @elseif (!Auth::guest() && $hascompany)
                            <a href="#" data-toggle="modal" data-target="#add-project" class="btn btn-yellow-2"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {{__('general.publish_project')}}</a>
                            @elseif(Auth::guest())
                            <a href="{{route('login')}}/?action=add-project" class="btn btn-yellow-2"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {{__('general.publish_project')}}</a>
                            @endif
                      </div>
                    </div>
                  </div>
                </div>
            </section>
            <a href="#next-block" class="arrow-down"><i class="fa fa-angle-down fa-2x" aria-hidden="true"></i></a>

        </div>

        @yield('content')
        @include('layouts.footer')
        <!-- Scripts -->
        <script src="{{ asset('js/vendor.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
        <script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
        <script src="{{ asset('js/bloodhound.min.js') }}"></script>
        

        <script type="text/javascript">
            /*google.maps.event.addDomListener(window, 'load', function () {
                var places = new google.maps.places.Autocomplete(document.getElementById('location'));
                google.maps.event.addListener(places, 'place_changed', function () {

                });
            });*/
            
        </script>
    </body>
</html>
