@extends('layouts.inner')

@section('content')

<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar-updates">
                        <h5 class="title-blue">My Bookmarks</h5>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="#bookmarked_companies">Companies</a></li>
                            <li class="list-group-item"><a href="#bookmarked_projects">Projects</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">My Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bookmarks</li>
                        </ol>
                    </nav>
                    <div class="bookmarks-block">
                        <h4 id="bookmarked_companies">Bookmarked Companies</h4>
                        <div class="row equal">
                            @foreach($bookmarked_companies as $bookmark)
                            <div class="col-md-12 mt-2">
                                <div class="company-box company-box-side box-block mb-5">
                                    <div class="company-box-header media">
                                        <a href="{{route('front.company.show', $bookmark->bookmarked_companies($bookmark->bookmarked_id)->slug)}}" class="mr-3"><i class="fa fa-circle fa-4x" aria-hidden="true"></i></a>
                                        <div class="media-body">
                                            <a href="{{route('front.company.show', $bookmark->bookmarked_companies($bookmark->bookmarked_id)->slug)}}"><p class="thumb-title mt-1 mb-1">{{$bookmark->bookmarked_companies($bookmark->bookmarked_id)->company_name}}</p></a>
                                            @if($bookmark->bookmarked_companies($bookmark->bookmarked_id)->reviews->count() > 0)
                                            <div class="star-rating">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <select class="star-rating-ro">
                                                            @for($i = 1; $i <= 5; $i++)
                                                            <option value="{{$i}}" {{$i == $bookmark->bookmarked_companies($bookmark->bookmarked_id)->company_overall_rating($bookmark->bookmarked_companies($bookmark->bookmarked_id)->id) ? 'selected' : ''}}>{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </li>
                                                    <li class="list-inline-item thumb-review"><a href="{{route('front.company.show', $bookmark->bookmarked_companies($bookmark->bookmarked_id)->slug)}}">({{$bookmark->bookmarked_companies($bookmark->bookmarked_id)->reviews->count()}} Reviews)</a></li>
                                                </ul>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <p>{{strip_tags(substr($bookmark->bookmarked_companies($bookmark->bookmarked_id)->company_description, 0, 180))}}</p>
                                    <p class="tags">More in:
                                        <a href="{{route('front.industry.show', $bookmark->bookmarked_companies($bookmark->bookmarked_id)->industry->slug)}}">{{$bookmark->bookmarked_companies($bookmark->bookmarked_id)->industry->industry_name}}</a>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <h4 id="bookmarked_projects">Bookmarked Projects</h4>
                        <div class="row equal mb-5">

                            @foreach($bookmarked_projects as $bookmark)
                            <div class="col-md-6">
                                <div class="project-box box-block">
                                    <p class="thumb-title mt-1 mb-1">{{$bookmark->bookmarked_projects($bookmark->bookmarked_id)->project_title}}</p>
                                    <p>{{strip_tags(substr($bookmark->bookmarked_projects($bookmark->bookmarked_id)->project_description, 0, 100))}}</p>
                                    <p class="tags">More in: <a href="{{route('front.industry.show', $bookmark->bookmarked_projects($bookmark->bookmarked_id)->industries[0]->slug)}}">{{$bookmark->bookmarked_projects($bookmark->bookmarked_id)->industries[0]->industry_name}}</a></p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <h3><i class="fa fa-thumb-tack fa-rotate-45" aria-hidden="true"></i> Tips</h3>
                        <p>As conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the host to your journey; without Her we could not find the unfolding adventures that attract and feed our souls</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection