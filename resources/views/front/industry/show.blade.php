@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="hero-project">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">{{__('general.opportunities_headline')}}</h1>
                    <p class="text-center">{{__('general.opportunities_sub_headline')}}</p>
                    @if (!Auth::guest() && $hasCompany)
                    <div class="btn-hero text-center"><button class="btn btn-yellow-2" data-toggle="modal" data-target="#add-project">{{__('general.publish_project')}}</button></div>
                    @elseif(Auth::guest())
                    <div class="btn-hero text-center"><a href="{{route('login')}}?action=add-project" class="btn btn-yellow-2">{{__('general.publish_project')}}</a></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include ('layouts.filter-sidebar-opportunities')
                </div>
                <div class="col-md-8">
                    <div class="row equal">
                        @foreach($featured_projects as $project)
                        <div class="col-md-6">
                            <div class="project-box box-block">
                                <a href="{{route('front.project.show', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags(substr($project->project_description, 0, 60))}}...</p> 
                                <p class="tags">{{__('general.more_in')}} 
                                    <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">@if(app()->getLocale() == 'ar')
                                    {{$project->industries[0]->industry_name_ar}}
                                    @else
                                    {{$project->industries[0]->industry_name}}
                                    @endif</a>
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
                    <div class="row equal infinite-scroll">
                        @if($industry_projects->count() == 0)
                        <div class="col-md-12 mt-5">
                            <p>{{__('general.no_opportunities_found')}}</p>
                        </div>
                        @endif
                        @foreach($industry_projects as $project)
                        <div class="col-md-12 mt-5">
                            <div class="project-box project-box-side box-block">
                                <a href="{{route('front.project.show', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags(substr($project->project_description, 0, 150))}}...</p> 
                                <p class="tags">{{__('general.more_in')}} 
                                    <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">@if(app()->getLocale() == 'ar')
                                    {{$project->industries[0]->industry_name_ar}}
                                    @else
                                    {{$project->industries[0]->industry_name}}
                                    @endif</a>
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

                        {{$industry_projects->appends(['specialities' => request()->input('specialities'), 'industry' => request()->input('industry')])->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include ('layouts.create-project-modal')

@endsection