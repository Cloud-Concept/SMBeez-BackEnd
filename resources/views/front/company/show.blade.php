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
                                <li>Industry: <a href="{{route('front.industry.show', $company->industry->slug)}}">{{$company->industry->industry_name}}</a></li>
                                <li>Speciality: <span>
                                    @foreach($company->specialities as $speciality)
                                        {{$speciality->speciality_name . ','}} 
                                    @endforeach
                                </span></li>
                            </ul>
                            @if (Auth::guest() || Auth::user()->id != $company->user_id)
                            <div class="text-center my-3"></div>
                            @elseif(Auth::user()->id == $company->user_id)
                            <div class="text-center my-3"><a href="{{route('front.company.edit', $company->slug)}}"><button class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> Edit Company</button></a></div>
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
                                @if($company->reviews->count() > 0)
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <select class="star-rating-fn">
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
                            <li class="nav-item"><a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a></li>
                            <li class="nav-item"><a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Reviews from Customers</a></li>
                            <li class="nav-item mr-auto"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Reviews from Suppliers</a></li>
                            @if(!Auth::guest() && !$company->is_owner(Auth::user()->id))
                            <li><button class="btn btn-blue btn-yellow pull-right btn-sm" data-toggle="modal" data-target="#reviewModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Write a Review</button></li>
                            @endif
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
                                                <a href="{{route('front.industry.show', $industry->slug)}}">{{$company->industry->industry_name}}</a>
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
                                        @if($customer_reviews->count() > 0)
                                        <li class="list-inline-item">
                                            @if($company->reviews->count() > 0)
                                            <select class="star-rating-fn">
                                                @for($i = 1; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $customer_overall ? 'selected' : ''}}>{{$i}}</option>
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
                                                <li><a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                <li><a href=""><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                <li><a href="" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-fn">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->overall_rate ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Selection Process</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-fn">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->selection_process_rate ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Value for Money</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-fn">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->money_value_rate ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Delivery Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-fn">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->delivery_quality_rate ? 'selected' : ''}}>{{$i}}</option>
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
                                            <select class="star-rating-fn">
                                                @for($i = 1; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $suppliers_overall ? 'selected' : ''}}>{{$i}}</option>
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
                                                <li><a href=""><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                <li><a href=""><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                <li><a href="" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="col-lg-3 col-md-12">
                                            <div class="rating-sidebar">
                                                <div class="rating-sidebar-block">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-fn">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->overall_rate ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Selection Process</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-fn">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->selection_process_rate ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Value for Money</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-fn">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->money_value_rate ? 'selected' : ''}}>{{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rating-sidebar-block">
                                                    <h5>Delivery Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select class="star-rating-fn">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{$i}}" {{$i == $review->delivery_quality_rate ? 'selected' : ''}}>{{$i}}</option>
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
                <form action="{{route('add.review')}}" method="post" class="write-review">
                    {{csrf_field()}}
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label for="recipient-name" class="col-form-label">What is your relation to company</label></div>
                                <div class="form-group form-bg"><label class="custom-control custom-radio"><input id="customer" name="reviewer_relation" type="radio" value="customer" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">I am a Customer</span></label><label class="custom-control custom-radio"><input id="supplier" name="reviewer_relation" type="radio" value="supplier" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">I am A Supplier</span></label></div>
                                <div class="form-group"><label for="recipient-name" class="col-form-label">Question</label></div>
                                <div class="form-group form-bg"><label class="custom-control custom-radio"><input id="radio11" name="question" value="1" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio"><input id="radio21" value="0" name="question" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                <div class="form-group"><label for="message-text" class="col-form-label">Message:</label><textarea class="form-control" id="message-text" name="feedback" placeholder="Write your text here..."></textarea></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">How would you rate "{{$company->company_name}}"</label>
                                    <div class="d-flex mt-4">
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
                                    <div class="d-flex">
                                        <h5>Selection Process</h5>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <select name="selection_process_rate" class="star-rating-fn">
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
                                        <h5>Value for Money</h5>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <select name="money_value_rate" class="star-rating-fn">
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
                                        <h5>Delivery Quality</h5>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <select name="delivery_quality_rate" class="star-rating-fn">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection