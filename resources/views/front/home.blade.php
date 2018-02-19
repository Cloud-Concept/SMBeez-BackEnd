@extends('layouts.main')

@section('content')
<main class="cd-main-content">
    <section class="hero">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Matchmaking for Small Businesses</h1>
                    <p class="text-center">Find work and source suppliers in your local marketplace...</p>
                    <div class="btn-hero text-center">
                        @if (!Auth::guest() && \Laratrust::hasRole('company|superadmin'))
                        <a href="{{route('front.company.all')}}" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> Browse Companies</a>
                        @elseif (!Auth::guest() && \Laratrust::hasRole('user|superadmin'))
                        <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> Add your company</a>
                        @elseif(Auth::guest())
                        <a href="{{route('login')}}" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> Add your company</a>
                        @endif
                        <span>or </span>
                        @if (!Auth::guest() && \Laratrust::hasRole('user|superadmin'))
                        <a href="{{route('front.industry.index')}}" class="btn btn-blue"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Browse Opportunities</a>
                        @elseif (!Auth::guest() && \Laratrust::hasRole('company|superadmin'))
                        <a href="#" data-toggle="modal" data-target="#add-project" class="btn btn-blue"><i class="fa fa-folder-open-o" aria-hidden="true"></i> publish your project</a>
                        @elseif(Auth::guest())
                        <a href="{{route('login')}}" class="btn btn-blue"><i class="fa fa-folder-open-o" aria-hidden="true"></i> publish your project</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="hero-slider align-items-center d-none d-md-block">
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
    </section>
    <section class="featured-companies bg-gray">
        <div class="container-fluid">
            <div class="row px-4">
                <div class="col-md-4">
                    <div class="sidebar sidebar-01">
                        <h2>Find Suppliers</h2>
                        <p class="mt-5 mb-5">Browse thousands of reliable suppliers in different industries. Contact suppliers through SMBeez or directly. Check out the suppliers’ reviews by other clients like you and engage confidently in business relationships based on mutual trust.</p>
                        <a href="{{route('front.company.all')}}" class="btn btn-blue btn-yellow"><i class="fa fa-angle-right" aria-hidden="true"></i> Browse Companies</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="mb-5">Featured companies <a href="{{route('front.company.all')}}" class="btn btn-trans pull-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> Discover more</a></h3>
                        </div>
                        @foreach($featured_companies as $company)
                        <div class="col-md-6">
                            <div class="company-box box-block mb-5">
                                @if($company->cover_url)
                                <img class="img-responsive" src="{{asset($company->cover_url)}}" alt="{{$company->company_name}}">
                                @endif
                                <div class="company-box-header media mt-4">
                                    <a href="{{route('front.company.show', $company->slug)}}" class="mr-3"><i class="fa fa-circle fa-4x" aria-hidden="true"></i></a>
                                    <div class="media-body">
                                        <a href="{{route('front.company.show', $company->slug)}}"><p class="thumb-title mt-1 mb-1">{{$company->company_name}}</p></a>
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
                                                <li class="list-inline-item thumb-review"><a href="{{route('front.company.show', $company->slug)}}">({{$company->reviews->count()}} Reviews)</a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <p>{{strip_tags(substr($company->company_description, 0, 180))}}...</p>
                                <p class="tags">More in: 
                                    <a href="{{route('front.industry.show', $company->industry->slug)}}">{{$company->industry->industry_name}}</a>
                                </p>
                                <p class="tags"><b>Specialities:</b>
                                    @foreach($company->specialities as $speciality)
                                        {{$speciality->speciality_name . ','}} 
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
    <section class="featured-projects box-block">
        <div class="container-fluid">
            <div class="row px-4">
                <div class="col-md-8">
                    <div class="row equal">
                        <div class="col-md-12">
                            <h3 class="mb-5">Featured Opportunities <a href="{{route('front.industry.index')}}" class="btn btn-trans pull-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> Discover more</a></h3>
                        </div>
                        @foreach($featured_projects as $project)
                        <div class="col-md-6 mb-4">
                            <div class="project-box box-block">
                                <p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p>
                                <p>{{strip_tags(substr($project->project_description, 0, 100))}}</p>
                                <p class="tags">More in: 
                                    <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row equal">
                        <div class="col-md-12">
                            <h3 class="mb-5">Latest Opportunities</h3>
                        </div>
                        @foreach($industry_projects as $project)
                        <div class="col-md-12 mb-4">
                            <div class="project-box project-box-side box-block">
                                <p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p>
                                <p>{{strip_tags(substr($project->project_description, 0, 100))}}...</p>
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
    <section class="create-intro-sidebar py-5 bg-gray">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-12 offset-md-3 text-center">
                    <h2><i class="fa fa-folder-o fa-3x mb-3" aria-hidden="true"></i><br>Find Work</h2>
                    <p class="mt-5 mb-5">Browse thousands of reliable suppliers in different industries. Contact suppliers through SMBeez or directly. Check out the suppliers’ reviews by other clients like you and engage confidently in business relationships based on mutual trust.</p>
                    <a href="{{route('front.industry.index')}}" class="btn btn-blue btn-yellow"><i class="fa fa-angle-right" aria-hidden="true"></i> Browse Opportunities</a>
                </div>
            </div>
        </div>
    </section>
    <section class="create-intro bg-blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-12 offset-md-3 text-center">
                    <h2><i class="fa fa-files-o fa-2x mb-3" aria-hidden="true"></i><br>Be Found</h2>
                    <p class="mt-5 mb-5">Create your company profile and sar thousands of reliable suppliers in different industries. Contact suppliers through SMBeez or directly. Check out the suppliers’ reviews by other clients like you and engage confidently in business relationships based on mutual trust.</p>
                    @if (!Auth::guest() && \Laratrust::hasRole('company|superadmin'))
                    <a href="{{route('front.company.all')}}" class="btn btn-blue btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> Browse Companies</a>
                    @elseif (!Auth::guest() && \Laratrust::hasRole('user|superadmin'))
                    <a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> Add your company</a>
                    @elseif(Auth::guest())
                    <a href="{{route('login')}}" class="btn btn-blue btn-yellow-2"><i class="fa fa-clone" aria-hidden="true"></i> Add your company</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

@include ('layouts.add-company-modal')
@include ('layouts.create-project-modal')

@endsection