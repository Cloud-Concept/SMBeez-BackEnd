@extends('layouts.admin')

@section('content')
<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @role('superadmin')
                        @include('layouts.superadmin-sidebar')
                    @endrole
                    @role('moderator')
                        @include('layouts.moderator-sidebar')
                    @endrole
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Company {{$company->company_name}}</li>
                        </ol>
                    </nav>

                    @if($company->user)
                    <div class="alert alert-info">
                        Company Owner: <a href="{{route('admin.user.edit', $company->user->username)}}">{{$company->user->first_name}} {{$company->user->last_name}}</a>
                        @if($last_login)
                        <br>Last Login: {{$last_login->created_at->diffForHumans()}}
                        @endif
                    </div>
                    @endif
                    <div class="alert alert-info">
                        Company Activity: <a href="{{route('admin.company.activity', $company->slug)}}">Activities</a>
                        <br>
                        @if($manager)
                        Company Manager: {{$manager}}
                        @endif
                        <br>
                        @if($views)
                        Views: {{$views}}
                        @endif
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="{{route('admin.company.create')}}" class="btn btn-alert text-capitalize"><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i> Add a new Company</a></div>
                    @role('superadmin')
                    @if($company->is_promoted == 1)
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); document.getElementById('unpromote').submit();"><i class="fa fa-bullhorn fa-3x" aria-hidden="true"></i> Un-Promote</a></div>
                    @else
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); document.getElementById('promote').submit();"><i class="fa fa-bullhorn fa-3x" aria-hidden="true"></i> Promote</a></div>
                    @endif

                    @if($company->is_verified == 1)
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); document.getElementById('unverify').submit();"><i class="fa fa-times fa-3x" aria-hidden="true"></i> Un-Verify</a></div>
                    @else
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); document.getElementById('verify').submit();"><i class="fa fa-check fa-3x" aria-hidden="true"></i> Verify</a></div>
                    @endif
                    <br>
                    <form id="promote" action="{{route('admin.company.promote', $company->slug)}}" method="post">
                        {{csrf_field()}}                        
                    </form>

                    <form id="unpromote" action="{{route('admin.company.unpromote', $company->slug)}}" method="post">
                        {{csrf_field()}}                        
                    </form>

                    <form id="verify" action="{{route('admin.company.verify', $company->slug)}}" method="post">
                        {{csrf_field()}}                        
                    </form>

                    <form id="unverify" action="{{route('admin.company.unverify', $company->slug)}}" method="post">
                        {{csrf_field()}}                        
                    </form>

                    @endrole
                    <form action="{{route('admin.company.update', $company->slug)}}" class="user-setting" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="form-group">
                                <label for="">Company name *</label>
                                <input class="form-control" value="{{$company->company_name}}" type="text" name="company_name" placeholder="Company Name" id="company_name" required>
                            </p>
                            <p class="form-group">
                                <label for="">What is your company main message?</label>
                                <textarea name="company_description" class="form-control" placeholder="Company Description" id="company_description">{{$company->company_description}}</textarea>
                            </p>
                            <p class="form-group">
                                <label for="">Company Tagline</label>
                                <input class="form-control" value="{{$company->company_tagline}}" type="text" name="company_tagline" placeholder="Company Tagline" id="company_tagline">
                            </p>
                            <p class="form-group">
                                <label for="">Website</label>
                                <input class="form-control" value="{{$company->company_website}}" type="text" name="company_website" placeholder="Company Website" id="company_website">
                            </p>
                            <p class="form-group">
                                <label for="">Company Email</label>
                                <input class="form-control" value="{{$company->company_email}}" type="email" name="company_email" placeholder="Company Email" id="company_email">
                            </p>
                            <p class="form-group">
                                <label for="">Phone *</label>
                                <input class="form-control" value="{{preg_replace("/[^A-Za-z0-9]/","",$company->company_phone)}}" type="text" name="company_phone" placeholder="Company Phone" id="company_phone">
                            </p>
                            <p class="form-group">
                                <label for="">Linkedin Profile</label>
                                <input class="form-control" value="{{$company->linkedin_url}}" type="url" name="linkedin_url" placeholder="Linkedin URL" id="linkedin_url">
                            </p>
                            <p class="form-group">
                                <label for="">City *</label>
                                <select name="city" id="city" class="form-control custom-select d-block" required>
                                    <option value="Cairo" selected>Cairo</option>
                                </select>
                            </p>
                            <p class="form-group">
                                <label for="">Company Size *</label>
                                <select name="company_size" id="company_size" class="form-control custom-select d-block">
                                    <option value="">Select Size</option>
                                    <option value="0-1 Employees">0-1 Employees</option>
                                    <option value="2-10 Employees">2-10 Employees</option>
                                    <option value="11-50 Employees">11-50 Employees</option>
                                    <option value="51-200 Employees">51-200 Employees</option>
                                    <option value="201-500 Employees">201-500 Employees</option>
                                    <option value="501+ Employees">501+ Employees</option>
                                </select>
                            </p>
                            <p class="form-group">
                                <label for="">Company Type</label>
                                <select name="company_type" id="company_type" class="form-control custom-select d-block">
                                    <option value="">Select Type</option>
                                    <option value="Sole Ownership">Sole Ownership</option>
                                    <option value="Limited Liability Company (LLC)">Limited Liability Company (LLC)</option>
                                    <option value="Free Zone Sole Ownership">Free Zone Sole Ownership</option>
                                    <option value="Free Zone LLC">Free Zone LLC</option>
                                    <option value="Public Joint-Stock Company (PJSC)">Public Joint-Stock Company (PJSC)</option>
                                    <option value="Private Joint-Stock Company (PrJSC)">Private Joint-Stock Company (PrJSC)</option>
                                </select>
                            </p>
                            <p class="form-group">
                                <label for="">Industry *</label>
                                <select name="industry_id" id="industry_id" class="form-control custom-select d-block" required>
                                    @foreach($industries as $industry)
                                    @if(app()->getLocale() == 'ar')
                                        <option value="{{$industry->id}}" {{$industry->id == $company->industry->id ? 'selected' : ''}}>{{$industry->industry_name_ar}}</option>
                                    @else
                                        <option value="{{$industry->id}}" {{$industry->id == $company->industry->id ? 'selected' : ''}}>{{$industry->industry_name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </p>
                            <p class="form-group">
                                <label for="">Company Status</label>
                                <select name="status" id="status" class="form-control custom-select d-block" required>
                                    <option value="1" {{$company->status == 1 ? 'selected' : ''}}>Show</option>
                                    <option value="0" {{$company->status == 0 ? 'selected' : ''}}>Hide</option>
                                </select>
                            </p>
                            <p class="form-group">
                                <div class="form-group">
                                    <label for="speciality_id">Specialities</label>
                                    <input type="text" name="speciality_id" placeholder="Specialities" class="typeahead tm-input form-control tm-input-info"/>
                                    <p class="form-guide">Write your keywords separated with commas</p>
                                </div>
                            </p>
                            <p class="form-group">
                                <label for="">Registeration Number</label>
                                <input class="form-control" value="{{$company->reg_number}}" type="text" name="reg_number" placeholder="Registeration Number" id="reg_number">
                            </p>
                            <p class="form-group">
                                <label for="">Registeration Date</label>
                                <input class="form-control" value="{{$company->reg_date}}" type="date" name="reg_date" placeholder="Registeration Date" id="reg_date">
                            </p>
                            <p class="form-group">
                                <label for="">Location</label>
                                <input class="form-control" value="{{$company->location}}" type="text" name="location" placeholder="Location" id="location">
                            </p>
                            <p class="form-group">
                                <label for="">Company Logo</label>
                                <label class="custom-file">
                                    <input type="file" id="logo_url" name="logo_url" class="custom-file-input" accept=".jpg, .png, .jpeg"> 
                                    <span class="custom-file-control" data-label="Company Logo"></span>
                                </label>
                            </p>
                            <br>
                            @if($company->logo_url && file_exists(public_path('/') . $company->logo_url))
                                <img src="{{asset($company->logo_url)}}" alt="" class="company-logo">
                            @endif
                            <br>
                            <br>
                            <p class="form-group">
                                <label for="">Company Cover</label>
                                <label class="custom-file">
                                    <input type="file" id="cover_url" name="cover_url" class="custom-file-input" accept=".jpg, .png, .jpeg"> 
                                    <span class="custom-file-control" data-label="Company Cover"></span>
                                </label>
                            </p>
                            <br>
                            <div class="media">
                                @if($company->cover_url  && file_exists(public_path('/') . $company->cover_url))
                                    <img class="img-fluid img-full" src="{{asset($company->cover_url)}}" alt="">
                                @endif
                            </div>
                            <br>
                            <p class="form-group">
                                <label for="">Registration Documents</label>
                                <label class="custom-file">
                                    <input type="file" id="reg_doc" name="reg_doc" class="custom-file-input" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf, .zip, .rar, .jpg, .jpeg, .png, .gif"> 
                                    <span class="custom-file-control" data-label="Registration Documents"></span>
                                </label>
                                <p class="form-guide">Accepts Excel, Word, PowerPoint, Text, PDF, ZIP, RAR</p>
                            </p>
                            @if($company->reg_doc)
                                @if($company->files->count() > 0)
                                    <div class="download-box d-flex justify-content-between align-items-center">
                                        <label>Uploaded Documents:</label>
                                        <div>
                                        @foreach($company->files as $file)
                                            @if(file_exists(public_path('/companies/files/'. $file->file_path)))
                                                <p class="list-item more-inf"><a href="#" onclick="event.preventDefault(); document.getElementById('delete-file-{{$file->id}}').submit();"><i class="fa fa-times" aria-hidden="true" style="color:red;" data-toggle="tooltip" data-placement="bottom" title="Delete File"></i></a><a href="{{asset('companies/files/'. $file->file_path)}}" target="_blank"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Download File"></i> {{$file->file_name}}</a></p>
                                            @else
                                                <p class="list-item more-inf"><a href="#" onclick="event.preventDefault(); document.getElementById('delete-file-{{$file->id}}').submit();"><i class="fa fa-times" aria-hidden="true" style="color:red;" data-toggle="tooltip" data-placement="bottom" title="Delete File"></i></a><a href="{{asset('companies/files/'. $file->file_path)}}" target="_blank"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Download File"></i> <strike>{{$file->file_name}}</strike> <i>(File Damaged Re-upload)</i></a></p>
                                            @endif
                                        @endforeach
                                        </div>
                                    
                                    </div>
                                @endif
                            @endif
                            <br>
                            <br>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                        
                    </form>
                    @role('superadmin')
                    <!-- <h1>DON'T EVER USE THIS CUZ ALL COMPANY OWNER PROJECTS, INTERESTS, REVIEWS, CLAIMS, BOOKMARKS WILL BE DELETED PERMENTANTLY.</h1>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); document.getElementById('delete').submit();"><i class="fa fa-trash fa-3x" aria-hidden="true"></i> DELETE COMPANY</a></div>
                    
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert"><a href="#" class="btn btn-alert text-capitalize" onclick="event.preventDefault(); document.getElementById('delete-reviews').submit();"><i class="fa fa-trash fa-3x" aria-hidden="true"></i> Clear Reviews</a></div>
                    
                    <form id="delete" action="{{route('admin.company.delete', $company->slug)}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}                        
                    </form>

                    <form id="delete-reviews" action="{{route('admin.company.delete-reviews', $company->slug)}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}                        
                    </form> -->
                    @endrole
                    <br>
                    <div class="row">
                        <div class="col-md-12 alert alert-success alert-green alert-dismissible fade assign-user-alert" role="alert">
                            <h3 class="assign-msg"></h3>
                        </div>
                        <div class="col-md-6">
                            <h2>1. Assign Company to a User</h2>
                            <form class="call-form" id="assign-company-to-user" method="post">
                                {{csrf_field()}}
                                
                                <div class="form-group-verify">
                                    <div class="from-group">
                                        <label class="custom-control">Existing User</label>
                                        <div class="input-group"><input type="email" id="user_email" name="user_email" placeholder="User Email" class="form-control" aria-label="User Email" aria-describedby="basic-addon1" value="{{$company->user ? $company->user->email : ''}}" required/> <i class="fa fa-check" id="verified-check" style="display:none;" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="from-group mt-3">
                                        <button id="assign-company" class="btn btn-sm btn-yellow-2 pull-left">Assign Company</button>
                                        <p class="verify pull-left ml-3" style="display:none;">( Verified )</p>
                                    </div>
                                </div>
                                <input type="hidden" class="get-info" value="{{$company->slug}}"/>
                                <input type="hidden" name="mod_user" value="{{Auth()->user()->id}}"/>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h2>2. Create User To Company</h2>
                            <form class="call-form user-setting" id="create-user-form" method="post">
                                {{csrf_field()}}
                                <div class="form-group"><input type="text" name="first_name" id="first_name" placeholder="First Name *" class="form-control" required/></div>
                                <div class="form-group"><input type="text" name="last_name" id="last_name" placeholder="Last Name *" class="form-control" required/></div>
                                <div class="form-group"><input type="email" name="email" id="email" placeholder="Email Address *" class="form-control" required/></div>
                                <div class="form-group"><input type="text" name="phone" id="phone" placeholder="Phone" class="form-control"/></div>
                                <div class="form-group">
                                    <label class="custom-control">Company Role</label>
                                    <select name="role" class="form-control custom-select d-block" id="role" required>
                                        <option value="Company Owner">Company Owner</option>
                                        <option value="General Manager">General Manager</option>
                                        <option value="Sales and/or Marketing Director">Sales and/or Marketing Director</option>
                                        <option value="Account Manager">Other</option>
                                    </select>
                                </div>
                                <input type="hidden" class="get-info" value="{{$company->slug}}"/>
                                <input type="hidden" name="mod_user" value="{{Auth()->user()->id}}"/>
                                <button class="btn btn-blue btn-yellow pull-right" id="create-user">Create User</button>
                            </form>
                        </div>
                    </div>

                    <script>
                        $("#assign-company").click(function(e){
                            e.preventDefault();

                            var company_id = $(this).closest('#assign-company-to-user').find('.get-info').val();
                            var url = '{{ route("assign-company-ajax", ":company_id") }}';
                            $('#edit-company .modal-cover').show();
                            $.post(url.replace(':company_id', company_id),
                            {
                                user_email: $(this).closest('#assign-company-to-user').find('#user_email').val(),
                                mod_user: $(this).closest('#assign-company-to-user').find( "input[name='mod_user']" ).val(),

                            }).done(function( data ) {
                                $('#assign-company-to-user').find('.verify').show();
                                $('#verified-check').show();
                                $('.assign-msg').html('<i class="fa fa-check fa-2x" aria-hidden="true"></i>' + data.success);
                                $('.assign-user-alert').addClass('show').show();
                            });

                        });

                        $("#create-user").click(function(e){
                            e.preventDefault();

                            var company_id = $(this).closest('#create-user-form').find('.get-info').val();
                            var url = '{{ route("user-company-ajax", ":company_id") }}';
                            $('#edit-company .modal-cover').show();
                            $.post(url.replace(':company_id', company_id),
                            {
                                first_name: $(this).closest('#create-user-form').find('#first_name').val(),
                                last_name: $(this).closest('#create-user-form').find('#last_name').val(),
                                phone: $(this).closest('#create-user-form').find('#phone').val(),
                                email: $(this).closest('#create-user-form').find('#email').val(),
                                role: $(this).closest('#create-user-form').find('#role').val(),
                                mod_user: $(this).closest('#create-user-form').find( "input[name='mod_user']" ).val(),

                            }).done(function( data ) {
                                $('.assign-msg').html('<i class="fa fa-check fa-2x" aria-hidden="true"></i>' + data.msg);
                                $('.assign-msg').after('<p>' + data.data + '</p>');
                                $('.assign-user-alert').addClass('show').show();
                                //clear
                                $("#create-user-form")[0].reset();
                            });

                        });

                    </script>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
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
