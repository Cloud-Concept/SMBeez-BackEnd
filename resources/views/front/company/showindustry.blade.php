@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="hero-company">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Browse hundreds of Masharee3</h1>
                    <p class="text-center">In your local marketplace</p>
                    @if (!Auth::guest() && !$hasCompany && !count(Auth::user()->claims) > 0)
                    <div class="btn-hero text-center"><a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue">{{__('general.add_company_button')}}</a></div>
                    @elseif(Auth::guest())
                    <div class="btn-hero text-center"><a href="{{route('login')}}?action=add-company" class="btn btn-blue">{{__('general.add_company_button')}}</a></div>
                    @elseif (!Auth::guest() && $hasCompany || count(Auth::user()->claims) > 0)
                    <div class="btn-hero text-center"><a href="{{route('front.user.dashboard', Auth::user()->username)}}" class="btn btn-blue">Go to my dashboard</a></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include ('layouts.filter-sidebar-companies')
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
                                <p class="tags">{{__('general.more_in')}} 
                                    @foreach($company->industries as $industry)
                                        <a href="{{route('front.industry.show', $industry->slug)}}">
                                            @if(app()->getLocale() == 'ar')
                                            {{$industry->industry_name_ar}}
                                            @else
                                            {{$industry->industry_name}}
                                            @endif
                                        </a>
                                    @endforeach
                                </p>
                                <p class="tags"><b>{{__('general.specs_tag_title')}}</b>
                                    @foreach($company->specialities as $speciality)
                                        {{$speciality->speciality_name . ','}} 
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        @endforeach

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
                                                        @for($i = 0; $i <= 5; $i++)
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
                                <p class="tags">{{__('general.more_in')}}
                                    <a href="{{route('front.company.showindustry', $company->industry->slug)}}">
                                        @if(app()->getLocale() == 'ar')
                                        {{$company->industry->industry_name_ar}}
                                        @else
                                        {{$company->industry->industry_name}}
                                        @endif
                                    </a>
                                </p>
                                <p class="tags"><b>{{__('general.specs_tag_title')}}</b> 
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