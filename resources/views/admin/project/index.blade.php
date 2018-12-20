@extends('layouts.admin')

@section('content')

<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.superadmin-sidebar')
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Projects</li>
                        </ol>
                    </nav>
                    <!-- <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i>{{__('general.publish_project')}}</a></div> -->
                    <div class="row sd-project">
                        <div class="col-md-12">
                            <form class="user-setting sd-tickets" action="{{route('superadmin.filter.projects')}}" role="search" method="get">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="city" class="form-control custom-select d-block">
                                                <option value="Cairo">Cairo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="industry" class="form-control custom-select d-block">
                                                <option value="">{{__('general.all_industries_title')}}</option>
                                                @foreach($industries as $key => $getindustry)
                                                    @if(app()->getLocale() == 'ar')
                                                    <option value="{{$getindustry->id}}" {{ $getindustry->id == request()->query('industry') ? 'selected' : ''}}>{{$getindustry->industry_name_ar}}</option>
                                                    @else
                                                    <option value="{{$getindustry->id}}" {{ $getindustry->id == request()->query('industry') ? 'selected' : ''}}>{{$getindustry->industry_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select name="status" class="form-control custom-select d-block">
                                                @foreach($status as $stat)
                                                    <option value="{{$stat}}" {{ $stat == request()->query('status') ? 'selected' : ''}}>{{$stat}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="d-flex"><input class="form-control" name="s" value="{{request()->query('s')}}" placeholder="Search Projects" type="search"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Project</button></div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between mt-4 pb-3 all-project-list">
                                <h4 class="pt-2">All Projects</h4>
                            </div>
                            @foreach($projects as $project)
                            <div class="project-box-side box-block my-3 {{$project->status === 'deleted' ? 'disable' : ''}}">
                                <a href="{{route('admin.project.edit', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags(substr($project->project_description, 0, 150))}}...</p>
                            	<p class="tags">{{__('general.more_in')}} 
	                                <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">@if(app()->getLocale() == 'ar')
                                        <td>{{$project->industries[0]->industry_name_ar}}</td>
                                        @else
                                        <td>{{$project->industries[0]->industry_name}}</td>
                                        @endif</a>
	                            </p>
                            </div>
                            @endforeach
                            
                            {{$projects->appends(['city' => request()->input('city'), 'industry' => request()->input('industry'), 'status' => request()->input('status'), 's' => request()->input('s') ])->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection