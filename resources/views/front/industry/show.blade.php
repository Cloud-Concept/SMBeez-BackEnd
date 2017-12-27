@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="hero-project">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Discover hundreds of opportunities</h1>
                    <p class="text-center">In your local marketplace</p>
                    @if (!Auth::guest() && $hasCompany && \Laratrust::hasRole('company|superadmin'))
                    <div class="btn-hero text-center"><a href="{{route('front.project.create')}}" class="btn btn-yellow-2">Publish your project</a></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include ('layouts.filter-sidebar')
                </div>
                <div class="col-md-8">
                    <div class="row equal">
                        @foreach($featured_projects as $project)
                        <div class="col-md-6">
                            <div class="project-box box-block">
                                <a href="{{route('front.project.show', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags($project->project_description)}}</p> 
                                <p class="tags">More in: 
                                    <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a>
                                </p>
                            </div>
                        </div>
                        @endforeach
                        
                        @foreach($industry->projects as $project)
                        <div class="col-md-12 mt-5">
                            <div class="project-box project-box-side box-block">
                                <a href="{{route('front.project.show', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags($project->project_description)}}</p> 
                                <p class="tags">More in: 
                                    <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection