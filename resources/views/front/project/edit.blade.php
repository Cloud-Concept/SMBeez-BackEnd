@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <form action="{{route('front.project.update', $project->slug)}}" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        {{ csrf_field() }}
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
                            <h3>Project Details <!-- <a href="" class="btn-more pull-right"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a> --></h3>
                            <ul class="list-unstyled details-box">
                                <li>Budget (EGP): <input class="form-control" type="number" min="1" value="{{$project->budget}}" name="budget" placeholder="Budget in EGP" id="budget" required></li>
                                <li>Industry: 
                                    <select name="industry_id" class="form-control custom-select d-block" id="industry_id" required>
                                        @foreach($industries as $industry)
                                        <option value="{{$industry->id}}" {{$project->industries[0]->id == $industry->id ? 'selected' : '' }}>{{$industry->industry_name}}</option>
                                        @endforeach
                                    </select>
                                </li>
                                <li>Speciality: <input type="text" name="speciality_id" placeholder="Specialities" class="typeahead tm-input form-control tm-input-info"/></li>
                            </ul>
                            <div class="text-center"><button type="submit" class="btn btn-blue btn-yellow">Update Project</button></div>
                            @if($project->status === 'draft')
                            <br>
                            <div class="text-center"><a href="#" onclick="event.preventDefault(); document.getElementById('publish-project').submit();" class="btn btn-blue btn-yellow">Publish Project</a></div>
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
                        <div class="compnay-edit">
                            <div class="form-group">
                                <h4>Project Title:</h4>
                                <h2 class="mb-3 mt-3"><input class="form-control" type="text" value="{{$project->project_title}}" name="project_title" placeholder="Project Title" id="project_title"></h2>
                            </div>
                            <div class="form-group">
                                <h4>Project Description:</h4>
                                <textarea name="project_description" class="form-control" id="project_description" required>{!! strip_tags($project->project_description) !!}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="download-box d-flex justify-content-between align-items-center">
                            
                            @if($project->files->count() > 0)
                                <div>
                                @foreach($project->files as $file)
                                    @if(file_exists(public_path('/projects/files/'. $file->file_path)))
                                        <p class="list-item more-inf"><a href="#" onclick="event.preventDefault(); document.getElementById('delete-file-{{$file->id}}').submit();"><i class="fa fa-times" aria-hidden="true" style="color:red;" data-toggle="tooltip" data-placement="bottom" title="Delete File"></i></a><a href="{{asset('projects/files/'. $file->file_path)}}" target="_blank"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Download File"></i> {{$file->file_name}}</a></p>
                                    @else
                                        <p class="list-item more-inf"><a href="#" onclick="event.preventDefault(); document.getElementById('delete-file-{{$file->id}}').submit();"><i class="fa fa-times" aria-hidden="true" style="color:red;" data-toggle="tooltip" data-placement="bottom" title="Delete File"></i></a><a href="{{asset('projects/files/'. $file->file_path)}}" target="_blank"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Download File"></i> <strike>{{$file->file_name}}</strike> <i>(File Damaged Re-upload)</i></a></p>  
                                    @endif
                                @endforeach
                                </div>
                            @endif 
                            <input type="hidden" value="{{$project->id}}" name="project_id">
                            <div class="form-group">
                                <label class="custom-file">
                                    <input type="file" id="supportive_docs" name="supportive_docs[]" class="custom-file-input" accept=".jpg, .jpeg, .png, .doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf, .zip, .rar" multiple> 
                                    <span class="custom-file-control" data-label="Upload Project Documents"></span>
                                </label>
                                <br>
                                <span class="form-guide">You can upload more than one file by choosing multiple files during browse.</span>
                            </div>
                        </div>
                        <br>
                        <div class="text-center"><button type="submit" class="btn btn-blue btn-yellow">Update Project</button></div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    @foreach($project->files as $file)
    <form id="delete-file-{{$file->id}}" action="{{route('front.file.delete', $file->id)}}" method="post">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}                        
    </form>
    @endforeach

    @if($project->status === 'draft')
    <form id="publish-project" action="{{route('front.project.publish', $project->slug)}}" method="post">
        {{csrf_field()}}
    </form>
    @endif
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