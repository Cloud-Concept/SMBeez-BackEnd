@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Industry</div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{route('admin.industry.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="group-control">
                                <input class="input-control" type="text" name="industry_name" placeholder="Industry Name" id="industry_name">
                            </p>
                            <p class="group-control">
                                <label for="industry_img_url">Industry Image</label>
                                <input class="input-control" type="file" name="industry_img_url" id="industry_img_url">
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
