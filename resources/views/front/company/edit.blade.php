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
                    <div class="sidebar-company-logo d-flex justify-content-between pb-3 mb-3"><img src="/images/media/logo.jpg" alt="" class="company-logo"> <i class="fa fa-2x fa-pencil-square-o align-self-center" aria-hidden="true"></i></div>
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
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">My Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$company->company_name}}</li>
                        </ol>
                    </nav>
                    <div class="dashboard-company-block">
                        <div class="d-flex justify-content-between">
                            <div><a href="" class="edit-thumb"><i class="fa fa-pencil-square-o align-self-center" aria-hidden="true"></i></a></div>
                            <div class="media-body px-3">
                                <h5 class="mt-1 mb-2">{{$company->company_name}}</h5>
                                <p class="tags"><b>Industry</b>:<a href="{{route('front.industry.show', $company->industry->slug)}}">{{$company->industry->industry_name}}</a></p>
                                <p class="tags"><b>Specialities:</b> <span>
                                    @foreach($company->specialities as $speciality)
                                        {{$speciality->speciality_name}},
                                    @endforeach
                                </span></p>
                            </div>
                            <div><a href="{{route('front.company.show', $company->slug)}}" class="btn btn-sm btn-blue btn-yellow">Preview</a></div>
                        </div>
                        <br>
                        <textarea name="company_description" id="company_description">{{$company->company_description}}</textarea>
                        <br>
                        <button type="submit" class="btn btn-sm btn-yellow-2">Save</button>
                    </div>
                    <div class="dashboard-company-block my-3">
                        <table class="table table-striped">
                            <thead class="thead-blue">
                                <tr>
                                    <th scope="col">Basic information</th>
                                    <th scope="col" class="text-right"><a href="">Edit my Details</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row"><b>Company name</b></td>
                                    <td><input class="form-control" type="text" name="company_name" value="{{$company->company_name}}" id="company_name"></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>Company Tag Line</b></td>
                                    <td><input class="form-control" type="text" name="company_tagline" value="{{$company->company_tagline}}" id="company_tagline"></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>Website</b></td>
                                    <td><input class="form-control" type="url" name="company_website" value="{{$company->company_website}}" id="company_website"></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>Email</b></td>
                                    <td><input class="form-control" type="email" name="company_email" value="{{$company->company_email}}" id="company_email"></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>Phone</b></td>
                                    <td><input class="form-control" type="number" name="company_phone" value="{{$company->company_phone}}" id="company_phone"></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>LinkedIn Profile</b></td>
                                    <td><input class="form-control" type="url" name="linkedin_url" value="{{$company->linkedin_url}}" id="linkedin_url"></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>City</b></td>
                                    <td><input class="form-control" type="text" name="city" value="{{$company->city}}" id="city"></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>Company Size</b></td>
                                    <td><select class="form-control" name="company_size" id="company_size">
                                        <option value="1-10">1-10</option>
                                        <option value="10-20">11-20</option>
                                    </select></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>Year Founded</b></td>
                                    <td><input class="form-control" type="text" name="year_founded" value="{{$company->year_founded}}" id="year_founded"></td>
                                </tr>
                                <tr>
                                    <td scope="row"><b>Company Type</b></td>
                                    <td><select class="form-control" name="company_type" id="company_type">
                                        <option value="llc">LLC</option>
                                        <option value="inc">Inc.</option>
                                    </select></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="dashboard-company-block">
                        <div class="registration-details">
                            <h5 class="title-blue">Registration details <a href="">Edit</a></h5>
                            <div class="p-3">
                                <p>Registration Number : <input class="form-control" type="text" name="reg_number" value="{{$company->reg_number}}" id="reg_number"></p>
                                <br>
                                <p>Date of Registration : <input class="form-control" type="date" name="reg_date" value="{{$company->reg_date}}" id="reg_date"></p>
                                <a href="" class="btn btn-sm btn-yellow-2 mt-3">Upload Document</a>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-sm btn-yellow-2">Save</button>
                </div>
                <div class="col-md-3">
                    <div class="sidebar-company-logo d-flex justify-content-between pb-1 mb-3">
                        <h4>Location</h4>
                        <i class="fa fa-2x fa-pencil-square-o align-self-center" aria-hidden="true"></i>
                    </div>
                    <div class="sidebar-review-rating mt-4">
                        <div class="rating-sidebar-block">
                            <h5 class="mb-3">My reviews</h5>
                            <div class="star-rating mb-3">
                                <ul class="list-inline">
                                    <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                    <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                    <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                    <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                    <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                </ul>
                                <a href="">(239) Reviews from customers</a>
                            </div>
                            <div class="star-rating">
                                <ul class="list-inline">
                                    <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                    <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                    <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                    <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                    <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                </ul>
                                <a href="">(12) Reviews from suppliers</a>
                            </div>
                        </div>
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
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">

jQuery(document).ready(function () {
    tinymce.init({
        selector: '#company_description',
        plugins: [
          'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
          'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
          'save table contextmenu directionality emoticons template paste textcolor'
        ],
        height: 300,
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview media fullpage | forecolor backcolor emoticons'
    });
});
</script>
@endsection