@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box-block-white vcard vcard-company">
                        <h4>
                            @if($company->logo_url)
                            <img src="{{ asset($company->logo_url) }}" alt="{{$company->company_name}} Logo">
                            @endif
                            <a href="" class="btn-more pull-right"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                        </h4>
                        <div class="media">
                            @if($company->cover_url)
                            <img class="img-fluid img-full" src="{{ asset($company->cover_url) }}" alt="">
                            @endif
                        </div>
                        <div class="p-3">
                            <h2 class="mt-2"><i class="fa fa-address-card" aria-hidden="true"></i> {{$company->company_name}}</h2>
                            <ul class="list-unstyled details-box">
                                <li>Industry: <a href="{{route('front.industry.show', $company->industry->slug)}}">{{$company->industry->industry_name}}</a></li>
                                <li>Speciality: <span>
                                    @foreach($company->specialities as $speciality)
                                        {{$speciality->speciality_name . ','}} 
                                    @endforeach
                                </span></li>
                            </ul>

                            @if (Auth::guest() && $company->is_verified == null)
                                <div class="text-center my-3"><a href="{{route('front.company.claim_notification', $company->slug)}}" class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> Claim company</a></div>
                            @elseif (Auth::guest() && $company->is_verified == 1)
                                <div></div>
                            @elseif (!Auth::guest() && $company->is_verified == null && !Auth::user()->company && !$company->requested_claim(Auth::user()->id, $company->id))
                                <div class="text-center my-3"><a href="{{route('front.company.claim_notification', $company->slug)}}" class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> Claim company</a></div>    
                            @elseif(Auth::user()->id == $company->user_id)
                                <div class="text-center my-3"><a href="{{route('front.company.edit', $company->slug)}}"><button class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> Edit Company</button></a></div>
                            @endif

                            <h3>Contact info</h3>
                            <ul class="list-unstyled details-box vcard-list">
                                @if($company->location)
                                <li>
                                    <span class="pull-left"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    <div class="pull-left">{{$company->location}}</div>
                                </li>
                                @endif

                                @if($company->company_phone)
                                <li>
                                    <span class="pull-left"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="tel:{{$company->company_phone}}">{{$company->company_phone}}</a></div>
                                </li>
                                @endif

                                @if($company->company_website)
                                <li>
                                    <span class="pull-left"><i class="fa fa-globe" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="{{$company->company_website}}" target="_blank">Website</a></div>
                                </li>
                                @endif

                                @if($company->company_email)
                                <li>
                                    <span class="pull-left"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="mailto:{{$company->company_email}}">{{$company->company_email}}</a></div>
                                </li>
                                @endif

                                @if($company->linkedin_url)
                                <li>
                                    <span class="pull-left"><i class="fa fa-linkedin" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="{{$company->linkedin_url}}" target="_blank">Linkedin Profile</a></div>
                                </li>
                                @endif
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
                                @if($company->reviews->count() > 0)
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <select class="star-rating-ro">
                                                @for($i = 1; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $company->company_overall_rating($company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </li>
                                        <li class="list-inline-item thumb-review"><a href="">({{$company->reviews->count()}} Reviews)</a></li>
                                    </ul>
                                </div>
                                @endif
                            </ul>
                        </div>
                        <div class="hero-shadow"></div>
                    </div>
                    <div class="company-tabs">
                        <ul class="nav d-flex nav-tabs mt-5" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Reviews from Customers</a></li>
                            <li class="nav-item mr-auto"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Reviews from Suppliers</a></li>
                            @if(!Auth::guest() && !$company->is_owner(Auth::user()->id))
                            <li><button class="btn btn-blue btn-yellow pull-right btn-sm" data-toggle="modal" data-target="#reviewModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Write a Review</button></li>
                            @endif
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show pt-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                           	<p>{{ strip_tags($company->company_description) }}</p>
                            
                            @if($closed_projects->count() > 0)
                            <h3 class="mb-4 mt-5">Closed projects</h3>
                            <div class="row equal">
                                @foreach($closed_projects as $project)
                                   <div class="col-md-6">
                                        <div class="project-box box-block mb-3">
                                            <p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p>
                                            <p>{{strip_tags(substr($project->project_description, 0, 100))}}...</p>
                                            <p class="tags">More in: 
                                                <a href="{{route('front.industry.show', $company->industry->slug)}}">{{$company->industry->industry_name}}</a>
                                            </p>
                                        </div>
                                    </div> 
                                @endforeach   
                            </div>
                            @endif
                        </div>
                        <div class="tab-pane fade pt-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="review-bar">
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        @if($customer_reviews->count() > 0)
                                        <li class="list-inline-item">
                                            @if($company->reviews->count() > 0)
                                            <select class="star-rating-ro">
                                                @for($i = 1; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $company->customer_rating($company->id, $customer_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                            @endif
                                        </li>
                                        @endif
                                        <li class="list-inline-item thumb-review"><a href="">(Customers Overall Rating)</a></li>
                                        <li class="list-inline-item thumb-review"><a href="">({{$customer_reviews->count()}} Reviews from Customers)</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="review-block">
                                <div class="review-content">
                                    @foreach($company->reviews as $review)
                                    @if($review->reviewer_relation == 'customer')
                                    <div class="media br-btm mb-4 d-flex row equal">
                                        <div class="col-md-2"><img class="img-fluid img-full mb-3" src="../images/media/placeholder.png" alt="Generic placeholder image"></div>
                                        <div class="col-lg-7 col-md-10 mb-4">
                                            @if($review->review_privacy === 'public')
                                            <h5 class="mt-0">{{$review->user->company->company_name}}</h5>
                                            @elseif($review->review_privacy === 'private')
                                            <h5 class="mt-0">Anonymous</h5>
                                            @endif
                                            <p>{{$review->feedback}} <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i></a></p>
                                            @if(!Auth::guest())
                                            <ul class="review-content-social">
                                                @if($review->impression($review->id) === 1)
                                                    <li><a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('review-unlike-{{$review->id}}').submit();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                @elseif($review->impression($review->id) === 0)
                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('review-like-{{$review->id}}').submit();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a></li> 
                                                @else
                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('review-like-{{$review->id}}').submit();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('review-unlike-{{$review->id}}').submit();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                @endif

                                                @if($review->is_flagged($review->id) === true)
                                                    <li><a href="#" class="btn btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('review-unflag-{{$review->id}}').submit();"><i class="fa fa-flag-o" aria-hidden="true"></i> UnFlag</a></li>
                                                @else
                                                    <li><a href="#" class="btn btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('review-flag-{{$review->id}}').submit();"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                @endif
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                            <form id="review-like-{{$review->id}}" action="{{route('review.like', $review->id)}}" method="post">
                                                {{csrf_field()}}
                                            </form>
                                            <form id="review-unlike-{{$review->id}}" action="{{route('review.unlike', $review->id)}}" method="post">
                                                {{csrf_field()}}
                                            </form>
                                            <form id="review-flag-{{$review->id}}" action="{{route('review.flag', $review->id)}}" method="post">
                                                {{csrf_field()}}
                                            </form>
                                            <form id="review-unflag-{{$review->id}}" action="{{route('review.unflag', $review->id)}}" method="post">
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                            </form>
                                            @endif
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->quality ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Time</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->time ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Cost</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->cost ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Repeat Business</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->business_repeat ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->overall_rate ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade pt-4" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="review-bar">
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        @if($suppliers_reviews->count() > 0)
                                        <li class="list-inline-item">
                                            @if($company->reviews->count() > 0)
                                            <select class="star-rating-ro">
                                                @for($i = 1; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $company->suppliers_rating($company->id, $suppliers_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                            @endif
                                        </li>
                                        @endif
                                        <li class="list-inline-item thumb-review"><a href="">(Suppliers Overall Rating)</a></li>
                                        <li class="list-inline-item thumb-review"><a href="">({{$suppliers_reviews->count()}} Reviews from Suppliers)</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="review-block">
                                <div class="review-content">
                                    @foreach($company->reviews as $review)
                                    @if($review->reviewer_relation == 'supplier')
                                    <div class="media br-btm mb-4 d-flex row equal">
                                        <div class="col-md-2"><img class="img-fluid img-full mb-3" src="../images/media/placeholder.png" alt="Generic placeholder image"></div>
                                        <div class="col-lg-7 col-md-10 mb-4">
                                            @if($review->review_privacy === 'public')
                                            <h5 class="mt-0">{{$review->user->company->company_name}}</h5>
                                            @elseif($review->review_privacy === 'private')
                                            <h5 class="mt-0">Anonymous</h5>
                                            @endif
                                            <p>{{$review->feedback}} <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i></a></p>
                                            @if(!Auth::guest())
                                            <ul class="review-content-social">
                                                @if($review->impression($review->id) === 1)
                                                    <li><a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('review-unlike-{{$review->id}}').submit();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                @elseif($review->impression($review->id) === 0)
                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('review-like-{{$review->id}}').submit();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a></li> 
                                                @else
                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('review-like-{{$review->id}}').submit();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('review-unlike-{{$review->id}}').submit();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                @endif

                                                @if($review->is_flagged($review->id) === true)
                                                    <li><a href="#" class="btn btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('review-unflag-{{$review->id}}').submit();"><i class="fa fa-flag-o" aria-hidden="true"></i> UnFlag</a></li>
                                                @else
                                                    <li><a href="#" class="btn btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('review-flag-{{$review->id}}').submit();"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                @endif

                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                            <form id="review-like-{{$review->id}}" action="{{route('review.like', $review->id)}}" method="post">
                                                {{csrf_field()}}
                                            </form>
                                            <form id="review-unlike-{{$review->id}}" action="{{route('review.unlike', $review->id)}}" method="post">
                                                {{csrf_field()}}
                                            </form>
                                            @endif
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Procurement</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->procurement ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Expectations</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->expectations ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Payments</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->payments ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Repeat Business</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->business_repeat ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-ro">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->overall_rate ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                    
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
                <div class="write-review">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label for="recipient-name" class="col-form-label">What is your relation to {{$company->company_name}}</label></div>
                                <div class="form-group form-bg">
                                    <ul class="nav radio-tabs" role="tablist">
                                        <li><a class="active radio-link" id="form1-tab" data-toggle="tab" href="#form1" role="tab" aria-controls="form1" aria-selected="true"><label class="custom-control custom-radio"><input id="radio1-test" name="radioselect" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">I am a Customer</span></label></a></li>
                                        <li><a class="radio-link" id="form2-tab" data-toggle="tab" href="#form2" role="tab" aria-controls="form2" aria-selected="false"><label class="custom-control custom-radio"><input id="radio2-test" name="radioselect" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">I am a Supplier</span></label></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="formTabs">
                            <div class="tab-pane fade show active" id="form1" role="tabpanel" aria-labelledby="form1-tab">
                                <form action="{{route('add.review.customer')}}" method="post" class="write-review">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><label for="recipient-name" class="col-form-label">Did your company hire {{$company->company_name}} to do some work?</label></div>
                                            <div class="radio-cases" id="first-level">
                                                <div class="form-group case-01 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="is_hired1" value="1" name="is_hired" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="is_hired2" name="is_hired" value="0" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                            </div>
                                            <div id="second-level">
                                                <div class="yes-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Did {{$company->company_name}} complete the work successfully?</label></div>
                                                    <div class="form-group case-02 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="completness1" value="1" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="completness2" value="0" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                                </div>
                                            </div>
                                            <div id="third-level">
                                                <div class="no-case-info">                                                
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Why not?</label></div>
                                                    <div class="form-group case-03 form-bg">
                                                        <select name="why_not" class="form-control">
                                                            <option value="">Select Reason</option>
                                                            <option value="time">{{$company->company_name}} failed to deliver work on time</option>
                                                            <option value="quality">{{$company->company_name}} failed to provide the expected level of quality</option>
                                                            <option value="cost">{{$company->company_name}} requested additional cost</option>
                                                            <option value="they-out">{{$company->company_name}} went out of business</option>
                                                            <option value="we-out">My company went out of business</option>
                                                            <option class="radio-no-case" value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="four-level">
                                                <div class="no-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Please elaborate</label></div>
                                                    <div class="form-group case-04 form-bg">
                                                        <textarea class="form-control" id="why_not_msg" name="why_not_msg" placeholder="Write your text here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">Please give your overall assessment of {{$company->company_name}}</label><textarea class="form-control" id="feedback" name="feedback" placeholder="Write your text here..."></textarea></div>
                                        </div>
                                        <div class="col-md-6 casepushup">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">How would you rate "{{$company->company_name}}"</label>
                                                <div class="d-flex mt-4">
                                                    <h5>Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="quality" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Cost</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="cost" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Time</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="time" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Repeat Business</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="business_repeat" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="overall_rate" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">How would you like the public to preview your review</label><label class="custom-control custom-radio"><input id="radio2" name="privacy" value="public" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Display my Name & Company to Public</span></label><br><label class="custom-control custom-radio"><input id="radio2" name="privacy" value="private" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Stay Anonymous</span></label></div>
                                            <input type="hidden" name="company_id" value="{{$company->id}}">
                                            <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Submit Review</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="form2" role="tabpanel" aria-labelledby="form2-tab">
                                <form action="{{route('add.review.supplier')}}" method="post" class="write-review">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><label for="recipient-name" class="col-form-label">Was your company hired by {{$company->company_name}} to do some work?</label></div>
                                            <div class="radio-cases" id="first-level">
                                                <div class="form-group case-01 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="is_hired3" name="is_hired" value="1" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="is_hired4" value="0" name="is_hired" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                            </div>
                                            <div id="second-level">
                                                <div class="yes-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Did you complete the work successfully?</label></div>
                                                    <div class="form-group case-02 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="completness3" value="1" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="completness4" name="completness" value="0" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                                </div>
                                            </div>
                                            <div id="third-level">
                                                <div class="no-case-info">                                                
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Why not?</label></div>
                                                    <div class="form-group case-03 form-bg">
                                                        <select name="why_not" class="form-control">
                                                            <option value="">Select Reason</option>
                                                            <option value="cancelled">Client canceled the project</option>
                                                            <option value="nopay">Client did not pay</option>
                                                            <option value="expectations">Client expectations were unreasonable</option>
                                                            <option value="they-out">Client went out of business</option>
                                                            <option value="we-out">My company went out of business</option>
                                                            <option class="radio-no-case" value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="four-level">
                                                <div class="no-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Please elaborate</label></div>
                                                    <div class="form-group case-04 form-bg">
                                                        <textarea class="form-control" id="why_not_msg1" name="why_not_msg" placeholder="Write your text here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">Please give your overall assessment of {{$company->company_name}}</label><textarea class="form-control" id="feedback1" name="feedback" placeholder="Write your text here..."></textarea></div>
                                        </div>
                                        <div class="col-md-6 casepushup">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">How would you rate "{{$company->company_name}}"</label>
                                                <div class="d-flex mt-4">
                                                    <h5>Procurement</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="procurement" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Expectations</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="expectations" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Payments</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="payments" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Repeat Business</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="business_repeat" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="overall_rate" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">How would you like the public to preview your review</label><label class="custom-control custom-radio"><input id="radio2" name="privacy" value="public" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Display my Name & Company to Public</span></label><br><label class="custom-control custom-radio"><input id="radio2" name="privacy" value="private" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Stay Anonymous</span></label></div>
                                            <input type="hidden" name="company_id" value="{{$company->id}}">
                                            <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Submit Review</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection