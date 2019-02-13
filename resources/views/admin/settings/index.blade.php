@extends('layouts.admin')

@section('content')

<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @if(\Laratrust::hasRole('moderator'))
                        @include('layouts.moderator-sidebar')
                    @else
                        @include('layouts.superadmin-sidebar')
                    @endif
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Settings</li>
                        </ol>
                    </nav>
                    <h3>Add New Setting</h3>
                    <form class="user-setting" action="{{route('admin.add-setting')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="group-control">
                                <label for="setting_name">Setting Name</label>
                                <input class="form-control" type="text" name="setting_name" required>
                            </p>
                            <p class="group-control">
                                <label for="setting_slug">Setting Slug</label>
                                <input class="form-control" type="text" name="setting_slug" required>
                            </p>
                            <p class="group-control">
                                <label for="value">Value</label>
                                <input class="form-control" type="text" name="value" required>
                            </p>
                            <p class="group-control">
                                <label for="limit">Limit</label>
                                <input class="form-control" type="text" name="limit">
                            </p>
                            <p class="group-control">
                                <label for="category">Category</label>
                                Like:
                                @foreach($categories as $category)
                                {{ $loop->first ? '' : ', ' }}
                                {{$category}}
                                @endforeach
                                <input class="form-control" type="text" name="category" required>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                    <hr>
                    <h3>Edit Settings</h3>
                    @foreach($settings as $setting)
                    <form class="user-setting" action="{{route('admin.update-setting', $setting->id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="group-control">
                                <label for="{{$setting->setting_slug}}">{{$setting->setting_name}}</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="value" placeholder="{{$setting->setting_name}}" id="{{$setting->setting_name}}" value="{{$setting->value}}" required>
                                    <span class="input-group-btn">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                    </span>
                                </div><!-- /input-group -->       
                            </p>      
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
