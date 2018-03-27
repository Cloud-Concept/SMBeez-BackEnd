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
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Projects</li>
                        </ol>
                    </nav>
                    <!-- <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i>Publish New Project</a></div> -->
                    <div class="row sd-project">
                        <div class="col-md-12">
                            <form action="" class="search-company">
                                <div class="form-group">
                                    <div class="d-flex"><input type="text" class="form-control" placeholder="text here"> <button class="btn btn-blue btn-yellow text-capitalize ml-3">Find Project</button></div>
                                </div>
                            </form>
                            <div class="d-flex justify-content-between mt-4 pb-3 all-project-list">
                                <h4 class="pt-2">All Projects</h4>
                                <form class="form-inline">
                                    <label for=""><i>Filter by</i></label>
                                    <select class="custom-select mb-2 ml-2 mr-sm-2 mb-sm-0">
                                        <option selected="">All Industries</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </form>
                            </div>
                            @foreach($projects as $project)
                            <div class="project-box-side box-block my-3 {{$project->status === 'deleted' ? 'disable' : ''}}">
                                <a href="{{route('admin.project.edit', $project->slug)}}"><p class="thumb-title mt-1 mb-1">{{$project->project_title}}</p></a>
                                <p>{{strip_tags(substr($project->project_description, 0, 150))}}...</p>
                            	<p class="tags">More in: 
	                                <a href="{{route('front.industry.show', $project->industries[0]->slug)}}">{{$project->industries[0]->industry_name}}</a>
	                            </p>
                            </div>
                            @endforeach
                            
                            {{$projects->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection