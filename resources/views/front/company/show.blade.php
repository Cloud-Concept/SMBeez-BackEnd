@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box-block-white vcard vcard-company">
                        <h4><img src="{{ asset($company->logo_url) }}" alt="{{$company->company_name}} Logo"> <a href="" class="btn-more pull-right"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></h4>
                        <div class="media"><img class="img-fluid img-full" src="{{ asset($company->cover_url) }}" alt=""></div>
                        <div class="p-3">
                            <h2 class="mt-2"><i class="fa fa-address-card" aria-hidden="true"></i> {{$company->company_name}}</h2>
                            <ul class="list-unstyled details-box">
                                <li>Industry: <a href="{{route('front.industry.show', $company->industries[0]->slug)}}">{{$company->industries[0]->industry_name}}</a></li>
                                <li>Speciality: <span>
                                    @foreach($company->specialities as $speciality)
                                        {{$speciality->speciality_name . ','}} 
                                    @endforeach
                                </span></li>
                            </ul>
                            @if (Auth::guest() || Auth::user()->id != $company->user_id)
                            <div class="text-center my-3"></div>
                            @elseif(Auth::user()->id == $company->user_id)
                            <div class="text-center my-3"><button class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> Edit Company</button></div>
                            @elseif ($company->user_id == '0')
                            <div class="text-center my-3"><button class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> Claim company</button></div>
                            @endif


                            <h3>Contact info</h3>
                            <ul class="list-unstyled details-box vcard-list">
                                <li>
                                    <span class="pull-left"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    <div class="pull-left">{{$company->location}}</div>
                                </li>
                                <li>
                                    <span class="pull-left"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="tel:{{$company->company_phone}}">{{$company->company_phone}}</a></div>
                                </li>
                                <li>
                                    <span class="pull-left"><i class="fa fa-globe" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="{{$company->company_website}}">{{$company->company_website}}</a></div>
                                </li>
                                <li>
                                    <span class="pull-left"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="">{{$company->company_email}}</a></div>
                                </li>
                                <li>
                                    <span class="pull-left"><i class="fa fa-linkedin" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="">{{$company->linkedin_url}}</a></div>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="hero-company-details">
                        <h1>{{$company->company_name}}</h1>
                        <h2>{{$company->company_tagline}}</h2>
                        <div class="star-rating">
                            <ul class="list-inline">
                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                <li class="list-inline-item thumb-review"><a href="">(35 Reviews)</a></li>
                            </ul>
                        </div>
                        <div class="hero-shadow"></div>
                    </div>
                    <div class="company-tabs">
                        <ul class="nav d-flex nav-tabs mt-5" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false">Profile</a></li>
                            <li class="nav-item"><a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Reviews from Customers</a></li>
                            <li class="nav-item mr-auto"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Reviews from Suppliers</a></li>
                            <li><button class="btn btn-blue btn-yellow pull-right btn-sm" data-toggle="modal" data-target="#reviewModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Write a Review</button></li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade pt-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                           	{!!$company->company_description!!}
                            <h3 class="mb-4 mt-5">Closed projects</h3>
                            <div class="row equal">
                                @foreach($closed_projects as $project)
                                   <div class="col-md-6">
                                        <div class="project-box box-block mb-3">
                                            <p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p>
                                            <p>{{strip_tags($project->project_description)}}</p>
                                            <p class="tags">More in: 
                                                @foreach($company->industries as $industry)
                                                    <a href="{{route('front.industry.show', $industry->slug)}}">{{$industry->industry_name}}</a>
                                                @endforeach
                                            </p>
                                        </div>
                                    </div> 
                                @endforeach   
                            </div>
                        </div>
                        <div class="tab-pane fade active show pt-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="review-bar">
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="list-inline-item thumb-review"><a href="">(Customers Overall Rating)</a></li>
                                        <li class="list-inline-item thumb-review"><a href="">(243 Reviews from Customers)</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="review-block">
                                <div class="review-content">
                                    <div class="media br-btm mb-4 d-flex row equal">
                                        <div class="col-md-2"><img class="img-fluid img-full mb-3" src="../images/media/placeholder.png" alt="Generic placeholder image"></div>
                                        <div class="col-lg-7 col-md-10 mb-4">
                                            <h5 class="mt-0">Samy Gerges</h5>
                                            <p>LCD screens are uniquely modern in style, and the liquid crystals that make them work have allowed humanity to create slimmer, more portable technology than we’ve ever had access to before. From your wrist watch to your laptop, a lot of the on the go electronics that we tote from place to place are only possible because of their thin, light LCD display screens... <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i></a></p>
                                            <ul class="review-content-social">
                                                <li><a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                <li><a href=""><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                <li><a href="" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Selection Process</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Value for Money</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Delivery Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media br-btm mb-4 d-flex row equal">
                                        <div class="col-md-2"><img class="img-fluid img-full mb-3" src="../images/media/placeholder.png" alt="Generic placeholder image"></div>
                                        <div class="col-lg-7 col-md-10 mb-4">
                                            <h5 class="mt-0">Samy Gerges</h5>
                                            <p>LCD screens are uniquely modern in style, and the liquid crystals that make them work have allowed humanity to create slimmer, more portable technology than we’ve ever had access to before. From your wrist watch to your laptop, a lot of the on the go electronics that we tote from place to place are only possible because of their thin, light LCD display screens... <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i></a></p>
                                            <ul class="review-content-social">
                                                <li><a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                <li><a href=""><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                <li><a href="" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Selection Process</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Value for Money</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Delivery Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media d-flex row equal">
                                        <div class="col-md-2"><img class="img-fluid img-full mb-3" src="../images/media/placeholder.png" alt="Generic placeholder image"></div>
                                        <div class="col-lg-7 col-md-10 mb-4">
                                            <h5 class="mt-0">Samy Gerges</h5>
                                            <p>LCD screens are uniquely modern in style, and the liquid crystals that make them work have allowed humanity to create slimmer, more portable technology than we’ve ever had access to before. From your wrist watch to your laptop, a lot of the on the go electronics that we tote from place to place are only possible because of their thin, light LCD display screens... <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i></a></p>
                                            <ul class="review-content-social">
                                                <li><a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                <li><a href=""><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                <li><a href="" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Selection Process</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Value for Money</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Delivery Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade pt-4" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="review-bar">
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                        <li class="list-inline-item thumb-review"><a href="">(Customers Overall Rating)</a></li>
                                        <li class="list-inline-item thumb-review"><a href="">(243 Reviews from Customers)</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="review-block">
                                <div class="review-content">
                                    <div class="media br-btm mb-4 d-flex row equal">
                                        <div class="col-md-2"><img class="img-fluid img-full mb-3" src="../images/media/placeholder.png" alt="Generic placeholder image"></div>
                                        <div class="col-lg-7 col-md-10 mb-4">
                                            <h5 class="mt-0">Samy Gerges</h5>
                                            <p>LCD screens are uniquely modern in style, and the liquid crystals that make them work have allowed humanity to create slimmer, more portable technology than we’ve ever had access to before. From your wrist watch to your laptop, a lot of the on the go electronics that we tote from place to place are only possible because of their thin, light LCD display screens... <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i></a></p>
                                            <ul class="review-content-social">
                                                <li><a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                <li><a href=""><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                <li><a href="" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Selection Process</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Value for Money</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Delivery Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media br-btm mb-4 d-flex row equal">
                                        <div class="col-md-2"><img class="img-fluid img-full mb-3" src="../images/media/placeholder.png" alt="Generic placeholder image"></div>
                                        <div class="col-lg-7 col-md-10 mb-4">
                                            <h5 class="mt-0">Samy Gerges</h5>
                                            <p>LCD screens are uniquely modern in style, and the liquid crystals that make them work have allowed humanity to create slimmer, more portable technology than we’ve ever had access to before. From your wrist watch to your laptop, a lot of the on the go electronics that we tote from place to place are only possible because of their thin, light LCD display screens... <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i></a></p>
                                            <ul class="review-content-social">
                                                <li><a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                <li><a href=""><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                <li><a href="" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Selection Process</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Value for Money</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Delivery Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media d-flex row equal">
                                        <div class="col-md-2"><img class="img-fluid img-full mb-3" src="../images/media/placeholder.png" alt="Generic placeholder image"></div>
                                        <div class="col-lg-7 col-md-10 mb-4">
                                            <h5 class="mt-0">Samy Gerges</h5>
                                            <p>LCD screens are uniquely modern in style, and the liquid crystals that make them work have allowed humanity to create slimmer, more portable technology than we’ve ever had access to before. From your wrist watch to your laptop, a lot of the on the go electronics that we tote from place to place are only possible because of their thin, light LCD display screens... <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i></a></p>
                                            <ul class="review-content-social">
                                                <li><a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                <li><a href=""><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                <li><a href="" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Selection Process</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Value for Money</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Delivery Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                            <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade modal-fullscreen" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">Write A Review</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="" class="write-review">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label for="recipient-name" class="col-form-label">What is your relation to company</label></div>
                                <div class="form-group form-bg"><label class="custom-control custom-radio"><input id="radio1" name="radio" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">I am a Customer</span></label><label class="custom-control custom-radio"><input id="radio2" name="radio" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">I am A Supplier</span></label></div>
                                <div class="form-group"><label for="recipient-name" class="col-form-label">Question</label></div>
                                <div class="form-group form-bg"><label class="custom-control custom-radio"><input id="radio11" name="radio1" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio"><input id="radio21" name="radio1" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                <div class="form-group"><label for="message-text" class="col-form-label">Message:</label><textarea class="form-control" id="message-text" placeholder="Write your text here..."></textarea></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">How would you rate "Cloud Concept"</label>
                                    <div class="d-flex mt-4">
                                        <h5>Overall Raiting</h5>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <h5>Overall Raiting</h5>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <h5>Overall Raiting</h5>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"><label for="message-text" class="col-form-label">How would you like the public to preview your review</label><label class="custom-control custom-radio"><input id="radio2" name="radio" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Display my Name & Company to Public</span></label><br><label class="custom-control custom-radio"><input id="radio2" name="radio" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Stay Anonymous</span></label></div>
                                <div class="form-group">
                                    <h6>Your review will be saved, but it won't be published until you complete your profile.</h6>
                                </div>
                                <div class="form-group"><label for="message-text" class="col-form-label">insert you E-mail to complete your Profile and save your review</label><input type="text" class="form-control" placeholder="E-mail"></div>
                                <div class="form-group"><button type="button" class="btn btn-blue btn-yellow text-capitalize"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Submit Review</button></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection