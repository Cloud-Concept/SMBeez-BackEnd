@extends('layouts.inner')

@section('content')
<nav class="dashboard-nav navbar navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i></button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent2">
        @include ('layouts.dashboard-menu')
    </div>
</nav>
<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar-dashboard mb-3">
                        @if(\Laratrust::hasRole('company|superadmin'))
                            <div class="dashbord-quickbtn dashbord-quickbtn-single"><button class="btn-dash btn-blue btn-yellow" data-toggle="modal" data-target="#add-project">{{__('general.publish_project')}}</button> <!-- <span class="inf">(900 <i>Honeycombs</i>)</span> --></div>
                        @endif
                    </div>
                    <div class="sidebar-dashboard mb-5">
                        <ul class="dash-info">
                            <li>
                                <i class="fa fa-folder-open-o fa-2x pull-left mr-3" aria-hidden="true"></i>
                                <div class="pull-right">
                                    <p class="numb">{{count($user->projects)}}</p>
                                    <p>{{__('general.published_project')}}</p>
                                    <a href="{{route('front.user.myprojects', $user->username)}}">{{__('general.my_projects')}}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">{{__('general.my_dashboard')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('general.project_interests')}}</li>
                        </ol>
                    </nav>
                    @if(count($project->interests) > 0)
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="modal-title">{{sprintf(__('project.expressed_interest'), $project->project_title)}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row gray-title mb-4">
                                        <div class="col-md-4">
                                            <h3>{{__('project.supplier')}}</h3>
                                        </div>
                                        <div class="col-md-8">
                                            <h3>{{__('project.company_info')}}</h3>
                                        </div>
                                    </div>
                                    @foreach($interests as $interest)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="modal-sidebar">
                                                <div class="media-body">
                                                    <h5 class="mt-1 mb-2"><a href="{{route('front.company.show', $interest->user->company->slug)}}">{{$interest->user->company->company_name}}</a></h5>
                                                    <p class="tags"><b>{{__('project.industry')}}</b>:<a href="{{route('front.industry.show', $interest->user->company->industry->slug)}}">
                                                        @if(app()->getLocale() == 'ar')
                                                        {{$interest->user->company->industry->industry_name_ar}}
                                                        @else
                                                        {{$interest->user->company->industry->industry_name}}
                                                        @endif
                                                    </a></p>
                                                    <p class="tags"><b>{{__('general.specs_tag_title')}}</b> <span>
                                                        @foreach($interest->user->company->specialities as $speciality)
                                                            {{$speciality->speciality_name}},
                                                        @endforeach
                                                    </span></p>
                                                </div>
                                                <div class="star-rating mb-3">
                                                    <ul class="list-inline">
                                                        @if($interest->user->company->reviews->count() > 0)
                                                        <div class="star-rating">
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item">
                                                                    <select class="star-rating-ro">
                                                                        @for($i = 0; $i <= 5; $i++)
                                                                        <option value="{{$i}}" {{$i == $interest->user->company->company_overall_rating($interest->user->company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </li>
                                                                <li class="list-inline-item thumb-review"><a href="#">({{$interest->user->company->reviews->count()}} {{__('general.reviews_title')}})</a></li>
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="modal-company">
                                                <p class="tags"><b>{{__('project.company_size')}}:</b> {{$interest->user->company->company_size}}</p>
                                                <p class="tags"><b>{{__('project.about_company')}}:</b></p>
                                                {!! substr($interest->user->company->company_description, 0, 400) !!}
                                                <div class="btn-list mt-3 mb-4 d-flex justify-content-between">
                                                    @if($interest->is_accepted === 1)
                                                        <p>{{__('company.accepted')}}</p>
                                                    @elseif($interest->is_accepted === 0)
                                                        <p>{{__('company.declined')}} - {{$interest->reason}}</p>
                                                    @else

                                                        <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('accept-interest-{{$interest->id}}').submit();">{{__('company.accept')}}</button>                  
                                                        <!-- <button type="submit" class="btn btn-sm btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('decline-interest-{{$interest->id}}').submit();">{{__('company.decline')}}</button> -->
                                                        {{__('home.or_title')}}
                                                        <br>
                                                        <form id="decline-interest-{{$interest->id}}" action="{{route('decline.interest', $interest->id)}}" method="post" class="write-review compnay-edit">
                                                            {{csrf_field()}}
                                                            <select id="decline-select" class="form-control custom-select d-block" name="decline_reason" onchange="event.preventDefault(); document.getElementById('decline-interest-{{$interest->id}}').submit();">
                                                                <option>اختر  سبب الرفض</option>
                                                                @foreach($rejection_reasons as $reason)
                                                                    <option value="{{$reason}}" {{$reason == $interest->reason ? 'selected' : ''}}>{{$reason}}</option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    @endif
                                                    <form id="accept-interest-{{$interest->id}}" action="{{route('accept.interest', $interest->id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form>  
                                                    <!-- <form id="decline-interest-{{$interest->id}}" action="{{route('decline.interest', $interest->id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach

                                    <h5 class="modal-title">{{__('general.approved_interests')}}</h5>
                                    <div class="row gray-title mb-4">
                                        <div class="col-md-4">
                                            <h3>{{__('project.supplier')}}</h3>
                                        </div>
                                        <div class="col-md-8">
                                            <h3>{{__('project.company_info')}}</h3>
                                        </div>
                                    </div>
                                    @foreach($approved_interests as $interest)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="modal-sidebar">
                                                <div class="media-body">
                                                    <h5 class="mt-1 mb-2"><a href="{{route('front.company.show', $interest->user->company->slug)}}">{{$interest->user->company->company_name}}</a></h5>
                                                    <p class="tags"><b>{{__('project.industry')}}</b>:<a href="{{route('front.industry.show', $interest->user->company->industry->slug)}}">
                                                        @if(app()->getLocale() == 'ar')
                                                        {{$interest->user->company->industry->industry_name_ar}}
                                                        @else
                                                        {{$interest->user->company->industry->industry_name}}
                                                        @endif
                                                    </a></p>
                                                    <p class="tags"><b>{{__('general.specs_tag_title')}}</b> <span>
                                                        @foreach($interest->user->company->specialities as $speciality)
                                                            {{$speciality->speciality_name}},
                                                        @endforeach
                                                    </span></p>
                                                </div>
                                                <div class="star-rating mb-3">
                                                    <ul class="list-inline">
                                                        @if($interest->user->company->reviews->count() > 0)
                                                        <div class="star-rating">
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item">
                                                                    <select class="star-rating-ro">
                                                                        @for($i = 0; $i <= 5; $i++)
                                                                        <option value="{{$i}}" {{$i == $interest->user->company->company_overall_rating($interest->user->company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </li>
                                                                <li class="list-inline-item thumb-review"><a href="#">({{$interest->user->company->reviews->count()}} {{__('general.reviews_title')}})</a></li>
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="modal-company">
                                                <p class="tags"><b>{{__('project.company_size')}}:</b> {{$interest->user->company->company_size}}</p>
                                                <p class="tags"><b>{{__('project.about_company')}}:</b></p>
                                                {!! substr($interest->user->company->company_description, 0, 400) !!}
                                                <div class="btn-list mt-3 mb-4">
                                                    @if($interest->is_accepted === 1)
                                                        <p>{{__('company.accepted')}}</p>
                                                    @elseif($interest->is_accepted === 0)
                                                        <p>{{__('company.declined')}} - {{$interest->reason}}</p>
                                                    @else
                                                        <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('accept-interest-{{$interest->id}}').submit();">{{__('company.accept')}}</button>                  
                                                        <button type="submit" class="btn btn-sm btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('decline-interest-{{$interest->id}}').submit();">{{__('company.decline')}}</button>
                                                    @endif
                                                    <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('undo-interest-{{$interest->id}}').submit();">{{__('company.undo')}}</button> 
                                                    <form id="accept-interest-{{$interest->id}}" action="{{route('accept.interest', $interest->id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form>  
                                                    <form id="decline-interest-{{$interest->id}}" action="{{route('decline.interest', $interest->id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form>
                                                    <form id="undo-interest-{{$interest->id}}" action="{{route('undo.interest', $interest->id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                    <h5 class="modal-title">{{__('general.rejected_interests')}}</h5>
                                    <div class="row gray-title mb-4">
                                        <div class="col-md-4">
                                            <h3>{{__('project.supplier')}}</h3>
                                        </div>
                                        <div class="col-md-8">
                                            <h3>{{__('project.company_info')}}</h3>
                                        </div>
                                    </div>
                                    @foreach($rejected_interests as $interest)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="modal-sidebar">
                                                <div class="media-body">
                                                    <h5 class="mt-1 mb-2"><a href="{{route('front.company.show', $interest->user->company->slug)}}">{{$interest->user->company->company_name}}</a></h5>
                                                    <p class="tags"><b>{{__('project.industry')}}</b>:<a href="{{route('front.industry.show', $interest->user->company->industry->slug)}}">
                                                        @if(app()->getLocale() == 'ar')
                                                        {{$interest->user->company->industry->industry_name_ar}}
                                                        @else
                                                        {{$interest->user->company->industry->industry_name}}
                                                        @endif
                                                    </a></p>
                                                    <p class="tags"><b>{{__('general.specs_tag_title')}}</b> <span>
                                                        @foreach($interest->user->company->specialities as $speciality)
                                                            {{$speciality->speciality_name}},
                                                        @endforeach
                                                    </span></p>
                                                </div>
                                                <div class="star-rating mb-3">
                                                    <ul class="list-inline">
                                                        @if($interest->user->company->reviews->count() > 0)
                                                        <div class="star-rating">
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item">
                                                                    <select class="star-rating-ro">
                                                                        @for($i = 0; $i <= 5; $i++)
                                                                        <option value="{{$i}}" {{$i == $interest->user->company->company_overall_rating($interest->user->company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </li>
                                                                <li class="list-inline-item thumb-review"><a href="#">({{$interest->user->company->reviews->count()}} {{__('general.reviews_title')}})</a></li>
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="modal-company">
                                                <p class="tags"><b>{{__('project.company_size')}}:</b> {{$interest->user->company->company_size}}</p>
                                                <p class="tags"><b>{{__('project.about_company')}}:</b></p>
                                                {!! substr($interest->user->company->company_description, 0, 400) !!}
                                                <div class="btn-list mt-3 mb-4">
                                                    @if($interest->is_accepted === 1)
                                                        <p>{{__('company.accepted')}}</p>
                                                    @elseif($interest->is_accepted === 0)
                                                        <p>{{__('company.declined')}} - {{$interest->reason}}</p>
                                                    @else
                                                        <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('accept-interest-{{$interest->id}}').submit();">{{__('company.accept')}}</button>                  
                                                        <button type="submit" class="btn btn-sm btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('decline-interest-{{$interest->id}}').submit();">{{__('company.decline')}}</button>
                                                    @endif
                                                    <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('undo-interest-{{$interest->id}}').submit();">{{__('company.undo')}}</button> 
                                                    <form id="accept-interest-{{$interest->id}}" action="{{route('accept.interest', $interest->id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form>  
                                                    <form id="decline-interest-{{$interest->id}}" action="{{route('decline.interest', $interest->id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form>
                                                    <form id="undo-interest-{{$interest->id}}" action="{{route('undo.interest', $interest->id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

@endsection