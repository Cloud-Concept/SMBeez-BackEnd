@extends('layouts.main')

@section('content')
<main class="cd-main-content">
    <section class="hero">
        <div class="hero-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 col-md-12 offset-xl-3">
                        <h1 class="text-center">Matchmaking for Small Businesses</h1>
                        <p class="text-center">{{__('home.slider_headline')}}</p>
                        <div class="btn-hero text-center">
                            @if (!Auth::guest() && $hascompany)
                            <a href="{{route('front.company.all')}}" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.browse_companies')}}</a>
                            @elseif(!Auth::guest() && count(Auth::user()->claims) > 0)
                            <a href="{{route('front.company.all')}}" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.browse_companies')}}</a>
                            @elseif (!Auth::guest() && !$hascompany)
                            <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                            @elseif (!Auth::guest() && !count(Auth::user()->claims) > 0)
                            <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                            @elseif(Auth::guest())
                            <a href="{{route('login')}}?action=add-company" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                            @endif
                            <span>or </span>
                            @if (!Auth::guest() && !$hascompany)
                            <a href="{{route('front.industry.index')}}" class="btn btn-blue"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {{__('general.browse_opportunities_button')}}</a>
                            @elseif (!Auth::guest() && $hascompany)
                            <a href="#" data-toggle="modal" data-target="#add-project" class="btn btn-blue"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {{__('general.publish_project')}}</a>
                            @elseif(Auth::guest())
                            <a href="{{route('login')}}/?action=add-project" class="btn btn-blue"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {{__('general.publish_project')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <section class="hero-slider align-items-center d-none d-md-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="d-flex justify-content-around">
                        <li class="align-self-center"><a href=""><img src="images/media/img-01.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-02.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-03.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-04.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-05.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-06.jpg" alt="title here"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section> -->
    <section class="featured-companies bg-gray">
        <div class="container-fluid">
            <div class="row px-4">
                <div class="col-md-4">
                    <div class="sidebar sidebar-01">
                        <h2>{{__('home.find_suppliers')}}</h2>
                        <p class="mt-5 mb-5">{{__('home.find_work_desc')}}</p>
                        <a href="{{route('front.company.all')}}" class="btn btn-blue btn-yellow"><i class="fa fa-angle-right" aria-hidden="true"></i> {{__('general.browse_companies')}}</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="mb-5">{{__('home.featured_companies')}} <a href="{{route('front.company.all')}}" class="btn btn-trans pull-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> {{__('home.discover_more')}}</a></h3>
                        </div>
                        @foreach($featured_companies as $company)
                        <div class="col-md-6">
                            <div class="company-box box-block mb-5">
                                @if($company->cover_url  && file_exists(public_path('/') . $company->cover_url))
                                    <img class="img-fluid img-full" src="{{ asset($company->cover_url) }}" alt="">
                                @endif
                                <div class="company-box-header media mt-4">
                                    <a href="{{route('front.company.show', $company->slug)}}" class="mr-3 thumb-int"> {{substr($company->company_name, 0, 1)}} </a>
                                    <div class="media-body">
                                        <a href="{{route('front.company.show', $company->slug)}}"><p class="thumb-title mt-1 mb-1">{{$company->company_name}}</p></a>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <select class="star-rating-ro">
                                                        @for($i = 0; $i <= 5; $i++)
                                                        <option value="{{$i}}" {{$i == $company->company_overall_rating($company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </li>
                                                <li class="list-inline-item thumb-review"><p>({{$company->reviews->count()}} Reviews)</p></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p>{{strip_tags(substr($company->company_description, 0, 180))}}...</p>
                                <p class="tags">{{__('general.more_in')}} 
                                    <a href="{{route('front.company.showindustry', $company->industry->slug)}}">{{$company->industry->industry_name}}</a>
                                </p>
                                @if($company->specialities->count() > 0)
                                <p class="tags"><b>{{__('general.specs_tag_title')}}</b>
                                    @foreach($company->specialities as $speciality)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{$speciality->speciality_name}} 
                                    @endforeach
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="featured-projects box-block">
        <div class="container-fluid">
            <div class="row px-4">
                <div class="col-md-8">
                    <div class="row equal">
                        <div class="col-md-12">
                            <h3 class="mb-5">{{__('home.featured_opportunities')}} <a href="{{route('front.industry.index')}}" class="btn btn-trans pull-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> {{__('home.discover_more')}}</a></h3>
                        </div>
                        @foreach($featured_projects as $project)
                        <div class="col-md-6 mb-4">
                            <div class="project-box box-block">
                                <a href="{{route('front.project.show', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags(substr($project->project_description, 0, 100))}}</p>
                                <p class="tags">{{__('general.more_in')}} 
                                    <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a>
                                </p>
                                @if($project->specialities->count() > 0)
                                <p class="tags"><b>{{__('general.specs_tag_title')}}</b> 
                                    @foreach($project->specialities as $speciality)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{$speciality->speciality_name}} 
                                    @endforeach
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row equal">
                        <div class="col-md-12">
                            <h3 class="mb-5">{{__('home.latest_opportunities')}}</h3>
                        </div>
                        @foreach($industry_projects as $project)
                        <div class="col-md-12 mb-4">
                            <div class="project-box project-box-side box-block">
                                <a href="{{route('front.project.show', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags(substr($project->project_description, 0, 100))}}...</p>
                                <p class="tags">{{__('general.more_in')}} 
                                    <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a>
                                </p>
                                @if($project->specialities->count() > 0)
                                <p class="tags"><b>{{__('general.specs_tag_title')}}</b> 
                                    @foreach($project->specialities as $speciality)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{$speciality->speciality_name}} 
                                    @endforeach
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="create-intro-sidebar py-5 bg-gray">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-12 offset-md-3 text-center">
                    <h2><i class="fa fa-folder-o fa-3x mb-3" aria-hidden="true"></i><br>{{__('home.find_work_title')}}</h2>
                    <p class="mt-5 mb-5">{{__('home.find_work_desc')}}</p>
                    <a href="{{route('front.industry.index')}}" class="btn btn-blue btn-yellow"><i class="fa fa-angle-right" aria-hidden="true"></i> {{__('general.browse_opportunities_button')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="create-intro bg-blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-12 offset-md-3 text-center">
                    <h2><i class="fa fa-files-o fa-2x mb-3" aria-hidden="true"></i><br>{{__('home.be_found')}}</h2>
                    <p class="mt-5 mb-5">{{__('home.be_found_desc')}}</p>
                    @if (!Auth::guest() && $hascompany)
                    <a href="{{route('front.company.all')}}" class="btn btn-blue btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.browse_companies')}}</a>
                    @elseif (!Auth::guest() && count(Auth::user()->claims) > 0)
                    <a href="{{route('front.company.all')}}" class="btn btn-blue btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.browse_companies')}}</a>
                    @elseif (!Auth::guest() && !$hascompany)
                    <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                    @elseif (!Auth::guest() && !count(Auth::user()->claims) > 0)
                    <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                    @elseif(Auth::guest())
                    <a href="{{route('login')}}?action=add-company" class="btn btn-blue btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> {{__('general.add_company_button')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

@if (!Auth::guest() && !$hascompany)
    @include ('layouts.add-company-modal')
@endif

@if (!Auth::guest() && $hascompany)
    @include ('layouts.create-project-modal')
@endif

@endsection