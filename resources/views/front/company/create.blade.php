@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create New Company</div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{route('front.company.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="field">
                            <p class="group-control">
                                <input class="input-control" type="text" name="company_name" placeholder="Company Name" id="company_name">
                            </p>
                            <textarea name="company_description" id="company_description"></textarea>
                            <p class="group-control">
                                <input class="input-control" type="text" name="company_tagline" placeholder="Company Tagline" id="company_tagline">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="url" name="company_website" placeholder="Company Website" id="company_website">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="email" name="company_email" placeholder="Company Email" id="company_email">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="text" name="company_phone" placeholder="Company Phone" id="company_phone">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="url" name="linkedin_url" placeholder="Linkedin URL" id="linkedin_url">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="text" name="city" placeholder="City" id="city">
                            </p>
                            <p class="group-control">
                                <select name="company_size" id="company_size">
                                    <option value="0-1 Employees">0-1 Employees</option>
                                    <option value="2-10 Employees">2-10 Employees</option>
                                    <option value="11-50 Employees">11-50 Employees</option>
                                    <option value="51-200 Employees">51-200 Employees</option>
                                    <option value="201-500 Employees">201-500 Employees</option>
                                    <option value="501+ Employees">501+ Employees</option>
                                </select>
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="text" name="year_founded" placeholder="Year Founded" id="year_founded">
                            </p>
                            <p class="group-control">
                                <select name="company_type" id="company_type">
                                    <option value="Sole Ownership">Sole Ownership</option>
                                    <option value="Limited Liability Company (LLC)">Limited Liability Company (LLC)</option>
                                    <option value="Free Zone Sole Ownership">Free Zone Sole Ownership</option>
                                    <option value="Free Zone LLC">Free Zone LLC</option>
                                    <option value="Public Joint-Stock Company (PJSC)">Public Joint-Stock Company (PJSC)</option>
                                    <option value="Private Joint-Stock Company (PrJSC)">Private Joint-Stock Company (PrJSC)</option>
                                </select>
                            </p>
                            <p class="group-control">
                                <select name="industry_id" id="industry_id">
                                    @foreach($industries as $industry)
                                    <option value="{{$industry->id}}">{{$industry->industry_name}}</option>
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
                                <input class="input-control" type="text" name="reg_number" placeholder="Registeration Number" id="reg_number">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="date" name="reg_date" placeholder="Registeration Date" id="reg_date">
                            </p>
                            <p class="group-control">
                                <input class="input-control" type="text" name="location" placeholder="Location" id="location">
                            </p>
                            <p class="group-control">
                                <label for="logo_url">Company Logo</label>
                                <input class="input-control" type="file" name="logo_url" id="logo_url">
                            </p>
                            <p class="group-control">
                                <label for="cover_url">Company Cover</label>
                                <input class="input-control" type="file" name="cover_url" id="cover_url">
                            </p>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
