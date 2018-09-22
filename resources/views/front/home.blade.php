@extends('layouts.main')

@section('content')

<main id="next-block" class="cd-main-content">
    <section class="featured-block text-center mt-5 pt-5">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="row justify-content-md-center">
                <div class="col-md-9 align-self-center mb-5">
                  <h2>{{__('home.what_masharee3')}}</h2>
                  <p class="pt-5">{{__('home.what_masharee3_desc')}}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 d-flex">
              <div class="box-block-into box-gray mb-5 p-5">
                <img src="images/media/block-01.svg" alt="" class="img-height img-responsive mb-3">
                <h3>{{__('home.be_found')}}</h3>
                <p class="mt-3">{{__('home.be_found_desc')}}</p>
              </div>
            </div>
            <div class="col-md-4 d-flex">
              <div class="box-block-into box-gray mb-5 p-5">
                <img src="images/media/block-02.svg" alt="" class="img-height img-responsive mb-3">
                <h3>{{__('home.find_suppliers')}}</h3>
                <p class="mt-3">{{__('home.find_work_desc')}}</p>
              </div>
            </div>
            <div class="col-md-4 d-flex">
              <div class="box-block-into box-gray mb-5 p-5">
                <img src="images/media/block-03.svg" alt="" class="img-height img-responsive mb-3">
                <h3>{{__('home.reg_ur_company')}}</h3>
                <p class="mt-3">{{__('home.reg_ur_company_desc')}}</p>
              </div>
            </div>
          </div>
        </div>
    </section>

    <section class="featured-block featured-block-gray mt-5 pt-5 pb-5">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="row justify-content-md-center text-center">
                <div class="col-md-9 align-self-center mb-5">
                  <h2>{{__('home.latest_opportunities')}}</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
          	@foreach($industry_projects as $project)
            <div class="col-md-6 d-flex">
              <div class="box-block-into px-3 pb-3 mb-5">
                <a href="{{route('front.project.show', $project->slug)}}" title="{{$project->project_title}}"><h3>{{$project->project_title}}</h3></a>
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
                <p>{{strip_tags(substr($project->project_description, 0, 100))}}...</p>
                <a href="{{route('front.project.show', $project->slug)}}"> {{__('home.discover_more')}} <i class="fa fa-caret-left" aria-hidden="true"></i></a>
              </div>
            </div>
            @endforeach
            <div class="col-md-6 col-xs-12 offset-md-3 text-center mt-5">
              <a href="{{route('front.industry.index')}}" class="btn btn-blue btn-yellow">{{__('general.browse_opportunities_button')}}</a>
            </div>
          </div>
        </div>
    </section>

  	<section class="featured-block mt-5 pt-5 mb-5">
  	    <div class="container">
  	      <div class="row">
  	        <div class="col-md-12">
  	          <div class="row justify-content-md-center">
  	            <div class="col-md-9 text-center align-self-center mb-5">
  	              <h2>{{__('home.featured_companies')}}</h2>
  	            </div>
  	          </div>
  	        </div>
  	      </div>
  	      <div class="row">
  	      	@foreach($featured_companies as $company)
  	        <div class="col-md-6 d-flex">
  	          <div class="box-block-into box-trans px-3 pb-3">
  	          	@if($company->cover_url  && file_exists(public_path('/') . $company->cover_url))
                      <img class="img-responsive img-box" src="{{ asset($company->cover_url) }}" alt="">
                  @endif
                  <a href="{{route('front.company.show', $company->slug)}}"><h3>{{$company->company_name}}</h3></a>
  	            <div class="media-body">
                      <div class="star-rating">
                          <ul class="list-inline">
                              <li class="list-inline-item">
                                  <select class="star-rating-ro">
                                      @for($i = 0; $i <= 5; $i++)
                                      <option value="{{$i}}" {{$i == $company->company_overall_rating($company->id) ? 'selected' : ''}}>{{$i}}</option>
                                      @endfor
                                  </select>
                              </li>
                              <li class="list-inline-item thumb-review"><p>({{$company->reviews->count()}} {{__('general.reviews_title')}})</p></li>
                          </ul>
                      </div>
                  </div>
  	            <p>{{strip_tags(substr($company->company_description, 0, 180))}}...</p>
  	            <a href="{{route('front.company.show', $company->slug)}}"> {{__('home.discover_more')}} <i class="fa fa-caret-left" aria-hidden="true"></i></a>
  	          </div>
  	        </div>
  	        @endforeach
  	        <div class="col-md-6 col-xs-12 offset-md-3 text-center mt-5">
  	          <a href="{{route('front.company.all')}}" class="btn btn-blue btn-yellow">{{__('general.browse_companies')}}</a>
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