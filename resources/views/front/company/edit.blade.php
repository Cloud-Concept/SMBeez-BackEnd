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
                    <div id="logo" class="sidebar-company-logo d-flex justify-content-between pb-3 mb-3">
                        @if($company->logo_url)
                        <img src="{{asset($company->logo_url)}}" alt="" class="company-logo">
                        @endif
                        <i class="fa fa-2x fa-pencil-square-o align-self-center" aria-hidden="true"></i>
                    </div>
                    @if($company->cover_url)
                    <div class="media">
                        <img class="img-fluid img-full" src="{{asset($company->cover_url)}}" alt="">
                    </div>
                    @endif
                    <br>
                    <form id="img_upload" action="{{route('front.company.updatelogo', $company->slug)}}" method="post" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                           <label class="custom-file">
                                <input type="file" id="logo_url" name="logo_url" class="custom-file-input" accept=".png, .jpg, .jpeg, .bmp"> 
                                <span class="custom-file-control" data-label="Upload Logo"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="custom-file">
                                <input type="file" id="cover_url" name="cover_url" class="custom-file-input" accept=".png, .jpg, .jpeg, .bmp"> 
                                <span class="custom-file-control" data-label="Upload Cover"></span>
                            </label> 
                        </div>                
                        <br>
                        <button type="submit" id="upload" class="btn btn-sm btn-yellow-2">Upload</button>
                    </form>
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
                    <form id="update-company" action="{{route('front.company.update', $company->slug)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
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
                            <textarea class="form-control" name="company_description" id="company_description">{{$company->company_description}}</textarea>
                            <br>
                            <button type="submit" class="btn btn-sm btn-yellow-2">Save</button>
                        </div>
                        <div class="dashboard-company-block my-3">    
                            <table class="table table-striped">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Basic information</th>
                                        <th scope="col" class="text-right">Edit my Details</th>
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
                                        <td><select class="form-control" name="city" id="city">
                                            <option value="Dubai">Dubai</option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>Company Size</b></td>
                                        <td><select name="company_size" id="company_size" class="form-control">
                                            <option value="0-1 Employees">0-1 Employees</option>
                                            <option value="2-10 Employees">2-10 Employees</option>
                                            <option value="11-50 Employees">11-50 Employees</option>
                                            <option value="51-200 Employees">51-200 Employees</option>
                                            <option value="201-500 Employees">201-500 Employees</option>
                                            <option value="501+ Employees">501+ Employees</option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>Year Founded</b></td>
                                        <td><input class="form-control" type="text" name="year_founded" value="{{$company->year_founded}}" id="year_founded"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>Company Type</b></td>
                                        <td><select name="company_type" id="company_type">
                                            <option value="Sole Ownership">Sole Ownership</option>
                                            <option value="Limited Liability Company (LLC)">Limited Liability Company (LLC)</option>
                                            <option value="Free Zone Sole Ownership">Free Zone Sole Ownership</option>
                                            <option value="Free Zone LLC">Free Zone LLC</option>
                                            <option value="Public Joint-Stock Company (PJSC)">Public Joint-Stock Company (PJSC)</option>
                                            <option value="Private Joint-Stock Company (PrJSC)">Private Joint-Stock Company (PrJSC)</option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>Specialities</b></td>
                                        <td><input type="text" name="speciality_id" placeholder="Specialities" class="typeahead tm-input form-control tm-input-info"/></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="dashboard-company-block">
                            <div class="registration-details">
                                <h5 class="title-blue">Registration details</h5>
                                <div class="p-3">
                                    <p>Registration Number : <input class="form-control" type="text" name="reg_number" value="{{$company->reg_number}}" id="reg_number"></p>
                                    <br>
                                    <p>Date of Registration : <input class="form-control" type="date" name="reg_date" value="{{$company->reg_date}}" id="reg_date"></p>
                                    <br>
                                    <div class="form-group">
                                        <label class="custom-file">
                                            <input type="file" id="reg_doc" name="reg_doc" class="custom-file-input" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf, .zip, .rar"> 
                                            <span class="custom-file-control" data-label="Registration Documents"></span>
                                        </label>
                                        <p class="form-guide">Accepts Excel, Word, PowerPoint, Text, PDF, ZIP, RAR</p>
                                    </div>
                                    @if($company->reg_doc)
                                        <a href="{{asset('companies/files/' . $company->reg_doc)}}"><i class="fa fa-download" aria-hidden="true"></i> Download Company Documents</a> 
                                    @endif
                                    <br>
                                    <button type="submit" class="btn btn-sm btn-yellow-2 mt-3">Upload Document</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-sm btn-yellow-2">Save</button>
                    </form>
                </div> 
                <div class="col-md-3">
                    <div class="sidebar-company-logo d-flex justify-content-between pb-1 mb-3">
                        <h4>Location</h4>
                        <i class="fa fa-2x fa-pencil-square-o align-self-center" aria-hidden="true"></i>
                    </div>
                    <form id="update-company" action="{{route('front.company.update_location', $company->slug)}}" method="post">
                        {{csrf_field()}}
                        <input class="form-control" type="text" name="location" value="{{$company->location}}" id="location" placeholder="Location">
                        <br>
                        <button type="submit" class="btn btn-sm btn-yellow-2">Save</button>
                    </form>
                    <div class="sidebar-review-rating mt-4">
                        <div class="rating-sidebar-block">
                            <h5 class="mb-3">My reviews</h5>
                            <div class="star-rating mb-3">
                                <ul class="list-inline">
                                    @if($customer_reviews->count() > 0)
                                    <li class="list-inline-item">
                                        @if($company->reviews->count() > 0)
                                        <select class="star-rating-ro">
                                            @for($i = 1; $i <= 5; $i++)
                                            <option value="{{$i}}" {{$i == $company->customer_rating($company->id, $customer_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                        @endif
                                    </li>
                                    @endif
                                </ul>
                                <a href="">({{$customer_reviews->count()}}) Reviews from customers</a>
                            </div>
                            <div class="star-rating">
                                <ul class="list-inline">
                                    @if($suppliers_reviews->count() > 0)
                                    <li class="list-inline-item">
                                        @if($company->reviews->count() > 0)
                                        <select class="star-rating-ro">
                                            @for($i = 1; $i <= 5; $i++)
                                            <option value="{{$i}}" {{$i == $company->suppliers_rating($company->id, $suppliers_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                        @endif
                                    </li>
                                    @endif
                                </ul>
                                <a href="">({{$suppliers_reviews->count()}}) Reviews from suppliers</a>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-updates mt-5">
                        <h5 class="title-blue">Updates ({{$user->messages->count()}})</h5>
                        <ul class="list-group">
                            @foreach($user->messages as $message)
                                <li class="list-group-item">
                                    @if($message->interest_id)
                                        {{$message->created_at->diffForHumans()}} :
                                        New Express Interest
                                    @else
                                        {{$message->subject}}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>  
            </div>
        </div>
    </section>
</main>

<script type="text/javascript">
/*$("#upload").click(function(e){
    e.preventDefault();
    $.ajax({
      url:'{{route("front.company.updatelogo", $company->slug)}}',
      data:new FormData($("#img_upload")[0]),
      dataType:'json',
      async:false,
      type:'post',
      processData: false,
      contentType: false,
      success:function(response){
        location.reload();
      },
    });
});*/

var tagApi = $(".tm-input").tagsManager({
    prefilled: ["{!!$company_specialities!!}"]
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