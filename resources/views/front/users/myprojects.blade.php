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
                            <div class="dashbord-quickbtn dashbord-quickbtn-single"><a href="{{route('front.project.create')}}"><button class="btn-dash btn-blue btn-yellow">Publish New Project</button></a> <span class="inf">(900 <i>Honeycombs</i>)</span></div>
                        @endif
                    </div>
                    <div class="sidebar-dashboard mb-5">
                        <ul class="dash-info">
                            <li>
                                <i class="fa fa-cubes fa-2x pull-left mr-3" aria-hidden="true"></i>
                                <div class="pull-right">
                                    <p class="numb">{{$user->honeycombs ? $user->honeycombs : 0}}</p>
                                    <p><i><b>Honeycombs</b></i> Earned</p>
                                    <a href="">My Achievements</a>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-pie-chart fa-2x pull-left mr-3" aria-hidden="true"></i>
                                <div class="pull-right">
                                    <p class="numb">87%</p>
                                    <p><i><b>Profile</b></i> Completion</p>
                                    <a href="">Edit Profile</a>
                                </div>
                            </li>
                            <li>
                                <i class="fa fa-folder-open-o fa-2x pull-left mr-3" aria-hidden="true"></i>
                                <div class="pull-right">
                                    <p class="numb">{{count($user->projects)}}</p>
                                    <p>Published <i><b>Projects</b></i></p>
                                    <a href="">My Projects</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <h3><i class="fa fa-thumb-tack fa-rotate-45" aria-hidden="true"></i> Tips</h3>
                        <p>s conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="sidebar-updates mt-5">
                        <h5 class="title-blue">Updates (32)</h5>
                        <ul class="list-group">
                            <li class="list-group-item">As conscious traveling Paupers we must always be concerned</li>
                            <li class="list-group-item">As conscious traveling Paupers we must always be concerned</li>
                            <li class="list-group-item">As conscious traveling Paupers we must always be concerned</li>
                            <li class="list-group-item">As conscious traveling Paupers we must always be concerned</li>
                            <li class="list-group-item">As conscious traveling Paupers we must always be concerned</li>
                            <li class="list-group-item"><a href="">All Messages</a></li>
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
                    <h4>Published projects ({{count($user->projects)}}) <a href="" class="pull-right">Show expired</a></h4>
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
                                        <div class="btn-list my-1"><a href="" class="btn-blank">Edit Details</a> <a href="" class="btn-blank">Upload Documents</a></div>
                                    @endif
                                </td>
                                @if($project->status == 'draft')

                                    <td>Draft</td>

                                @elseif($project->status == 'closed' && $project->status_on_close == 'expired')

                                    <td>Expired on {{$project->close_date->toFormattedDateString()}}</td>

                                @elseif($project->status == 'closed' && $project->status_on_close == 'awarded')

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
                    <div class="dashboard-update mt-5">
                        <h5 class="title-blue">Suggested Projects</h5>
                        <ul class="list-group">
                            @foreach($suggested_projects as $project)
                            
                                
                                <li class="list-group-item">

                                    @if(\Laratrust::hasRole('company|superadmin') && !$project->has_interest() && !$project->is_owner($user->id))
                                        <form action="{{route('express.interest')}}" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" value="{{$project->id}}" name="project_id">
                                            <button class="btn btn-sm btn-yellow-2 pull-right" type="submit">Express Interest</button>
                                        </form>
                                    @elseif($project->has_interest() && \Laratrust::hasRole('company|superadmin') && !$project->is_owner($user->id))
                                        <form action="{{route('withdraw.interest', $project->withdraw_interest())}}" method="post">
                                            {{csrf_field()}}
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" value="{{$project->id}}" name="project_id">
                                            <div class="text-center"><button class="btn btn-sm btn-yellow-2 pull-right" type="submit">Withdraw Interest</button></div>
                                        </form>
                                    @endif

                                    <h3><a href="{{route('front.project.show', $project->slug)}}" title="{{$project->project_title}}">{{$project->project_title}}</a></h3>
                                    <p class="date">Due Date: {{$project->close_date->toFormattedDateString()}}</p>
                                    {!! $project->project_description !!}

                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include ('layouts.interests-modal')

@endsection