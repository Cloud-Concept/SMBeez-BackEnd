<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:title" content="@yield('title')" />
        <meta property="og:description" content="@yield('description')" />
        <meta property="og:image" content="@yield('image')" />
        <meta property="og:url" content="{{url()->current()}}" />
        <title>{{ config('app.name', 'SMBeez') }}  @yield('title')</title>

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
        <!-- Start of smbeez Zendesk Widget script -->
        <script>/*<![CDATA[*/window.zE||(function(e,t,s){var n=window.zE=window.zEmbed=function(){n._.push(arguments)}, a=n.s=e.createElement(t),r=e.getElementsByTagName(t)[0];n.set=function(e){ n.set._.push(e)},n._=[],n.set._=[],a.async=true,a.setAttribute("charset","utf-8"), a.src="https://static.zdassets.com/ekr/asset_composer.js?key="+s, n.t=+new Date,a.type="text/javascript",r.parentNode.insertBefore(a,r)})(document,"script","e18d3a93-b688-450b-b2d9-7a9c303f912f");/*]]>*/</script>
        <!-- End of smbeez Zendesk Widget script -->
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

        @include('layouts.footer')
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
        <script src="{{ asset('js/jquery.form.min.js') }}"></script>

        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', function () {
                var places = new google.maps.places.Autocomplete(document.getElementById('location'));
                google.maps.event.addListener(places, 'place_changed', function () {

                });
            });
        </script>

        <script type="text/javascript">
            $('ul.pagination').hide();
            $(function() {
                $('.infinite-scroll').jscroll({
                    autoTrigger: true,
                    loadingHtml: '<div class="text-center"><img class="center-block" width="70" src="/images/loading.gif" alt="Loading..." /></div>',
                    padding: 0,
                    nextSelector: '.pagination li.active + li a',
                    contentSelector: 'div.infinite-scroll',
                    callback: function() {
                        $('.infinite-scroll ul.pagination').remove();
                        $(".star-rating-fn").barrating({
                            theme: "fontawesome-stars",
                            emptyValue: 0
                        });
                        $(".star-rating-ro").barrating({
                            readonly: !0,
                            hoverState: !1,
                            emptyValue: 0,
                            theme: "fontawesome-stars"
                        });
                    }
                });
                //in case of two infinite scrolls in same page
                $('.infinite-scroll-2').jscroll({
                    autoTrigger: true,
                    loadingHtml: '<div class="text-center"><img class="center-block" width="70" src="/images/loading.gif" alt="Loading..." /></div>',
                    padding: 0,
                    nextSelector: '.pagination li.active + li a',
                    contentSelector: 'div.infinite-scroll-2',
                    callback: function() {
                        $('.infinite-scroll-2 ul.pagination').remove();
                        $(".star-rating-fn").barrating({
                            theme: "fontawesome-stars",
                            emptyValue: 0
                        });
                        $(".star-rating-ro").barrating({
                            readonly: !0,
                            hoverState: !1,
                            emptyValue: 0,
                            theme: "fontawesome-stars"
                        });
                    }
                });
            });
        </script>

        <script type="text/javascript">
        jQuery(document).ready(function () {
            $('.multi-select').select2();
        });

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        var action = getParameterByName('action');
        var tab = getParameterByName('tab');

        $("document").ready(function() {
            if(action == 'add-company') {
                setTimeout(function() {
                    $("#company-add").trigger('click');
                },3);
            }
            if(action == 'add-project') {
                setTimeout(function() {
                    $("#project-add").trigger('click');
                },3);
            }

            if(action == 'write-review') {
                setTimeout(function() {
                    $("#write-review-modal").trigger('click');
                },3);
            }

            if(tab == 'customers') {
                setTimeout(function() {
                    $("#profile-tab").trigger('click');
                },3);
            }
            if(tab == 'suppliers') {
                setTimeout(function() {
                    $("#contact-tab").trigger('click');
                },3);
            }
        });
        </script>

    </body>
</html>
