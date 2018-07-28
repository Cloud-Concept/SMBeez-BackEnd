@extends('layouts.inner')

@section('content')
<nav class="dashboard-nav navbar navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i></button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent2">
        @include ('layouts.dashboard-menu')
    </div>
</nav>
<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar-dashboard mb-3">
                        @if($hascompany)
                            <div class="dashbord-quickbtn dashbord-quickbtn-single"><button class="btn-dash btn-blue btn-yellow" data-toggle="modal" data-target="#add-project">{{__('general.publish_project')}}</button> <!-- <span class="inf">(900 <i>Honeycombs</i>)</span> --></div>
                        @endif
                    </div>
                    <div class="sidebar-dashboard mb-5">
                        <ul class="dash-info">
                            <!-- <li>
                                <i class="fa fa-cubes fa-2x pull-left mr-3" aria-hidden="true"></i>
                                <div class="pull-right">
                                    <p class="numb">{{$user->honeycombs ? $user->honeycombs : 0}}</p>
                                    <p><i><b>Honeycombs</b></i> Earned</p>
                                    <a href="">My Achievements</a>
                                </div>
                            </li> -->
                            <li>
                                <i class="fa fa-pie-chart fa-2x pull-left mr-3" aria-hidden="true"></i>
                                <div class="pull-right">
                                    <p class="numb">87%</p>
                                    <p><i><b>Profile</b></i> Completion</p>
                                    <a href="{{route('front.user.editprofile', $user->username)}}">Edit Profile</a>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-folder-open-o fa-2x pull-left mr-3" aria-hidden="true"></i>
                                <div class="pull-right">
                                    <p class="numb">{{count($user->projects)}}</p>
                                    <p>Published <i><b>Projects</b></i></p>
                                    <a href="{{route('front.user.myprojects', $user->username)}}">My Projects</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <h3><i class="fa fa-thumb-tack fa-rotate-45" aria-hidden="true"></i> Tips</h3>
                        <p>s conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div> -->
                    <div class="sidebar-updates mt-5">
                        <h5 class="title-blue">Updates ({{$user->messages->count()}})</h5>
                        <ul class="list-group">
                            @if($user->messages->count() > 0)
                                @foreach($user_messages as $message)
                                    <li class="list-group-item">
                                        @if($message->interest_id)
                                            @if($message->message_company_exists($message->sender_id))
                                            <a href="{{route('front.messages.show', $message->id)}}">
                                                {{$message->created_at->diffForHumans()}} :
                                                {{strip_tags($message->subject, '')}}
                                            </a>
                                            @else
                                            <p>Sender doesn't exist anymore</p>
                                            @endif
                                        @else
                                            {{strip_tags($message->subject, '')}}
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">You don’t have any messages yet</li>
                            @endif                       
                            <li class="list-group-item"><a href="{{route('front.messages.index')}}">All Messages</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">My Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Opportunities Applied</li>
                        </ol>
                    </nav>
                    @if(count($user->interests) == 0)
                        <p>You have not expressed interest to any opportunity yet.</p>
                    @endif
                    @if(count($user->interests) > 0)
                    <h4>My Opportunities ({{count($user->interests)}})</h4>
                    <table class="table table-striped">
                        <thead class="thead-blue">
                            <tr>
                                <th scope="col">Opportunity name</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($user->interests) > 0)

                            @foreach($interested_projects as $project)
                            <tr>
                                <td scope="row"><a href="{{route('front.project.show', $project->slug)}}">{{$project->project_title}}</a></td>
                                @if($project->interest_status() == 1)
                                    <td>Interest Accepted
                                        <br><span><a href="{{route('front.company.show', $project->user->company->slug)}}">Contact Client</a></span>
                                    </td>
                                @elseif(is_null($project->interest_status()))
                                    <td>Waiting for Client</td>
                                @elseif($project->interest_status() == 0)
                                    <td>Interest Rejected</td>
                                @endif
                            </tr>
                            @endforeach

                            @endif
                        </tbody>
                    </table>
                    @endif
                    @if($suggested_projects->count() > 0)
                    <div class="dashboard-update mt-5">
                        <h5 class="title-blue">Suggested Opportunities</h5>
                        <ul class="list-group">
                            @foreach($suggested_projects as $project)
                            
                                
                                <li class="list-group-item">

                                    @if($hascompany && !$project->has_interest() && !$project->is_owner($user->id))
                                        <form action="{{route('express.interest')}}" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" value="{{$project->id}}" name="project_id">
                                            <button class="btn btn-sm btn-yellow-2 pull-right" type="submit" data-toggle="modal" data-target="#expressInterestModal">Express Interest</button>
                                        </form>
                                    @elseif($project->has_interest() && $hascompany && !$project->is_owner($user->id))
                                        <form action="{{route('withdraw.interest', $project->withdraw_interest())}}" method="post">
                                            {{csrf_field()}}
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" value="{{$project->id}}" name="project_id">
                                            <div class="text-center"><button class="btn btn-sm btn-yellow-2 pull-right" type="submit" data-toggle="modal" data-target="#expressInterestModal">Withdraw Interest</button></div>
                                        </form>
                                    @endif

                                    <h3><a href="{{route('front.project.show', $project->slug)}}" title="{{$project->project_title}}">{{$project->project_title}}</a></h3>
                                    <p class="date">Due Date: {{$project->close_date->toFormattedDateString()}}</p>
                                    {!! substr($project->project_description, 0, 150) !!}

                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

@if($hascompany)
    @include ('layouts.create-project-modal')
@else
    @include ('layouts.add-company-modal')
@endif

@endsection