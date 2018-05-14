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
                        @if(\Laratrust::hasRole('company|superadmin'))
                            <div class="dashbord-quickbtn dashbord-quickbtn-single"><button class="btn-dash btn-blue btn-yellow" data-toggle="modal" data-target="#add-project">Publish New Project</button> <!-- <span class="inf">(900 <i>Honeycombs</i>)</span> --></div>
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
                            <li class="breadcrumb-item active" aria-current="page">Published Projects</li>
                        </ol>
                    </nav>

                    @if($user->projects->count() == 0)
                        <p>You don't have any projects yet.</p>
                    @endif

                    @if(count($user->projects) > 0 && \Laratrust::hasRole('company|superadmin'))
                    <h4>Published projects ({{count($user->projects)}})</h4>
                    <table class="table table-striped">
                        <thead class="thead-blue">
                            <tr>
                                <th scope="col">Project name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Suppliers</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->projects as $project)
                            <tr>
                                <td scope="row"><a href="{{route('front.project.show', $project->slug)}}">{{$project->project_title}}</a>
                                    @if($project->status != 'closed' && $project->status != 'deleted')
                                        <div class="btn-list my-1"><a href="{{route('front.project.edit', $project->slug)}}" class="btn-blank">Edit Details</a></div>
                                    @endif
                                </td>
                                @if($project->status == 'draft')

                                    <td>Draft</td>

                                @elseif($project->status == 'closed' && $project->status_on_close == 'expired')

                                    <td>Expired on {{$project->close_date->toFormattedDateString()}}</td>

                                @elseif($project->status == 'closed' && $project->status_on_close == 'by_owner')

                                    <td>Closed</td>

                                @elseif($project->status == 'publish')

                                    <td>Open until {{$project->close_date->toFormattedDateString()}}</td>
                                @elseif($project->status == 'deleted')
                                    <td>Deleted</td> 
                                @endif
                                <td><a href="#" data-toggle="modal" data-target="#expressInterestModal-{{$project->id}}">{{count($project->interests) > 0 ? count($project->interests) . ' Suppliers' : 'NA'}}</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

@if($hascompany)
    @include ('layouts.create-project-modal')
    @include ('layouts.interests-modal')
@else
    @include ('layouts.add-company-modal')
@endif

@endsection