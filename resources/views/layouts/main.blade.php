<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SMBeez') }}</title>

        <!-- Styles -->
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
        <script src="https://use.fontawesome.com/7305a65f5a.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <script src="{{ asset('js/vendor/modernizr.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABsCTZNfAFh0fwNrBB213BX8ROnGLUVYQ&libraries=places"></script>
    </head>
    <body class="home">
        <header class="cd-main-header animate-search">
            <div class="cd-logo"><a href="#"><img src="{{ asset('images/common/logo.svg') }}" alt="Logo"></a></div>
            <nav class="cd-main-nav-wrapper">
                <a href="#search" class="cd-search-trigger"></a>
                <ul class="cd-main-nav">
                    <li><a href="#">About</a></li>
                    <li><a href="#">Companies</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Projects</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Project List#1</a> <a class="dropdown-item" href="#">Project List#2</a> <a class="dropdown-item" href="#">Project List#3</a> <a class="dropdown-item" href="#">Project List#4</a> <a class="dropdown-item" href="#">Project List#5</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Project List#4</a> <a class="dropdown-item" href="#">Project List#5</a>
                        </div>
                    </li>
                    <li><a href="#">Sign in</a></li>
                </ul>
            </nav>
            <a href="#" class="cd-nav-trigger cd-text-replace">Menu<span></span></a>
        </header>
        
        @yield('content')

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <h6 class="mb-3">What is SMBeez</h6>
                        <p>SMBeez is your local online marketplace for small and medium companies keen to do business with you. Source project opportunities and find reliable suppliers easily from the comfort of your office. Confidently do business with trusted... <a href="">more</a></p>
                    </div>
                    <div class="col-md-3">
                        <h6 class="mb-3">Stay in touch</h6>
                        <form action="" class="newsletter">
                            <div class="input-group"><input type="text" class="form-control" placeholder="E-mail" aria-label="E-mail"> <span class="input-group-btn"><button class="btn btn-blue btn-yellow" type="button"><i class="fa fa-check" aria-hidden="true"></i></button></span></div>
                        </form>
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
                        <p>Made by Cloud Concept © 2017 - All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </footer>
        <div id="search" class="cd-main-search">
            <form>
                <input type="search" placeholder="Search...">
                <div class="cd-select">
                    <span class="small-text">in</span>
                    <select name="select-category">
                        <option value="all-categories">all Categories</option>
                        <option value="category1">Category 1</option>
                        <option value="category2">Category 2</option>
                        <option value="category3">Category 3</option>
                    </select>
                    <span class="selected-value">all Categories</span>
                </div>
            </form>
            <div class="cd-search-suggestions">
                <div class="news">
                    <h3>News</h3>
                    <ul>
                        <li>
                            <a class="image-wrapper" href="#"><img src="{{ asset('images/media/placeholder.png') }}" alt="News image"></a>
                            <h4><a class="cd-nowrap" href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a></h4>
                            <time datetime="2016-01-12">Feb 03, 2016</time>
                        </li>
                        <li>
                            <a class="image-wrapper" href="#"><img src="{{ asset('images/media/placeholder.png') }}" alt="News image"></a>
                            <h4><a class="cd-nowrap" href="#">Incidunt voluptatem adipisci voluptates fugit beatae culpa eum, distinctio, assumenda est ad</a></h4>
                            <time datetime="2016-01-12">Jan 28, 2016</time>
                        </li>
                        <li>
                            <a class="image-wrapper" href="#"><img src="{{ asset('images/media/placeholder.png') }}" alt="News image"></a>
                            <h4><a class="cd-nowrap" href="#">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, esse.</a></h4>
                            <time datetime="2016-01-12">Jan 12, 2016</time>
                        </li>
                    </ul>
                </div>
                <div class="quick-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Find a store</a></li>
                        <li><a href="#">Accessories</a></li>
                        <li><a href="#">Warranty info</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                </div>
            </div>
            <a href="#" class="close cd-text-replace">Close Form</a>
        </div>
        <div class="cd-cover-layer"></div>
        <!-- Scripts -->
        <script src="{{ asset('js/vendor.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>

        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', function () {
                var places = new google.maps.places.Autocomplete(document.getElementById('location'));
                google.maps.event.addListener(places, 'place_changed', function () {

                });
            });
        </script>
    </body>
</html>
