@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="hero-company">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Browse hundreds of SMBeez</h1>
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
                    @include ('layouts.filter-sidebar')
                </div>
                <div class="col-md-8">
                    <div class="row equal">
                        @foreach($featured_companies as $company)
                        <div class="col-md-6">
                            <div class="company-box box-block mb-5">
                                <img class="img-responsive" src="{{asset($company->cover_url)}}" alt="{{$company->company_name}}">
                                <div class="company-box-header media mt-4">
                                    <a href="{{route('front.company.show', $company->slug)}}" class="mr-3"><i class="fa fa-circle fa-4x" aria-hidden="true"></i></a>
                                    <div class="media-body">
                                        <a href="{{route('front.company.show', $company->slug)}}"><p class="thumb-title mt-1 mb-1">{{$company->company_name}}</p></a>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item thumb-review"><a href="">({{$company->reviews->count()}} Reviews)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p>{{strip_tags($company->company_description)}}</p>
                                <p class="tags">More in: 
                                    @foreach($company->industries as $industry)
                                        <a href="{{route('front.industry.show', $industry->slug)}}">{{$industry->industry_name}}</a>
                                    @endforeach
                                </p>
                                <p class="tags"><b>Specialities:</b>
                                    @foreach($company->specialities as $speciality)
                                        {{$speciality->speciality_name . ','}} 
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        @endforeach
                        {{$industry->industry_name}}
                        {{$industry->companies}}
                        @foreach($industry->companies as $company)
                        <div class="col-md-12 mt-2">
                            <div class="company-box company-box-side box-block mb-5">
                                <div class="company-box-header media">
                                    <a href="{{route('front.company.show', $company->slug)}}" class="mr-3"><i class="fa fa-circle fa-4x" aria-hidden="true"></i></a>
                                    <div class="media-body">
                                        <a href="{{route('front.company.show', $company->slug)}}"><p class="thumb-title mt-1 mb-1">{{$company->company_name}}</p></a>
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
                                    </div>
                                </div>
                                <p>{{strip_tags($company->company_description)}}</p>
                                <p class="tags">More in:
                                    @foreach($company->industries as $industry)
                                        <a href="{{route('front.industry.show', $industry->slug)}}">{{$industry->industry_name}}</a>
                                    @endforeach
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
</main>
@endsection