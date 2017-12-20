@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="hero-company">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Browse more than {{$companies->count()}} SMBeez</h1>
                    <p class="text-center">In your local marketplace</p>
                    @if (!Auth::guest() && !$hasCompany && \Laratrust::hasRole('user|superadmin'))
                    <div class="btn-hero text-center"><a href="{{route('front.company.create')}}" class="btn btn-blue">Add your company</a></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="filter">
                        <form action="" class="form-group row">
                            <div class="col-md-12">
                                <select class="custom-select mb-2 mr-sm-2 mb-sm-0 w-100">
                                    <option>All Industries</option>
                                    @foreach($industries as $key => $getindustry)
                                    <option value="{{$getindustry->id}}" {{$getindustry->id == $industry->id ? 'selected' : ''}}>{{$getindustry->industry_name}}</option>
                                    @endforeach
                                </select>
                                <div class="search-filter">
                                    <h3>Select from specialities <i class="fa fa-filter pull-right" aria-hidden="true"></i></h3>
                                    <div class="form-group"><input type="text" class="form-control" placeholder="Search within companies"></div>
                                    <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Electrical Supplies</span></label></div>
                                    <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">CMS</span></label></div>
                                    <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Civil Engineering</span></label></div>
                                    <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Sales force</span></label></div>
                                    <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Finanacial Consultancy</span></label></div>
                                    <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Tutoring</span></label></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row equal">
                        @foreach($industry->projects as $project)
                        <div class="col-md-12 mt-5">
                            <div class="project-box project-box-side box-block">
                                <a href="{{route('front.project.show', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags($project->project_description)}}</p> 
                                <p class="tags">More in: 
                                    @foreach($project->industries as $industry)
                                    <a href="{{route('front.industry.show', $industry->slug)}}">{{$industry->industry_name}}</a>
                                    @endforeach
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