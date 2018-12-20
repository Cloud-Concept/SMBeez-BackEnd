@extends('layouts.admin')

@section('content')
<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.superadmin-sidebar')
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit User {{$user->first_name . " " . $user->last_name}}</li>
                        </ol>
                    </nav>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); var r = confirm('Are you sure you want to re-send credentials to this user ?'); if (r == true) {document.getElementById('creds-form-{{$user->id}}').submit();}">Resend Credentials</a></div>
                    <div class="alert alert-info">
                        @if($user->company)
                            Own Company: <a href="{{route('front.company.show', $user->company->slug)}}">{{$user->company->company_name}}</a> | <a href="{{route('admin.company.edit', $user->company->slug)}}">Edit Company</a>
                        @else
                            This user don't own a company yet.
                        @endif
                        @if($user->logins)
                            <br>Total Logins: <a href="{{route('admin.user.user-logins', $user->username)}}">{{$user->logins->count()}}</a>
                            @if($last_login)
                            <br>Last Login: {{$last_login->created_at->diffForHumans()}}
                            @endif
                        @endif
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.user.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add New User</a></div>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); var r = confirm('Are you sure you want to delete this user ?'); if (r == true) {document.getElementById('delete-form-{{$user->id}}').submit();}"><i class="fa fa-minus-circle fa-3x" aria-hidden="true"></i> Delete This User</a></div>
                    <br>
                    @if($user->profile_pic_url && file_exists(public_path('/') . $user->profile_pic_url))
                        <img src="{{asset($user->profile_pic_url)}}" />
                        <br>
                    @endif
                    <br>
                    <p>This user have {{$user->honeycombs ? $user->honeycombs : 0}} Honycombs points</p>
                    <br>
                    <form action="{{route('admin.user.update', $user->username)}}" class="user-setting" role="form" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="form-group">
                                <input class="form-control" type="text" name="first_name" placeholder="First Name" id="fname" value="{{$user->first_name}}" required/>
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="text" name="last_name" placeholder="Last Name" id="lname" value="{{$user->last_name}}" required/>
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="email" id="email" value="{{$user->email}}" />
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="password" id="password" />
                            </p>
                            <p class="form-group">
                                <input class="form-control" type="text" name="phone" placeholder="phone" id="phone" value="{{$user->phone}}" />
                            </p>
                            <p class="form-group">
                                <label class="custom-file">
                                    <input type="file" id="profile_pic_url" name="profile_pic_url" class="form-control custom-file-input" accept=".jpg, .png, .jpeg"> 
                                    <span class="custom-file-control" data-label="Profile Picture"></span>
                                </label>
                            </p>
                            <p class="form-group">
                                <select name="role" class="form-control custom-select d-block">
                                    @foreach ($roles as $role)
                                        @foreach ($user->roles as $user_role)
                                            <option value="{{$role->id}}" {{$user_role->id == $role->id ? 'selected' : ''}}>{{$role->display_name}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Submit" />
                        </div>
                        
                    </form>
                    <form id="delete-form-{{$user->id}}" action="{{route('admin.user.delete', $user->username)}}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                    <form id="creds-form-{{$user->id}}" action="{{route('admin.user.creds', $user->username)}}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
            <div class="row">
                @if(count($user->projects) > 0)
                <h4>{{__('general.published_project')}} ({{count($user->projects)}})</h4>
                <table class="table table-striped">
                    <thead class="thead-blue">
                        <tr>
                            <th scope="col">{{__('general.project_name')}}</th>
                            <th scope="col">{{__('general.status')}}</th>
                            <th scope="col">{{__('general.suppliers')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->projects as $project)
                        <tr>
                            <td scope="row"><a href="{{route('front.project.show', $project->slug)}}">{{$project->project_title}}</a>
                                @if($project->status != 'closed' && $project->status != 'deleted')
                                    <div class="btn-list my-1"><a href="{{route('admin.project.edit', $project->slug)}}" class="btn-blank">{{__('project.edit_project')}}</a></div>
                                @endif
                            </td>
                            @if($project->status == 'draft')

                                <td>{{__('project.draft')}}</td>

                            @elseif($project->status == 'closed' && $project->status_on_close == 'expired')

                                <td>{{__('project.expired_on')}} {{$project->close_date->toFormattedDateString()}}</td>

                            @elseif($project->status == 'closed' && $project->status_on_close == 'by_owner')

                                <td>{{__('project.closed')}}</td>

                            @elseif($project->status == 'publish')

                                <td>{{__('project.open_until')}} {{$project->close_date->toFormattedDateString()}}</td>
                            @elseif($project->status == 'deleted')
                                <td>{{__('project.deleted')}}</td>
                            @else
                                <td></td> 
                            @endif
                            <td>{{count($project->interests) > 0 ? count($project->interests) . ' ' .__("general.suppliers") : 'NA'}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <hr>
            <br>
            <div class="row">
                @if(count($user->interests) > 0)
                <h4>{{__('general.my_opportunities')}} ({{count($user->interests)}})</h4>
                <table class="table table-striped">
                    <thead class="thead-blue">
                        <tr>
                            <th scope="col">{{__('general.opportunity_name')}}</th>
                            <th scope="col">{{__('general.status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($user->interests) > 0)

                        @foreach($interested_projects as $project)
                        <tr>
                            <td scope="row"><a href="{{route('admin.project.edit', $project->slug)}}">{{$project->project_title}}</a></td>
                            @if($project->admin_interest_status($user->id) == 1)
                                <td>{{__('general.interest_accepted')}}
                                    <br><span><a href="{{route('admin.company.edit', $project->user->company->slug)}}">{{__('general.contact_client')}}</a></span>
                                </td>
                            @elseif(is_null($project->admin_interest_status($user->id)))
                                <td>{{__('general.waiting_for_client')}}</td>
                            @elseif($project->admin_interest_status($user->id) == 0)
                                <td>{{__('general.interest_rejected')}}</td>
                            @endif
                        </tr>
                        @endforeach

                        @endif
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
</main>
@endsection
