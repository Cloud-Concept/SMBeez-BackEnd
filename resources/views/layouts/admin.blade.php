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
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
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
    <body class="no-hero">
        <header class="cd-main-header animate-search">
            <div class="cd-logo"><a href="{{route('home')}}"><img src="{{ asset('images/common/logo.svg') }}" alt="Logo"></a></div>
            <nav class="cd-main-nav-wrapper">
                <a href="#search" class="cd-search-trigger"></a>
                @include ('layouts.main-menu')
            </nav>
            <a href="#" class="cd-nav-trigger cd-text-replace">Menu<span></span></a>
        </header>
        
        @yield('content')

        <footer class="footer">
            <div class="container-fluid">
                <div class="row px-4">
                    <div class="col-md-9">
                        <h6 class="mb-3">What is SMBeez</h6>
                        <p>SMBeez is your local online marketplace for small and medium companies keen to do business with you. Source project opportunities and find reliable suppliers easily from the comfort of your office. Confidently do business with trusted... <a href="">more</a></p>
                    </div>
                    <div class="col-md-3">
                        @if(Auth::guest())
                        <h6 class="mb-3">Stay in touch</h6>
                        <form action="" class="newsletter">
                            <div class="input-group"><input type="text" class="form-control" placeholder="E-mail" aria-label="E-mail"> <span class="input-group-btn"><button class="btn btn-blue btn-yellow" type="button"><i class="fa fa-check" aria-hidden="true"></i></button></span></div>
                        </form>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <h6>Links</h6>
                        <ul>
                            <li><a href="">About</a></li>
                            <li><a href="">Sign Up</a></li>
                            <li><a href="">Add your company</a></li>
                            <li><a href="">Publish your project</a></li>
                            <li><a href="">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h6>Listing</h6>
                        <ul>
                            <li><a href="">Companies</a></li>
                            <li><a href="">Projects</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h6>Projects</h6>
                        <ul>
                            <li><a href="">Agriculture, Fishing,</a></li>
                            <li><a href="">and Food Services</a></li>
                            <li><a href="">Oil, Gas, and Mining</a></li>
                            <li><a href="">Utilities and Waste</a></li>
                            <li><a href="">Management</a></li>
                            <li><a href="">All Industries</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h6>Locations</h6>
                        <ul>
                            <li><a href="">Dubai</a></li>
                            <li><a href="">Abu Dhabi</a></li>
                            <li><a href="">Cairo</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <p>Made by Cloud Concept © 2018 - All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </footer>
        <div id="search" class="cd-main-search">
            <form><input type="search" placeholder="Search..."></form>
            <a href="#" class="close cd-text-replace">Close Form</a>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/vendor.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script src="{{ asset('js/jquery.jscroll.js') }}"></script>
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
