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
                            <li class="breadcrumb-item active" aria-current="page">Edit Project "{{$project->project_title}}"</li>
                        </ol>
                    </nav>
                    <div class="alert alert-info">
                        Project Owner Company: <a href="{{route('front.company.show', $project->user->company->slug)}}">{{$project->user->company->company_name}}</a> | <a href="{{route('admin.company.edit', $project->user->company->slug)}}">Edit Company</a>
                        <br>
                        Project Owner User: <a href="{{route('admin.user.edit', $project->user->username)}}">{{$project->user->first_name}} {{$project->user->last_name}}</a>
                        @if($last_login)
                        <br>Last Login: {{$last_login->created_at->diffForHumans()}}
                        @endif
                        <br>Project Views: {{$views}}
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($project->is_promoted == 1)
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); document.getElementById('unpromote').submit();"><i class="fa fa-bullhorn fa-3x" aria-hidden="true"></i> Un-Promote</a></div>
                    @else
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); document.getElementById('promote').submit();"><i class="fa fa-bullhorn fa-3x" aria-hidden="true"></i> Promote</a></div>
                    @endif

                    <form id="promote" action="{{route('admin.project.promote', $project->slug)}}" method="post">
                        {{csrf_field()}}                        
                    </form>

                    <form id="unpromote" action="{{route('admin.project.unpromote', $project->slug)}}" method="post">
                        {{csrf_field()}}                        
                    </form>

                    <form class="user-setting" action="{{route('admin.project.update', $project->slug)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <p class="form-group">
                                <label for="">Project Title</label>
                                <input class="form-control" type="text" value="{{$project->project_title}}" name="project_title" placeholder="Project Title" id="project_title" required>
                            </p>
                            <label for="">Project Description</label>
                            <textarea name="project_description" id="project_description" class="form-control" required>{{$project->project_description}}</textarea>
                            <p class="form-group">
                                <label for="">Budget</label>
                                <input class="form-control" type="number" value="{{$project->budget}}" name="budget" placeholder="Estimated Budget" id="budget" required>
                            </p>
                            <p class="form-group">
                                <label for="">Industry *</label>
                                <select name="industry_id" class="form-control" id="industry_id" required>
                                    @foreach($industries as $industry)
                                    @if(app()->getLocale() == 'ar')
                                    <option value="{{$industry->id}}" {{$project->industries[0]->id == $industry->id ? 'selected' : '' }}>{{$industry->industry_name_ar}}</option>
                                    @else
                                    <option value="{{$industry->id}}" {{$project->industries[0]->id == $industry->id ? 'selected' : '' }}>{{$industry->industry_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </p>
                            <p class="form-group">
                                <input type="text" name="speciality_id" placeholder="Specialities" class="typeahead tm-input form-control tm-input-info"/>
                            </p>
                            <p class="form-group">
                                <label for="supportive_docs">Supportive Document</label>
                                <label class="custom-file">
                                    <input type="file" id="supportive_docs" name="supportive_docs" class="custom-file-input" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf, .zip, .rar, .jpg, .jpeg, .png, .gif"> 
                                    <span class="custom-file-control" data-label="Supportive Document"></span>
                                </label>
                            </p>
                            @if($project->supportive_docs)
                                <a href="{{asset('projects/files/' . $project->supportive_docs)}}"><i class="fa fa-download" aria-hidden="true"></i> Download Project Documents</a> 
                            @endif
                            <br>
                            <br>
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript">
var tagApi = $(".tm-input").tagsManager({
    prefilled: ["{!!$project_specialities!!}"]
});

jQuery(".typeahead").typeahead({
  name: 'speciality_id',
  displayKey: 'speciality_name',
  source: function (query, process) {
    return $.get('{!!url("/")!!}' + '/api/find', { keyword: query }, function (data) {
      data = $.parseJSON(data);
      return process(data);
    });
  },
  afterSelect :function (item){
    tagApi.tagsManager("pushTag", item);
  }
});
</script>

@endsection
