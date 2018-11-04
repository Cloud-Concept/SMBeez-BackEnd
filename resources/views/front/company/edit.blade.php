@extends('layouts.inner')

@section('content')
<nav class="dashboard-nav navbar navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i></button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent2">
        @include ('layouts.dashboard-menu')
    </div>
</nav>
<main class="cd-main-content">
    <section class="dashboard compnay-edit">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>

                    <div id="status"></div> -->
                    <!-- action="{{route('front.company.updatelogo', $company->slug)}}" method="post" role="form" enctype="multipart/form-data" -->
                    <form id="img_upload"action="{{route('front.company.updatelogo', $company->slug)}}" method="post" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="sidebar-company-logo border-0 d-flex justify-content-between pb-2">
                        @if($company->logo_url && file_exists(public_path('/') . $company->logo_url))
                            <img src="{{asset($company->logo_url)}}" alt="" class="company-logo">
                        @endif
                        </div>
                        <div class="form-group">
                            <label class="custom-file">
                                <input type="file" id="logo_url" name="logo_url" class="custom-file-input" accept=".png, .jpg, .jpeg, .bmp"> 
                                <span class="custom-file-control" data-label="Upload Logo"></span>
                            </label>
                        </div>

                        <div class="sidebar-dashboard mt-5">
                            <div class="sidebar-company-logo border-0 d-flex justify-content-between pb-2">
                                @if($company->cover_url  && file_exists(public_path('/') . $company->cover_url))
                                    <img class="img-fluid img-full" src="{{asset($company->cover_url)}}" alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <p class="form-guide">{{__('company.upload_img_hint')}}</p>
                                <label class="custom-file"><input type="file" name="cover_url" class="custom-file-input" accept=".png, .jpg, .jpeg, .bmp">
                                 <span class="custom-file-control" data-label="Upload Cover"></span>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" id="upload" class="btn btn-sm btn-yellow-2 mt-3">{{__('company.save_btn')}}</button>
                    </form>
                    
                </div>

                <div class="col-md-6">
                    <form id="update-company" action="{{route('front.company.update', $company->slug)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">{{__('company.my_dashboard')}}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('front.company.show', $company->slug)}}">{{$company->company_name}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('company.edit_company_btn')}}</li>
                            </ol>
                        </nav>
                        <div class="dashboard-company-block">
                            <div class="media-body">
                                <h5 class="mt-1 mb-2"><a href="{{route('front.company.show', $company->slug)}}">{{$company->company_name}}</a></h5>
                                <p class="tags"><b>{{__('general.industry_title')}}</b><a href="{{route('front.company.showindustry', $company->industry->slug)}}">
                                    @if(app()->getLocale() == 'ar')
                                    {{$company->industry->industry_name_ar}}
                                    @else
                                    {{$company->industry->industry_name}}
                                    @endif
                                </a></p>
                                @if($company->specialities->count() > 0)
                                <p class="tags"><b>{{__('general.specs_tag_title')}}</b> <span>
                                    
                                    @foreach($company->specialities as $speciality)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{$speciality->speciality_name}}
                                    @endforeach
                                </span></p>
                                @endif
                            </div>
                            <h4>{{__('company.company_berif')}}</h4>
                            <textarea class="form-control mb-3" name="company_description" id="company_description" required>{!! strip_tags($company->company_description) !!}</textarea>
                            <button type="submit" class="btn btn-sm btn-yellow-2">{{__('company.save_btn')}}</button>
                        </div>
                        <div class="dashboard-company-block my-3">
                            <table class="table">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col" colspan="2">{{__('company.basic_information')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row"><b>{{__('company.tag_line')}}</b></td>
                                        <td><input class="form-control" type="text" name="company_tagline" value="{{$company->company_tagline}}" id="company_tagline"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.website')}}</b></td>
                                        <td><input class="form-control" type="text" name="company_website" value="{{$company->company_website}}" id="company_website"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.email')}}</b></td>
                                        <td><input class="form-control" type="email" name="company_email" value="{{$company->company_email}}" id="company_email"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.phone')}}</b></td>
                                        <td><input class="form-control" type="text" name="company_phone" value="{{preg_replace("/[^A-Za-z0-9]/","",$company->company_phone)}}" id="company_phone" required></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.linked_in')}}</b></td>
                                        <td><input class="form-control" type="text" name="linkedin_url" value="{{$company->linkedin_url}}" id="linkedin_url"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.city_label')}}</b></td>
                                        <td><select class="form-control custom-select d-block" name="city" id="city" required>
                                            <option value="Cairo">{{__('footer.cairo')}}</option>
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.company_size')}}</b></td>
                                        <td><select name="company_size" id="company_size" class="form-control custom-select d-block" required>
                                            @foreach($company_size_array as $company_size)
                                            <option value="{{$company_size}}" {{$company_size === $company->company_size ? 'selected' : ''}}>{{$company_size}}</option>
                                            @endforeach
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.year_found')}}</b></td>
                                        <td><input class="form-control" type="text" name="year_founded" value="{{$company->year_founded}}" id="year_founded"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.company_type')}}</b></td>
                                        <td><select name="company_type" id="company_type" class="form-control custom-select d-block">
                                            @foreach($company_type_array as $company_type)
                                            <option value="{{$company_type}}" {{$company_type === $company->company_type ? 'selected' : ''}}>{{$company_type}}</option>
                                            @endforeach
                                        </select></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('general.specs_tag_title')}}</b></td>
                                        <td><input type="text" name="speciality_id" placeholder="{{__('general.specs_tag_title')}}" class="typeahead tm-input form-control tm-input-info"/></td>
                                    </tr>
                                    <tr>
                                        <td scope="row"><b>{{__('company.address_label')}}</b></td>
                                        <td><input class="form-control" type="text" name="location" value="{{$company->location}}" id="location" placeholder="{{__('company.address_label')}}"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-sm btn-yellow-2 mt-3 mb-5">{{__('company.save_btn')}}</button>
                            <table class="table">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col" colspan="2">{{__('company.company_reg_details')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row">{{__('company.reg_no')}} :</td>
                                        <td><input class="form-control" type="text" name="reg_number" value="{{$company->reg_number}}" id="reg_number" placeholder="{{__('company.reg_no')}}"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">{{__('company.date_of_reg')}} :</td>
                                        <td><input data-provide="datepicker" class="form-control" name="reg_date" value="{{$company->reg_date}}" id="reg_date" placeholder="dd/mm/yyyy"></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">{{__('company.upload_doc')}}:</td>
                                        <td>
                                            <label class="custom-file">
                                                <input type="file" id="reg_doc" name="reg_doc[]" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .doc, .docx, .xlsx, .xls,text/plain, application/pdf, .zip, .rar" multiple> 
                                                <span class="custom-file-control" data-label="Registration Documents"></span>
                                            </label>
                                            <p class="form-guide">{{__('company.reg_hint')}}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if($company->files->count() > 0)
                        <div class="download-box d-flex justify-content-between align-items-center">
                            <label>{{__('company.uploaded_docs')}}:</label>
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
                        <button type="submit" class="btn btn-sm btn-yellow-2 my-3">{{__('company.save_btn')}}</button>
                    </form>
                    @foreach($company->files as $file)
                    <form id="delete-file-{{$file->id}}" action="{{route('front.file.delete', $file->id)}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}                        
                    </form>
                    @endforeach
                </div>
                <div class="col-md-3">
                    <div class="sidebar-review-rating">
                        <div class="rating-sidebar-block">
                            <h5 class="mb-3">{{__('company.my_reviews')}}</h5>
                            <div class="star-rating mb-3">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <select class="star-rating-ro">
                                            @for($i = 0; $i <= 5; $i++)
                                            <option value="{{$i}}" {{$i == $company->customer_rating($company->id, $customer_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </li>
                                </ul>
                                <a href="{{route('front.company.show', $user->company->slug)}}/?tab=customers">({{$customer_reviews->count()}}) {{__('company.reviews_from_customers')}}</a>
                            </div>
                            <div class="star-rating">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <select class="star-rating-ro">
                                            @for($i = 0; $i <= 5; $i++)
                                            <option value="{{$i}}" {{$i == $company->suppliers_rating($company->id, $suppliers_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </li>
                                </ul>
                                <a href="{{route('front.company.show', $user->company->slug)}}/?tab=suppliers">({{$suppliers_reviews->count()}}) {{__('company.reviews_from_suppliers')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">
/*$("#upload").click(function(e){
    e.preventDefault();

    var company_id = '{{$company->slug}}';
    var url = '{{ route("update-company-imgs", ":company_id") }}';
    // Get form
    var form = $('#img_upload')[0];

    var data = new FormData(form);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: url.replace(':company_id', company_id),
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {

            console.log(data);

        },
        error: function (e) {

            console.log("ERROR : ", e);

        }
    });
});*/

/*var total_photos_counter = 0;
var company_id = '{{$company->slug}}';
var url = '{{ route("update-company-imgs", ":company_id") }}';
Dropzone.options.myDropzone = {
    uploadMultiple: false,
    parallelUploads: 2,
    maxFilesize: 32,
    previewTemplate: document.querySelector('#preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Remove file',
    dictFileTooBig: 'Image is larger than 32MB',
    timeout: 30000,

    init: function () {
        this.on("removedfile", function (file) {
            console.log('sadasds');
            $.post({
                url: url.replace(':company_id', company_id),
                data: {id: file.name, _token: $('[name="_token"]').val()},
                dataType: 'json',
                success: function (data) {
                    total_photos_counter--;
                    $("#counter").text("# " + total_photos_counter);
                }
            });
        });
    },
    success: function (file, done) {
        console.log('sadasds');
        total_photos_counter++;
        $("#counter").text("# " + total_photos_counter);
    }
};*/

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