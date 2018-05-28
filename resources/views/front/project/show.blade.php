@extends('layouts.inner')

@section('content')
@section('title')
    {{$project->project_title}}
@endsection
@section('description')
    {{strip_tags(substr($project->project_description, 0, 250))}}
@endsection

<main class="cd-main-content">
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab221b2378ad19d"></script>
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <!-- <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <h3><i class="fa fa-thumb-tack fa-rotate-45" aria-hidden="true"></i> Tips</h3>
                        <p>always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the host to your journey</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div> -->
                    <div class="box-block-gray">
                        <h3>Project Details <!-- <a href="#" class="btn-more pull-right"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a> --></h3>
                        <ul class="list-unstyled details-box">
                            @if(!Auth::guest() && !$project->is_owner(Auth::user()->id) || Auth::guest())

                                @if($project->has_interest() && $project->interest_status() == 1)
                                    <li>Client: <span><a href="{{route('front.company.show', $project->user->company->slug)}}">{{$project->user->company->company_name}}</a></span></li>
                                @else
                                <li>Client: <i class="fa fa-lock" aria-hidden="true"></i> <span> Locked</span></li>
                                @endif

                                @if($project->user->company->reviews->count() > 0)
                                <li>
                                    <div class="pull-left">Client Overall Rating:</div>
                                    <div class="star-rating pull-left">
                                        <ul class="list-inline">                                            
                                            <li class="list-inline-item">
                                                <select class="star-rating-ro">
                                                    @for($i = 0; $i <= 5; $i++)
                                                    <option value="{{$i}}" {{$i == $project->user->company->company_overall_rating($project->user->company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                @endif
                            @endif
                            <li>Budget: <span>{{$project->budget}} AED</span></li>
                            <li>Industry: <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a></li>
                            @if($project->specialities->count() > 0)
                            <li>Speciality: <span>
                                @foreach($project->specialities as $speciality)
                                    {{ $loop->first ? '' : ', ' }}
                                    {{$speciality->speciality_name}} 
                                @endforeach
                            </span></li>
                            @endif
                            <li>Status: 

                                @if($project->status == 'draft')

                                    <span>Draft</span>

                                @elseif($project->status == 'closed' && $project->status_on_close == 'expired')

                                    <span>Expired on {{$project->close_date->toFormattedDateString()}}</span>

                                @elseif($project->status == 'closed' && $project->status_on_close == 'by_owner')

                                    <span>Closed</span>

                                @elseif($project->status == 'publish')

                                    <span>Open until {{$project->close_date->toFormattedDateString()}}</span>
                                @elseif($project->status == 'deleted')
                                    <span>Deleted</span> 
                                @endif

                            </li>
                        </ul>
                        @if($hasCompany && !$project->has_interest() && !$project->is_owner(Auth::user()->id))
                        <form action="{{route('express.interest')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <div class="text-center"><button type="submit" class="btn btn-blue btn-yellow">Express Interest</button></div>
                        </form>
                        @elseif($project->has_interest() && $hasCompany && !$project->is_owner(Auth::user()->id))
                        <form action="{{route('withdraw.interest', $project->withdraw_interest())}}" method="post">
                            {{csrf_field()}}
                            {{ method_field('DELETE') }}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <div class="text-center"><button type="submit" class="btn btn-blue btn-yellow">Withdraw Interest</button></div>
                        </form>
                        @elseif(!Auth::guest() && $project->is_owner(Auth::user()->id) && $project->status === 'publish')
                        <form action="{{route('front.project.close', $project->slug)}}" method="post">
                            {{csrf_field()}}
                            <div class="text-center"><button type="submit" class="btn btn-blue btn-yellow">Close Project</button></div>
                        </form>
                        <br>
                        <div class="text-center"><a href="{{route('front.project.edit', $project->slug)}}" class="btn btn-blue btn-yellow">Edit Project</a></div>
                        @elseif(!Auth::guest() && $project->is_owner(Auth::user()->id) && $project->status === 'draft')
                        <form action="{{route('front.project.publish', $project->slug)}}" method="post">
                            {{csrf_field()}}
                            <div class="text-center"><button type="submit" class="btn btn-blue btn-yellow">Publish Project</button></div>
                        </form>
                        <br>
                        <div class="text-center"><a href="{{route('front.project.edit', $project->slug)}}" class="btn btn-blue btn-yellow">Edit Project</a></div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$project->project_title}}</li>
                        </ol>
                    </nav>
                    <h2 class="mb-3 mt-3">{{$project->project_title}} 
                        @if(!Auth::guest() && !$project->is_owner(Auth::user()->id))
                            @if(!$project->bookmarked($project->id))
                                <a href="#" id="bookmark-b-{{$project->id}}" class="pull-right" onclick="event.preventDefault();"><i class="fa fa-bookmark-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Add to your Favorites"></i></a>
                                <a href="#" id="unbookmark-b-{{$project->id}}" class="pull-right" style="display:none;" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                            @else
                                <a href="#" id="unbookmark-b-{{$project->id}}" class="pull-right" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                                <a href="#" id="bookmark-b-{{$project->id}}" class="pull-right" style="display:none;" onclick="event.preventDefault();"><i class="fa fa-bookmark-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Add to your Favorites"></i></a>
                            @endif
                        @endif
                    </h2>
                    @if(!Auth::guest() && !$project->is_owner(Auth::user()->id))
                        <form id="bookmark-{{$project->id}}" action="#">
                            <input id="token-bookmark-{{$project->id}}" value="{{csrf_token()}}" type="hidden">
                            <input type="hidden" id="bookmarked_id-{{$project->id}}" name="bookmarked_id" value="{{$project->id}}"/>
                            <input type="hidden" id="bookmark_type-{{$project->id}}" name="bookmark_type" value="App\Project"/>
                        </form>
                        <form id="unbookmark-{{$project->id}}" action="#">
                            <input id="token-unbookmark-{{$project->id}}" value="{{csrf_token()}}" type="hidden">
                            <input type="hidden" id="bookmarked_id-{{$project->id}}" name="bookmarked_id" value="{{$project->id}}"/>
                            <input type="hidden" id="bookmark_type-{{$project->id}}" name="bookmark_type" value="App\Project"/>
                        </form>
                        <script>
                            $(document).ready(function(){
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                var new_bookmarkid = '{{$project->bookmark($project->id)}}';
                                //bookmark company
                                $('#bookmark-b-{{$project->id}}').on('click', function(e){
                                    e.preventDefault();
                                    var token = $('#token-bookmark-{{$project->id}}').val();
                                    var bookmark_type = $('#bookmark_type-{{$project->id}}').val();
                                    var bookmark_id = $('#bookmarked_id-{{$project->id}}').val();
                                    $.ajax({
                                        type: "POST",
                                        data: "bookmarked_id=" + bookmark_id + "&bookmark_type=" + bookmark_type + "&_token=" + token,
                                        dataType: 'json',
                                        url: "{{route('bookmark.add')}}",
                                        success: function(data) {
                                            $('#unbookmark-b-{{$project->id}}').show();
                                            $('#bookmark-b-{{$project->id}}').hide();
                                            new_bookmarkid = data.id;
                                        }
                                    });
                                });
                                
                                $('#unbookmark-b-{{$project->id}}').on('click', function(e){
                                    e.preventDefault();
                                    var token = $('#token-unbookmark-{{$project->id}}').val();
                                    var url = '{{ route("bookmark.remove", ":new_bookmarkid") }}';
                                    $.ajax({
                                        type: "POST",
                                        data: "_token=" + token,
                                        url: url.replace(':new_bookmarkid', new_bookmarkid),
                                        success: function(data) {
                                            $('#unbookmark-b-{{$project->id}}').hide();
                                                $('#bookmark-b-{{$project->id}}').show();
                                        }
                                    });
                                });
                            });
                        </script>
                        <style>
                            .hidden {
                                display: none!important;
                            }
                        </style>
                    @endif
                    <p>
                        {!!str_replace("\n","<p>",$project->project_description)!!}
                    </p>
                    @if($project->files->count() > 0)
                    <div class="download-box d-flex justify-content-between align-items-center">
                        <div>
                        @foreach($project->files as $file)
                            @if(file_exists(public_path('/projects/files/'. $file->file_path)))
                                <p class="list-item more-inf"><a href="{{asset('projects/files/'. $file->file_path)}}" target="_blank"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Download File"></i> {{$file->file_name}}</a></p>
                            @endif
                        @endforeach
                        </div>
                        @if($hasCompany && !$project->has_interest() && !$project->is_owner(Auth::user()->id))
                        <form action="{{route('express.interest')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <button type="submit" class="btn btn-blue btn-yellow">Express Interest</button>
                        </form>
                        @elseif($project->has_interest() && $hasCompany && !$project->is_owner(Auth::user()->id))
                        <form action="{{route('withdraw.interest', $project->withdraw_interest())}}" method="post">
                            {{csrf_field()}}
                            {{ method_field('DELETE') }}
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <button type="submit" class="btn btn-blue btn-yellow">Withdraw Interest</button>
                        </form>
                        @endif
                    </div>
                    @endif

                    @if($relatedprojects->count() > 0)
                    <h2 class="mb-4 mt-5">Similar Opportunities</h2>
                    <div class="row equal">
                        @foreach($relatedprojects as $project)
                        <div class="col-md-6">
                            <div class="project-box box-block mb-3">
                                <p class="thumb-title mt-1 mb-1"><a href="{{route('front.project.show', $project->slug)}}" title="{{$project->project_title}}">{{$project->project_title}}</a></p>
                                {{strip_tags(substr($project->project_description, 0, 100))}}...
                                <p class="tags">More in: 
                                    <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection