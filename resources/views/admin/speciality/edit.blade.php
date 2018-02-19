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
                            <li class="breadcrumb-item active" aria-current="page">Edit {{$speciality->speciality_name}} Speciality</li>
                        </ol>
                    </nav>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{route('admin.speciality.update', $speciality->slug)}}" class="user-setting" role="form" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Specialities</label>
                            <input class="typeahead tm-input form-control" type="text" name="speciality_name" value="{{$speciality->speciality_name}}" placeholder="Speciality Name" id="speciality_name">
                        </p>
                        <input type="submit" class="btn btn-primary" value="Update">
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
jQuery(".typeahead").typeahead({
  name: 'speciality_id',
  displayKey: 'speciality_name',
  source: function (query, process) {
    return $.get('{!!url("/")!!}' + '/api/find', { keyword: query }, function (data) {
      data = $.parseJSON(data);
      return process(data);
    });
  },
});
</script>
@endsection
