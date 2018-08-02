@extends('layouts.inner')

@section('content')
@section('title')
    {{$company->company_name}}
@endsection
@section('description')
    {{strip_tags(substr($company->company_description, 0, 250))}}
@endsection
@if($company->logo_url)
    @section('image')
        {{$company->logo_url}}
    @endsection
@endif
<main class="cd-main-content">
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab221b2378ad19d"></script>
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="box-block-white vcard vcard-company">
                        <h4>
                            @if($company->logo_url && file_exists(public_path('/') . $company->logo_url))
                            <img src="{{ asset($company->logo_url) }}" alt="{{$company->company_name}} Logo">
                            @endif
                            <!-- <a href="" class="btn-more pull-right"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a> -->
                        </h4>
                        <div class="media">
                            @if($company->cover_url  && file_exists(public_path('/') . $company->cover_url))
                            <img class="img-fluid img-full" src="{{ asset($company->cover_url) }}" alt="">
                            @endif
                        </div>
                        <div class="p-3">
                            <h2 class="mt-2">@if($company->is_verified == 1) <i class="fa fa-check" aria-hidden="true" style="color:#00c875"></i> @endif {{$company->company_name}}</h2>
                            <ul class="list-unstyled details-box">
                                <li>{{__('general.industry_title')}} <a href="{{route('front.company.showindustry', $company->industry->slug)}}">
                                    @if(app()->getLocale() == 'ar')
                                    {{$company->industry->industry_name_ar}}
                                    @else
                                    {{$company->industry->industry_name}}
                                    @endif
                                </a></li>
                                @if($company->specialities->count() > 0)
                                <li>{{__('general.speciality_title')}} <span>
                                    @foreach($company->specialities as $speciality)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{$speciality->speciality_name}} 
                                    @endforeach
                                </span></li>
                                @endif
                            </ul>

                            @if (Auth::guest() && $company->is_verified == null)
                                <div class="text-center my-3"><a href="{{route('login')}}/?action=claim-company&name={{$company->slug}}" class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> {{__('company.claim_company_btn')}}</a></div>
                            @elseif (Auth::guest() && $company->is_verified == 1)
                                <div></div>
                            @elseif (!Auth::guest() && $company->is_verified == null && !Auth::user()->company && !$company->requested_claim(Auth::user()->id, $company->id) && count(Auth::user()->claims) == 0)
                                <div class="text-center my-3"><a href="{{route('front.company.claim_notification', $company->slug)}}" class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> {{__('company.claim_company_btn')}}</a></div>    
                            @elseif(Auth::user()->id == $company->user_id)
                                <div class="text-center my-3"><a href="{{route('front.company.edit', $company->slug)}}"><button class="btn btn-blue btn-yellow"><i class="fa fa-check" aria-hidden="true"></i> {{__('company.edit_company_btn')}}</button></a></div>
                            @endif

                            <h3>{{__('company.contact_info')}}</h3>
                            <ul class="list-unstyled details-box vcard-list">
                                @if($company->location)
                                <li>
                                    <div class="pull-left"><i class="fa fa-map-marker" aria-hidden="true"></i>{{$company->location}}</div>
                                </li>
                                @endif

                                @if($company->company_phone && $company->company_phone != '-')
                                <li>
                                    <span class="pull-left"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    <div class="pull-left"><a href="tel:{{$company->company_phone}}">{{$company->company_phone}}</a></div>
                                </li>
                                @endif

                                @if($company->company_website)
                                <li>
                                    <?php function addhttp($url) {
                                        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                            $url = "http://" . $url;
                                        }
                                        return $url;
                                    } ?>
                                    <div class="pull-left"><i class="fa fa-globe" aria-hidden="true"></i><a href="{{addhttp($company->company_website)}}" target="_blank">{{$company->company_website}}</a></div>
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
                                    <div class="pull-left"><a href="{{$company->linkedin_url}}" target="_blank">{{__('company.linked_in')}}</a></div>
                                </li>
                                @endif
                            </ul>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    @if(app()->getLocale() == 'ar')
                    <div class="hero-company-details" style="background: url( {{file_exists(public_path($company->industry->industry_img_url_ar)) ? asset($company->industry->industry_img_url_ar) : ''}}) no-repeat 100% 100%;">
                    @else
                    <div class="hero-company-details" style="background: url( {{file_exists(public_path($company->industry->industry_img_url)) ? asset($company->industry->industry_img_url) : ''}}) no-repeat 100% 100%;">
                    @endif
                        <h1 class="w-50">{{$company->company_name}}</h1>
                        <h2>{{$company->company_tagline}}</h2>
                        <div class="star-rating">
                            <ul class="list-inline">
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <select class="star-rating-ro">
                                                @for($i = 0; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $company->company_overall_rating($company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </li>
                                        <li class="list-inline-item thumb-review"><p>({{$company->reviews->count()}} {{__('general.reviews_title')}})</p></li>
                                        <li class="list-item"> 
                                            @if(!Auth::guest() && $company->user_id != 0 && !$company->is_owner(Auth::user()->id))
                                                @if(!$company->bookmarked($company->id))
                                                    <a href="#" id="bookmark-b-{{$company->id}}" class="more-inf" onclick="event.preventDefault();"><i class="fa fa-bookmark-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Add to your Favorites"></i></a>
                                                    <a href="#" id="unbookmark-b-{{$company->id}}" class="more-inf" style="display:none" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                                                @else
                                                    <a href="#" id="unbookmark-b-{{$company->id}}" class="more-inf" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                                                    <a href="#" id="bookmark-b-{{$company->id}}" class="more-inf" style="display:none" onclick="event.preventDefault();"><i class="fa fa-bookmark-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Add to your Favorites"></i></a>
                                                @endif
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                            @if(!Auth::guest() && $company->user_id != 0 && !$company->is_owner(Auth::user()->id))
                            <form id="bookmark-{{$company->id}}" action="#">
                                <input id="token-bookmark-{{$company->id}}" value="{{csrf_token()}}" type="hidden">
                                <input type="hidden" id="bookmarked_id-{{$company->id}}" name="bookmarked_id" value="{{$company->id}}"/>
                                <input type="hidden" id="bookmark_type-{{$company->id}}" name="bookmark_type" value="App\Company"/>
                            </form>
                            <form id="unbookmark-{{$company->id}}" action="#">
                                <input id="token-unbookmark-{{$company->id}}" value="{{csrf_token()}}" type="hidden">
                                <input type="hidden" id="unbookmarked_id-{{$company->id}}" name="bookmarked_id" value="{{$company->id}}"/>
                                <input type="hidden" id="unbookmark_type-{{$company->id}}" name="bookmark_type" value="App\Company"/>
                            </form>
                            <script>
                                $(document).ready(function(){
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    var new_bookmarkid = '{{$company->bookmark($company->id)}}';
                                    //bookmark company
                                    $('#bookmark-b-{{$company->id}}').on('click', function(e){
                                        e.preventDefault();
                                        var token = $('#token-bookmark-{{$company->id}}').val();
                                        var bookmark_type = $('#bookmark_type-{{$company->id}}').val();
                                        var bookmark_id = $('#bookmarked_id-{{$company->id}}').val();
                                        $.ajax({
                                            type: "POST",
                                            data: "bookmarked_id=" + bookmark_id + "&bookmark_type=" + bookmark_type + "&_token=" + token,
                                            dataType: 'json',
                                            url: "{{route('bookmark.add')}}",
                                            success: function(data) {
                                                $('#unbookmark-b-{{$company->id}}').show();
                                                $('#bookmark-b-{{$company->id}}').hide();
                                                new_bookmarkid = data.id;
                                            }
                                        });
                                    });
                                    
                                    $('#unbookmark-b-{{$company->id}}').on('click', function(e){
                                        e.preventDefault();
                                        var token = $('#token-unbookmark-{{$company->id}}').val();
                                        var url = '{{ route("bookmark.remove", ":new_bookmarkid") }}';
                                        $.ajax({
                                            type: "POST",
                                            data: "_token=" + token,
                                            url: url.replace(':new_bookmarkid', new_bookmarkid),
                                            success: function(data) {
                                                $('#unbookmark-b-{{$company->id}}').hide();
                                                $('#bookmark-b-{{$company->id}}').show();
                                            }
                                        });
                                    });
                                });
                            </script>
                            @endif
                        </div>
                        <div class="hero-shadow"></div>
                    </div>
                    <div class="company-tabs">
                        <ul class="nav d-flex nav-tabs mt-5" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{__('company.reviews_from_customers')}}</a></li>
                            <li class="nav-item mr-auto"><a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{__('company.reviews_from_suppliers')}}</a></li>
                            @if(!Auth::guest() && !$company->is_owner(Auth::user()->id) && Auth::user()->company)
                            <li><button id="write-review-modal" class="btn btn-blue btn-yellow pull-right btn-sm" data-toggle="modal" data-target="#reviewModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{__('company.write_review')}}</button></li>
                            @elseif(Auth::guest())
                            <li><a href="{{route('login')}}?action=write-review&name={{$company->slug}}" class="btn btn-blue btn-yellow pull-right btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{__('company.write_review')}}</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show pt-4" id="home" role="tabpanel" aria-labelledby="home-tab">
                           	@if($company->company_description)
                            <p>{!!str_replace("\n","<p>",$company->company_description)!!}</p>
                            @endif
                            
                            @if($closed_projects->count() > 0)
                            <h3 class="mb-4 mt-5">Closed projects</h3>
                            <div class="row equal">
                                @foreach($closed_projects as $project)
                                   <div class="col-md-6">
                                        <div class="project-box box-block mb-3">
                                            <p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p>
                                            <p>{{strip_tags(substr($project->project_description, 0, 100))}}...</p>
                                            <p class="tags">{{__('general.more_in')}} 
                                                <a href="{{route('front.industry.show', $company->industry->slug)}}">
                                                    @if(app()->getLocale() == 'ar')
                                                    {{$company->industry->industry_name_ar}}
                                                    @else
                                                    {{$company->industry->industry_name}}
                                                    @endif
                                                </a>
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
                                        <li class="list-inline-item">
                                            <select class="star-rating-ro">
                                                @for($i = 0; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $company->customer_rating($company->id, $customer_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </li>
                                        <li class="list-inline-item thumb-review">{{__('company.customer_overall_rating')}}</li>
                                        <li class="list-inline-item thumb-review">({{$customer_reviews->count()}} {{__('company.reviews_from_customers')}})</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="review-block">
                                <div class="review-content">
                                    @foreach($company->reviews as $review)
                                    @if($review->reviewer_relation == 'customer')
                                    <div class="media br-btm mb-4 d-flex row equal">
                                        <div class="col-lg-9 col-md-10 mb-4">
                                            <div class="media">
                                                @if($review->review_privacy === 'public')
                                                <a href="{{route('front.company.show', $review->user->company->slug)}}" class="mr-3 thumb-int"> {{substr($review->user->company->company_name, 0, 1)}} </a>
                                                @elseif($review->review_privacy === 'private')
                                                <a href="#" class="mr-3 thumb-int"> ? </a>
                                                @endif
                                                
                                                <div class="media-body">
                                                    @if($review->review_privacy === 'public')
                                                    <h5 class="mt-0">{{$review->user->company->company_name}}</h5>
                                                    @elseif($review->review_privacy === 'private')
                                                    <h5 class="mt-0">Anonymous</h5>
                                                    @endif
                                                    <p>{{$review->feedback}} <!-- <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i> --></a></p>
                                                
                                                    @if(!Auth::guest())
                                                    <ul class="review-content-social">
                                                        @if($review->impression($review->id) === 1)
                                                            <li><a href="#" id="review-like-b-{{$review->id}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
                                                            <li><a href="#" id="review-unlike-b-{{$review->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                        @elseif($review->impression($review->id) === 0)
                                                            <li><a href="#" id="review-like-b-{{$review->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                            <li><a href="#" id="review-unlike-b-{{$review->id}}"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a></li> 
                                                        @else
                                                            <li><a href="#" id="review-like-b-{{$review->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                            <li><a href="#" id="review-unlike-b-{{$review->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                        @endif

                                                        @if($review->is_flagged($review->id) === true)
                                                            <!-- <li><a href="#" id="review-unflag-b-{{$review->id}}" class="btn btn-blue btn-yellow" onclick="event.preventDefault();"><i class="fa fa-flag-o" aria-hidden="true"></i> UnFlag</a></li> -->
                                                        @else
                                                            <!-- <li><a href="#" id="review-flag-b-{{$review->id}}" class="btn btn-blue btn-yellow" onclick="event.preventDefault();"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li> -->
                                                        @endif
                                                        <!-- <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li> -->
                                                        
                                                        @if($company->user_id == Auth::user()->id || $review->user_id == Auth::user()->id)
                                                            <li class="review-info">
                                                                <a href="#" data-toggle="modal" id="review-reply-{{$review->id}}" class="add-reply" data-target="#add-reply"><i class="fa fa-reply" aria-hidden="true"></i></a>
                                                                <input type="hidden" class="info-id" rev-id="{{$review->id}}">
                                                                @if($review->review_privacy === 'public')
                                                                <input type="hidden" class="info-user" rev-user="{{$review->user->company->company_name}}">
                                                                @elseif($review->review_privacy === 'private')
                                                                <input type="hidden" class="info-user" rev-user="Anonymous">
                                                                @endif
                                                            </li>
                                                        @endif
                                                    </ul>
                                                    <form id="review-like-{{$review->id}}" action="#">
                                                        <input id="token-like-{{$review->id}}" value="{{csrf_token()}}" type="hidden">
                                                    </form>
                                                    <form id="review-unlike-{{$review->id}}" action="#">
                                                        <input id="token-unlike-{{$review->id}}" value="{{csrf_token()}}" type="hidden">
                                                    </form>
                                                    <!-- <form id="review-flag-{{$review->id}}" action="#">
                                                        <input id="token-flag-{{$review->id}}" value="{{csrf_token()}}" type="hidden">
                                                    </form>
                                                    <form id="review-unflag-{{$review->id}}" action="#">
                                                        <input id="token-unflag-{{$review->id}}" value="{{csrf_token()}}" type="hidden">
                                                        {{ method_field('DELETE') }}
                                                    </form> -->
                                                    <script>
                                                        $(document).ready(function(){
                                                            $.ajaxSetup({
                                                                headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                }
                                                            });
                                                            //Like review
                                                            $('#review-like-b-{{$review->id}}').click(function(e){
                                                                e.preventDefault();
                                                                var token = $('#token-like-{{$review->id}}').val();

                                                                $.ajax({
                                                                    type: "POST",
                                                                    data: "_token=" + token,
                                                                    url: "{{route('review.like', $review->id)}}",
                                                                    success: function(data) {
                                                                        $('#review-like-b-{{$review->id}} i').removeClass('fa-thumbs-o-up').addClass('fa-thumbs-up');
                                                                        $('#review-unlike-b-{{$review->id}} i').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
                                                                    }
                                                                });
                                                            });

                                                            //unlike review
                                                            $('#review-unlike-b-{{$review->id}}').click(function(e){
                                                                e.preventDefault();
                                                                var token = $('#token-unlike-{{$review->id}}').val();

                                                                $.ajax({
                                                                    type: "POST",
                                                                    data: "_token=" + token,
                                                                    url: "{{route('review.unlike', $review->id)}}",
                                                                    success: function(data) {
                                                                        $('#review-like-b-{{$review->id}} i').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
                                                                        $('#review-unlike-b-{{$review->id}} i').removeClass('fa-thumbs-o-down').addClass('fa-thumbs-down');
                                                                    }
                                                                });
                                                            });
                                                            //flag review
                                                            /*$('#review-flag-b-{{$review->id}}').click(function(e){
                                                                e.preventDefault();
                                                                var token = $('#token-flag-{{$review->id}}').val();

                                                                $.ajax({
                                                                    type: "POST",
                                                                    data: "_token=" + token,
                                                                    url: "{{route('review.flag', $review->id)}}",
                                                                    success: function(data) {
                                                                        $('#review-flag-b-{{$review->id}}').html('<i class="fa fa-flag-o" aria-hidden="true"></i> UnFlag');
                                                                        $('#review-flag-b-{{$review->id}}').attr('id', 'review-unflag-b-{{$review->id}}');
                                                                    }
                                                                });
                                                            }); */
                                                            //unflag review -- need to refresh to unflag
                                                            /*$('#review-unflag-b-{{$review->id}}').click(function(e){
                                                                e.preventDefault();
                                                                var token = $('#token-unflag-{{$review->id}}').val();

                                                                $.ajax({
                                                                    type: "DELETE",
                                                                    data: "_token=" + token + "method=DELETE",
                                                                    url: "{{route('review.unflag', $review->id)}}",
                                                                    success: function(data) {
                                                                        $('#review-unflag-b-{{$review->id}}').html('<i class="fa fa-flag-o" aria-hidden="true"></i> Flag');
                                                                        $('#review-unflag-b-{{$review->id}}').attr('id', 'review-flag-b-{{$review->id}}');
                                                                    }
                                                                });
                                                            }); */ 
                                                        });
                                                    </script>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($review->replies->count() > 0)
                                                <h3 class="mt-4 mb-3 underline">{{__('company.replies_title')}}</h3>
                                                @foreach($review->replies as $reply)
                                                <div class="media mt-5">
                                                    <div class="media-body push-left">
                                                        @if($review->review_privacy === 'public' && $reply->user->id != $company->user_id)
                                                        <h5 class="mt-0">{{$reply->user->company->company_name}}</h5>
                                                        @elseif($review->review_privacy === 'private' && $reply->user->id != $company->user_id)
                                                        <h5 class="mt-0">Anonymous</h5>
                                                        @elseif($reply->user->id == $company->user_id)
                                                        <h5 class="mt-0">{{$reply->user->company->company_name}}</h5>
                                                        @endif
                                                        <p>{{$reply->content}}</p>
                                                        <ul class="review-content-social">
                                                            @if($reply->impression($reply->id) === 1)
                                                            <li><a href="#" id="reply-like-b-{{$reply->id}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
                                                            <li><a href="#" id="reply-unlike-b-{{$reply->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                            @elseif($reply->impression($reply->id) === 0)
                                                                <li><a href="#" id="reply-like-b-{{$reply->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                                <li><a href="#" id="reply-unlike-b-{{$reply->id}}"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a></li> 
                                                            @else
                                                                <li><a href="#" id="reply-like-b-{{$reply->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                                <li><a href="#" id="reply-unlike-b-{{$reply->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                            @endif
                                                            <!-- <li><a href="#" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                            <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li> -->
                                                            @if(!Auth::guest())
                                                                @if($company->user_id == Auth::user()->id || $review->user_id == Auth::user()->id)
                                                                    <li class="review-info">
                                                                        <a href="#" data-toggle="modal" id="review-reply-{{$review->id}}" class="add-reply" data-target="#add-reply"><i class="fa fa-reply" aria-hidden="true"></i></a>
                                                                        <input type="hidden" class="info-id" rev-id="{{$review->id}}">
                                                                        @if($review->review_privacy === 'public')
                                                                        <input type="hidden" class="info-user" rev-user="{{$review->user->company->company_name}}">
                                                                        @elseif($review->review_privacy === 'private')
                                                                        <input type="hidden" class="info-user" rev-user="Anonymous">
                                                                        @endif
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <form id="reply-like-{{$reply->id}}" action="#">
                                                    <input id="token-like-{{$reply->id}}" value="{{csrf_token()}}" type="hidden">
                                                </form>
                                                <form id="reply-unlike-{{$reply->id}}" action="#">
                                                    <input id="token-unlike-{{$reply->id}}" value="{{csrf_token()}}" type="hidden">
                                                </form>
                                                <script>
                                                    $(document).ready(function(){
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        //Like review
                                                        $('#reply-like-b-{{$reply->id}}').click(function(e){
                                                            e.preventDefault();
                                                            var token = $('#token-like-{{$reply->id}}').val();

                                                            $.ajax({
                                                                type: "POST",
                                                                data: "_token=" + token,
                                                                url: "{{route('reply.like', $reply->id)}}",
                                                                success: function(data) {
                                                                    $('#reply-like-b-{{$reply->id}} i').removeClass('fa-thumbs-o-up').addClass('fa-thumbs-up');
                                                                    $('#reply-unlike-b-{{$reply->id}} i').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
                                                                }
                                                            });
                                                        });

                                                        //unlike reply
                                                        $('#reply-unlike-b-{{$reply->id}}').click(function(e){
                                                            e.preventDefault();
                                                            var token = $('#token-unlike-{{$reply->id}}').val();

                                                            $.ajax({
                                                                type: "POST",
                                                                data: "_token=" + token,
                                                                url: "{{route('reply.unlike', $reply->id)}}",
                                                                success: function(data) {
                                                                    $('#reply-like-b-{{$reply->id}} i').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
                                                                    $('#reply-unlike-b-{{$reply->id}} i').removeClass('fa-thumbs-o-down').addClass('fa-thumbs-down');
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                                @endforeach
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                        <li class="list-inline-item">
                                            <select class="star-rating-ro">
                                                @for($i = 0; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $company->suppliers_rating($company->id, $suppliers_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </li>
                                        <li class="list-inline-item thumb-review">{{__('company.suppliers_overall_rating')}}</li>
                                        <li class="list-inline-item thumb-review">({{$suppliers_reviews->count()}} {{__('company.reviews_from_suppliers')}})</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="review-block">
                                <div class="review-content">
                                    @foreach($company->reviews as $review)
                                    @if($review->reviewer_relation == 'supplier')
                                    <div class="media br-btm mb-4 d-flex row equal">
                                        <div class="col-lg-9 col-md-10 mb-4">
                                            <div class="media">
                                                @if($review->review_privacy === 'public')
                                                <a href="{{route('front.company.show', $review->user->company->slug)}}" class="mr-3 thumb-int"> {{substr($review->user->company->company_name, 0, 1)}} </a>
                                                @elseif($review->review_privacy === 'private')
                                                <a href="#" class="mr-3 thumb-int"> ? </a>
                                                @endif
                                            
                                                <div class="media-body">
                                                    @if($review->review_privacy === 'public')
                                                    <h5 class="mt-0">{{$review->user->company->company_name}}</h5>
                                                    @elseif($review->review_privacy === 'private')
                                                    <h5 class="mt-0">Anonymous</h5>
                                                    @endif
                                                    <p>{{$review->feedback}} <!-- <a href="">more <i class="fa fa-caret-down" aria-hidden="true"></i> --></a></p>
                                                    @if(!Auth::guest())
                                                    <ul class="review-content-social">
                                                        @if($review->impression($review->id) === 1)
                                                            <li><a href="#" id="review-like-b-{{$review->id}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
                                                            <li><a href="#" id="review-unlike-b-{{$review->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                        @elseif($review->impression($review->id) === 0)
                                                            <li><a href="#" id="review-like-b-{{$review->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                            <li><a href="#" id="review-unlike-b-{{$review->id}}"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a></li> 
                                                        @else
                                                            <li><a href="#" id="review-like-b-{{$review->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                            <li><a href="#" id="review-unlike-b-{{$review->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                        @endif

                                                        @if($review->is_flagged($review->id) === true)
                                                            <!-- <li><a href="#" id="review-unflag-b-{{$review->id}}" class="btn btn-blue btn-yellow" onclick="event.preventDefault();"><i class="fa fa-flag-o" aria-hidden="true"></i> UnFlag</a></li> -->
                                                        @else
                                                            <!-- <li><a href="#" id="review-flag-b-{{$review->id}}" class="btn btn-blue btn-yellow" onclick="event.preventDefault();"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li> -->
                                                        @endif
                                                        <!-- <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li> -->
                                                        @if($company->user_id == Auth::user()->id || $review->user_id == Auth::user()->id)
                                                            <li class="review-info">
                                                                <a href="#" data-toggle="modal" id="review-reply-{{$review->id}}" class="add-reply" data-target="#add-reply"><i class="fa fa-reply" aria-hidden="true"></i></a>
                                                                <input type="hidden" class="info-id" rev-id="{{$review->id}}">
                                                                @if($review->review_privacy === 'public')
                                                                <input type="hidden" class="info-user" rev-user="{{$review->user->company->company_name}}">
                                                                @elseif($review->review_privacy === 'private')
                                                                <input type="hidden" class="info-user" rev-user="Anonymous">
                                                                @endif
                                                            </li>
                                                        @endif
                                                    </ul>
                                                    <form id="review-like-{{$review->id}}" action="#">
                                                        <input id="token-like-{{$review->id}}" value="{{csrf_token()}}" type="hidden">
                                                    </form>
                                                    <form id="review-unlike-{{$review->id}}" action="#">
                                                        <input id="token-unlike-{{$review->id}}" value="{{csrf_token()}}" type="hidden">
                                                    </form>
                                                    <!-- <form id="review-flag-{{$review->id}}" action="#">
                                                        <input id="token-flag-{{$review->id}}" value="{{csrf_token()}}" type="hidden">
                                                    </form>
                                                    <form id="review-unflag-{{$review->id}}" action="#">
                                                        <input id="token-unflag-{{$review->id}}" value="{{csrf_token()}}" type="hidden">
                                                        {{ method_field('DELETE') }}
                                                    </form> -->
                                                    <script>
                                                        $(document).ready(function(){
                                                            $.ajaxSetup({
                                                                headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                }
                                                            });
                                                            //Like review
                                                            $('#review-like-b-{{$review->id}}').click(function(e){
                                                                e.preventDefault();
                                                                var token = $('#token-like-{{$review->id}}').val();

                                                                $.ajax({
                                                                    type: "POST",
                                                                    data: "_token=" + token,
                                                                    url: "{{route('review.like', $review->id)}}",
                                                                    success: function(data) {
                                                                        $('#review-like-b-{{$review->id}} i').removeClass('fa-thumbs-o-up').addClass('fa-thumbs-up');
                                                                        $('#review-unlike-b-{{$review->id}} i').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
                                                                    }
                                                                });
                                                            });

                                                            //unlike review
                                                            $('#review-unlike-b-{{$review->id}}').click(function(e){
                                                                e.preventDefault();
                                                                var token = $('#token-unlike-{{$review->id}}').val();

                                                                $.ajax({
                                                                    type: "POST",
                                                                    data: "_token=" + token,
                                                                    url: "{{route('review.unlike', $review->id)}}",
                                                                    success: function(data) {
                                                                        $('#review-like-b-{{$review->id}} i').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
                                                                        $('#review-unlike-b-{{$review->id}} i').removeClass('fa-thumbs-o-down').addClass('fa-thumbs-down');
                                                                    }
                                                                });
                                                            });
                                                            //flag review
                                                            /*$('#review-flag-b-{{$review->id}}').click(function(e){
                                                                e.preventDefault();
                                                                var token = $('#token-flag-{{$review->id}}').val();

                                                                $.ajax({
                                                                    type: "POST",
                                                                    data: "_token=" + token,
                                                                    url: "{{route('review.flag', $review->id)}}",
                                                                    success: function(data) {
                                                                        $('#review-flag-b-{{$review->id}}').html('<i class="fa fa-flag-o" aria-hidden="true"></i> UnFlag');
                                                                        $('#review-flag-b-{{$review->id}}').attr('id', 'review-unflag-b-{{$review->id}}');
                                                                    }
                                                                });
                                                            }); */
                                                            //unflag review -- need to refresh to unflag
                                                            /*$('#review-unflag-b-{{$review->id}}').click(function(e){
                                                                e.preventDefault();
                                                                var token = $('#token-unflag-{{$review->id}}').val();

                                                                $.ajax({
                                                                    type: "DELETE",
                                                                    data: "_token=" + token + "method=DELETE",
                                                                    url: "{{route('review.unflag', $review->id)}}",
                                                                    success: function(data) {
                                                                        $('#review-unflag-b-{{$review->id}}').html('<i class="fa fa-flag-o" aria-hidden="true"></i> Flag');
                                                                        $('#review-unflag-b-{{$review->id}}').attr('id', 'review-flag-b-{{$review->id}}');
                                                                    }
                                                                });
                                                            }); */ 
                                                        });
                                                    </script>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($review->replies->count() > 0)
                                                <h3 class="mt-4 mb-3 underline">{{__('company.replies_title')}}</h3>
                                                @foreach($review->replies as $reply)
                                                <div class="media mt-5">
                                                    <div class="media-body push-left">
                                                        @if($review->review_privacy === 'public' && $reply->user->id != $company->user_id)
                                                        <h5 class="mt-0">{{$reply->user->company->company_name}}</h5>
                                                        @elseif($review->review_privacy === 'private' && $reply->user->id != $company->user_id)
                                                        <h5 class="mt-0">Anonymous</h5>
                                                        @elseif($reply->user->id == $company->user_id)
                                                        <h5 class="mt-0">{{$reply->user->company->company_name}}</h5>
                                                        @endif
                                                        <p>{{$reply->content}}</p>
                                                        <ul class="review-content-social">
                                                            @if($reply->impression($reply->id) === 1)
                                                            <li><a href="#" id="reply-like-b-{{$reply->id}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a></li>
                                                            <li><a href="#" id="reply-unlike-b-{{$reply->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                            @elseif($reply->impression($reply->id) === 0)
                                                                <li><a href="#" id="reply-like-b-{{$reply->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                                <li><a href="#" id="reply-unlike-b-{{$reply->id}}"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a></li> 
                                                            @else
                                                                <li><a href="#" id="reply-like-b-{{$reply->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a></li>
                                                                <li><a href="#" id="reply-unlike-b-{{$reply->id}}" onclick="event.preventDefault();"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a></li>
                                                            @endif
                                                            <!-- <li><a href="#" class="btn btn-blue btn-yellow"><i class="fa fa-flag-o" aria-hidden="true"></i> Flag</a></li>
                                                            <li><a href=""><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></li> -->
                                                            @if($company->user_id == Auth::user()->id || $review->user_id == Auth::user()->id)
                                                                <li class="review-info">
                                                                    <a href="#" data-toggle="modal" id="review-reply-{{$review->id}}" class="add-reply" data-target="#add-reply"><i class="fa fa-reply" aria-hidden="true"></i></a>
                                                                    <input type="hidden" class="info-id" rev-id="{{$review->id}}">
                                                                    @if($review->review_privacy === 'public')
                                                                    <input type="hidden" class="info-user" rev-user="{{$review->user->company->company_name}}">
                                                                    @elseif($review->review_privacy === 'private')
                                                                    <input type="hidden" class="info-user" rev-user="Anonymous">
                                                                    @endif
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                    <form id="reply-like-{{$reply->id}}" action="#">
                                                    <input id="token-like-{{$reply->id}}" value="{{csrf_token()}}" type="hidden">
                                                </form>
                                                <form id="reply-unlike-{{$reply->id}}" action="#">
                                                    <input id="token-unlike-{{$reply->id}}" value="{{csrf_token()}}" type="hidden">
                                                </form>
                                                <script>
                                                    $(document).ready(function(){
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        //Like review
                                                        $('#reply-like-b-{{$reply->id}}').click(function(e){
                                                            e.preventDefault();
                                                            var token = $('#token-like-{{$reply->id}}').val();

                                                            $.ajax({
                                                                type: "POST",
                                                                data: "_token=" + token,
                                                                url: "{{route('reply.like', $reply->id)}}",
                                                                success: function(data) {
                                                                    $('#reply-like-b-{{$reply->id}} i').removeClass('fa-thumbs-o-up').addClass('fa-thumbs-up');
                                                                    $('#reply-unlike-b-{{$reply->id}} i').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
                                                                }
                                                            });
                                                        });

                                                        //unlike reply
                                                        $('#reply-unlike-b-{{$reply->id}}').click(function(e){
                                                            e.preventDefault();
                                                            var token = $('#token-unlike-{{$reply->id}}').val();

                                                            $.ajax({
                                                                type: "POST",
                                                                data: "_token=" + token,
                                                                url: "{{route('reply.unlike', $reply->id)}}",
                                                                success: function(data) {
                                                                    $('#reply-like-b-{{$reply->id}} i').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
                                                                    $('#reply-unlike-b-{{$reply->id}} i').removeClass('fa-thumbs-o-down').addClass('fa-thumbs-down');
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>
                                                </div>
                                                @endforeach
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
                                                                    @for($i = 0; $i <= 5; $i++)
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
@if(!Auth::guest() && !$company->is_owner(Auth::user()->id) && Auth::user()->company)
<div class="modal fade modal-fullscreen" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">{{__('company.write_review')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="write-review">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label for="recipient-name" class="col-form-label">What is your relation to {{$company->company_name}}? *</label></div>
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
                                            <div class="form-group"><label for="recipient-name" class="col-form-label">Did your company hire {{$company->company_name}} to do some work? *</label></div>
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
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Please elaborate *</label></div>
                                                    <div class="form-group case-04 form-bg">
                                                        <textarea class="form-control" id="why_not_msg" name="why_not_msg" placeholder="Write your text here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">Please give your overall assessment of {{$company->company_name}} *</label><textarea class="form-control" id="feedback" name="feedback" placeholder="Write your text here..." required></textarea></div>
                                        </div>
                                        <div class="col-md-6 casepushup">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">How would you rate "{{$company->company_name}}"? *</label>
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
                                            <div class="form-group"><label for="message-text" class="col-form-label">How would you like the public to preview your review *</label><label class="custom-control custom-radio"><input id="privacy1" name="privacy" value="public" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Display my Name & Company to Public</span></label><br><label class="custom-control custom-radio"><input id="privacy2" name="privacy" value="private" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Stay Anonymous</span></label></div>
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
                                            <div class="form-group"><label for="recipient-name" class="col-form-label">Was your company hired by {{$company->company_name}} to do some work? *</label></div>
                                            <div class="radio-cases" id="first-level">
                                                <div class="form-group case-01 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="is_hired3" name="is_hired" value="1" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="is_hired4" value="0" name="is_hired" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                            </div>
                                            <div id="second-level">
                                                <div class="yes-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Did you complete the work successfully? *</label></div>
                                                    <div class="form-group case-02 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="completness3" value="1" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="completness4" name="completness" value="0" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                                </div>
                                            </div>
                                            <div id="third-level">
                                                <div class="no-case-info">                                                
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Why not? *</label></div>
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
                                            <div class="form-group"><label for="message-text" class="col-form-label">Please give your overall assessment of {{$company->company_name}} *</label><textarea class="form-control" id="feedback1" name="feedback" placeholder="Write your text here..." required></textarea></div>
                                        </div>
                                        <div class="col-md-6 casepushup">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">How would you rate "{{$company->company_name}}"? *</label>
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
                                            <div class="form-group"><label for="message-text" class="col-form-label">How would you like the public to preview your review *</label><label class="custom-control custom-radio"><input id="privacy3" name="privacy" value="public" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Display my Name & Company to Public</span></label><br><label class="custom-control custom-radio"><input id="privacy4" name="privacy" value="private" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Stay Anonymous</span></label></div>
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
@endif

<div class="modal fade modal-fullscreen modal-add-reply" id="add-reply" tabindex="-1" role="dialog" aria-labelledby="add-reply" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">Reply to <span class="company-name"></span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{route('add.reply.toreview')}}" method="POST" class="form-signin my-4" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col">
                            <label>Reply Content:</label>
                            <div class="form-group">
                                <textarea class="form-control" name="reply" placeholder="Reply Content" required></textarea>
                                <input type="hidden" class="rev_id" name="rev_id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4"><button type="submit" class="btn btn-blue btn-yellow">Reply to review</button></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.add-reply').on('click', function(){
        var rev_id = $(this).closest('.review-info').find('.info-id').attr('rev-id');
        var rev_user = $(this).closest('.review-info').find('.info-user').attr('rev-user');

        $('.modal-add-reply').find('.modal-title span').text(rev_user);
        $('.modal-add-reply').find('.modal-body .rev_id').val(rev_id);
    });
});
</script>
@endsection