@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Project</div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{route('front.project.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="group-control">
                                <input class="form-control" type="text" name="project_title" placeholder="Project Title" id="project_title">
                            </p>
                            <textarea name="project_description" id="project_description"></textarea>
                            <p class="group-control">
                                <input class="form-control" type="number" name="budget" placeholder="Estimated Budget" id="budget">
                            </p>
                            <p class="group-control">
                                <input class="form-control" type="hidden" name="status" value="publish" id="status">
                            </p>
                            <p class="group-control">
                                <select name="industry_id" id="industry_id">
                                    @foreach($industries as $industry)
                                    @if(app()->getLocale() == 'ar')
                                    <option value="{{$industry->id}}">{{$industry->industry_name_ar}}</option>
                                    @else
                                    <option value="{{$industry->id}}">{{$industry->industry_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </p>
                            <p class="group-control">
                                <select name="speciality_id[]" id="speciality_id" class="multi-select" multiple>
                                    @foreach($specialities as $speciality)
                                    <option value="{{$speciality->id}}">{{$speciality->speciality_name}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p class="group-control">
                                <label for="supportive_docs">Supportive Document</label>
                                <input class="form-control" type="file" name="supportive_docs" id="supportive_docs" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf">
                                Accepts Excel, Word, PowerPoint, Text, PDF
                            </p>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
