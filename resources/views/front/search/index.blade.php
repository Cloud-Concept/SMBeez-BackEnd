@extends('layouts.inner')

@section('content')

<main class="cd-main-content">
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar-updates">
                        <h5 class="title-blue">Search Results</h5>
                        <ul class="list-group flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li class="list-group-item"><a class="active" id="v-opportunities-tab" data-toggle="pill" href="#v-opportunities" role="tab" aria-controls="v-opportunities" aria-selected="true">Opportunities ({{$projects_count}})</a></li>
                            <li class="list-group-item"><a id="v-companies-tab" data-toggle="pill" href="#v-companies" role="tab" aria-controls="v-companies" aria-selected="false">Companies ({{$companies_count}})</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-opportunities" role="tabpanel" aria-labelledby="v-opportunities-tab">
                            <p class="search-info">Results for ‘{{request()->input('s')}}’ Opportunities...</p>
                            <h3 class="search-title text-uppercase">Project Details <span class="pull-right">Closing Date</span></h3>
                            @if($projects_count == 0)
                            	<br>
                            	<p>No opportunities found.</p>
                            @endif
                            <div class="infinite-scroll">
	                            @foreach($projects as $project)
	                            <div class="search-block br-btm mb-3 pb-3 container">
	                                <div class="row equal">
	                                    <div class="col-md-9">
	                                        <div class="company-box-header media mt-4">
	                                            <div class="media-body">
	                                                <h2 class="mt-1 mb-1"><a href="{{route('front.project.show', $project->slug)}}">{{$project->project_title}}</a></h2>
	                                            </div>
	                                        </div>
	                                        <p>{{strip_tags(substr($project->project_description, 0, 200))}}...</p>
	                                        <p class="tags">More in: 
	                                        <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a>
		                                    </p>
		                                    @if($project->specialities->count() > 0)
		                                    <p class="tags"><b>Specialities:</b> 
		                                        @foreach($project->specialities as $speciality)
		                                            {{ $loop->first ? '' : ', ' }}
		                                            {{$speciality->speciality_name}} 
		                                        @endforeach
		                                    </p>
		                                    @endif
	                                    </div>
	                                    <div class="col-md-3 media-body-info pt-3 d-flex flex-column align-items-end">
	                                        <p class="date align-top">{{$project->close_date->toFormattedDateString()}}</p>
	                                        <a href="{{route('front.project.show', $project->slug)}}" class="btn btn-sm btn-yellow-2 mb-3 mt-auto">View Project</a>
	                                    </div>
	                                </div>
	                            </div>
	                            @endforeach
	                            {{$projects->appends(['s' => request()->input('s')])->links()}}
                            </div>
                            
                        </div>
                        <div class="tab-pane search-content-oo fade" id="v-companies" role="tabpanel" aria-labelledby="v-companies-tab">
                            <p class="search-info">Results for ‘{{request()->input('s')}}’ Opportunities...</p>
                            <h3 class="search-title text-uppercase">Company info <span class="pull-right">Industry</span></h3>
                            @if($companies_count == 0)
                            	<br>
                            	<p>No companies found.</p>
                            @endif
                            <div class="infinite-scroll-2">
	                            @foreach($companies as $company)
	                            <div class="search-block br-btm mb-3 pb-3 container">
	                                <div class="row">
	                                    <div class="col-md-9">
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
			                                <p>
			                                @if($company->company_description)
			                                {{strip_tags(substr($company->company_description, 0, 250))}}...
			                                <br>
			                                @endif
			                                {{strip_tags(substr($company->location, 0, 55))}}
			                                </p>
			                                @if($company->specialities->count() > 0)
			                                <p class="tags"><b>Specialities:</b> 
			                                    @foreach($company->specialities as $speciality)
			                                        {{ $loop->first ? '' : ', ' }}
			                                        {{$speciality->speciality_name}} 
			                                    @endforeach
			                                </p>
			                                @endif
	                                    </div>
	                                    <div class="col-md-3">
	                                        <div class="media-body-info pt-3 text-right"><a href="{{route('front.industry.show', $company->industry->slug)}}">{{$company->industry->industry_name}}</a></div>
	                                    </div>
	                                </div>
	                            </div>
	                            @endforeach
	                            {{$companies->appends(['s' => request()->input('s')])->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection