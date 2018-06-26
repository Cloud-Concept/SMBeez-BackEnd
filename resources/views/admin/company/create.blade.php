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
                            <li class="breadcrumb-item active" aria-current="page">Create Company</li>
                        </ol>
                    </nav>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{route('admin.company.store')}}" class="user-setting" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="form-group">
                                <label for="">Company name *</label>
                                <input class="form-control" type="text" name="company_name" placeholder="Company Name" id="company_name" required>
                            </p>
                            <p class="form-group">
                                <label for="">What is your company main message? *</label>
                                <textarea name="company_description" class="form-control" placeholder="Company Description" id="company_description" required></textarea>
                            </p>
                            <p class="form-group">
                                <label for="">Company Tagline</label>
                                <input class="form-control" type="text" name="company_tagline" placeholder="Company Tagline" id="company_tagline">
                            </p>
                            <p class="form-group">
                                <label for="">Website</label>
                                <input class="form-control" type="url" name="company_website" placeholder="Company Website" id="company_website">
                            </p>
                            <p class="form-group">
                                <label for="">Company Email</label>
                                <input class="form-control" type="email" name="company_email" placeholder="Company Email" id="company_email">
                            </p>
                            <p class="form-group">
                                <label for="">Phone *</label>
                                <input class="form-control" type="text" name="company_phone" placeholder="Company Phone" id="company_phone">
                            </p>
                            <p class="form-group">
                                <label for="">Linkedin Profile</label>
                                <input class="form-control" type="url" name="linkedin_url" placeholder="Linkedin URL" id="linkedin_url">
                            </p>
                            <p class="form-group">
                                <label for="">City *</label>
                                <select name="city" id="city" class="form-control custom-select d-block" required>
                                    <option value="Cairo">Cairo</option>
                                </select>
                            </p>
                            <p class="form-group">
                                <label for="">Company Size *</label>
                                <select name="company_size" id="company_size" class="form-control custom-select d-block" required>
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
                                    <option value="{{$industry->id}}">{{$industry->industry_name}}</option>
                                    @endforeach
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
                                <input class="form-control" type="text" name="reg_number" placeholder="Registeration Number" id="reg_number">
                            </p>
                            <p class="form-group">
                                <label for="">Registeration Date</label>
                                <input class="form-control" type="date" name="reg_date" placeholder="Registeration Date" id="reg_date">
                            </p>
                            <p class="form-group">
                                <label for="">Location</label>
                                <input class="form-control" type="text" name="location" placeholder="Location" id="location">
                            </p>
                            <p class="form-group">
                                <label for="">Company Logo</label>
                                <label class="custom-file">
                                    <input type="file" id="logo_url" name="logo_url" class="custom-file-input" accept=".jpg, .png, .jpeg"> 
                                    <span class="custom-file-control" data-label="Company Cover"></span>
                                </label>
                            </p>
                            <p class="form-group">
                                <label for="">Company Cover</label>
                                <label class="custom-file">
                                    <input type="file" id="cover_url" name="cover_url" class="custom-file-input" accept=".jpg, .png, .jpeg"> 
                                    <span class="custom-file-control" data-label="Company Cover"></span>
                                </label>
                            </p>
                            <p class="form-group">
                                <label for="">Registration Documents</label>
                                <label class="custom-file">
                                    <input type="file" id="reg_doc" name="reg_doc" class="custom-file-input" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf, .zip, .rar"> 
                                    <span class="custom-file-control" data-label="Registration Documents"></span>
                                </label>
                                <p class="form-guide">Accepts Excel, Word, PowerPoint, Text, PDF, ZIP, RAR</p>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript">
var tagApi = $(".tm-input").tagsManager();

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
//check for existing companies
jQuery("#company_name").typeahead({
  name: 'company_name',
  displayKey: 'company_name',
  source: function (query, process) {
    return $.get('{!!url("/")!!}' + '/api/company-suggest', { keyword: query }, function (data) {
      data = $.parseJSON(data);
      return process(data);
    });
  },
});
</script>
@endsection

