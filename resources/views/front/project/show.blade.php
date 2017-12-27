@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <h3><i class="fa fa-thumb-tack fa-rotate-45" aria-hidden="true"></i> Tips</h3>
                        <p>always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the host to your journey</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="box-block-gray">
                        <h3>Project Details <a href="" class="btn-more pull-right"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a></h3>
                        <ul class="list-unstyled details-box">
                            @if(!$project->is_owner(Auth::user()->id))

                                @if($project->awarded_to == Auth::user()->id)
                                    <li>Client: <span><a href="{{route('front.company.show', $project->user->companies[0]->slug)}}">{{$project->user->companies[0]->company_name}}</a></span></li>
                                @else
                                <li>Client: <i class="fa fa-lock" aria-hidden="true"></i> <span> Locked</span></li>
                                @endif

                            <li>
                                <div class="pull-left">Client Overall Rating:</div>
                                <div class="star-rating pull-left">
                                    <ul class="list-inline">
                                        @if($project->user->companies[0]->reviews->count() > 0)
                                        <li class="list-inline-item">
                                            <select class="star-rating-fn">
                                                @for($i = 1; $i <= 5; $i++)
                                                <option value="{{$i}}" {{$i == $project->user->companies[0]->company_overall_rating($project->user->companies[0]->id) ? 'selected' : ''}}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                            @endif
                            <li>Budget: <span>{{$project->budget}} USD</span></li>
                            <li>Industry: <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a></li>
                            <li>Speciality: <span>
                                @foreach($project->specialities as $speciality)
                                    {{$speciality->speciality_name . ','}} 
                                @endforeach
                            </span></li>
                            <li>Status: 

                                @if($project->status == 'draft')

                                    <span>Draft</span>

                                @elseif($project->status == 'closed' && $project->status_on_close == 'expired')

                                    <span>Expired on {{$project->close_date->toFormattedDateString()}}</span>

                                @elseif($project->status == 'closed' && $project->status_on_close == 'awarded')

                                    <span>Closed</span>

                                @elseif($project->status == 'publish')

                                    <span>Open until {{$project->close_date->toFormattedDateString()}}</span>
                                @elseif($project->status == 'deleted')
                                    <span>Deleted</span> 
                                @endif

                            </li>
                        </ul>
                        @if(\Laratrust::hasRole('company|superadmin') && !$project->has_interest() && !$project->is_owner(Auth::user()->id))
                        <form action="{{route('express.interest')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <div class="text-center"><button type="submit" class="btn btn-blue btn-yellow">Express Interest</button></div>
                        </form>
                        @elseif($project->has_interest() && \Laratrust::hasRole('company|superadmin') && !$project->is_owner(Auth::user()->id))
                        <form action="{{route('withdraw.interest', $project->withdraw_interest())}}" method="post">
                            {{csrf_field()}}
                            {{ method_field('DELETE') }}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <div class="text-center"><button type="submit" class="btn btn-blue btn-yellow">Withdraw Interest</button></div>
                        </form>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.industry.all')}}">All industries</a></li>
                            <li class="breadcrumb-item"><a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$project->project_title}}</li>
                        </ol>
                    </nav>
                    <h2 class="mb-3 mt-3">{{$project->project_title}}</h2>
                    {!! $project->project_description !!}

                    @if($project->supportive_docs)
                    <div class="download-box d-flex justify-content-between align-items-center"><a href="{{asset('storage/projects/files/' . $project->supportive_docs)}}"><i class="fa fa-download" aria-hidden="true"></i> Download Project Documents</a> 
                        @if(\Laratrust::hasRole('company|superadmin') && !$project->has_interest() && !$project->is_owner(Auth::user()->id))
                        <form action="{{route('express.interest')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <button type="submit" class="btn btn-blue btn-yellow">Express Interest</button>
                        </form>
                        @elseif($project->has_interest() && \Laratrust::hasRole('company|superadmin') && !$project->is_owner(Auth::user()->id))
                        <form action="{{route('withdraw.interest', $project->withdraw_interest())}}" method="post">
                            {{csrf_field()}}
                            {{ method_field('DELETE') }}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <button type="submit" class="btn btn-blue btn-yellow">Withdraw Interest</button>
                        </form>
                        @endif
                    </div>
                    @endif
                    <h2 class="mb-4 mt-5">Similar Projects</h2>
                    <div class="row equal">
                        @foreach($relatedprojects as $project)
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1"><a href="{{route('front.project.show', $project->slug)}}" title="{{$project->project_title}}">{{$project->project_title}}</a></p>
                                {{strip_tags($project->project_description)}}
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