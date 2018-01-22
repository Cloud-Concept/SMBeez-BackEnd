<div class="modal fade modal-fullscreen modal-add-company" id="add-company" tabindex="-1" role="dialog" aria-labelledby="add-company" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">Add your company</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form class="form-signup mt-2" action="{{route('front.company.store')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group"><label for="">Company name *</label>
                                    <input class="form-control" type="text" name="company_name" placeholder="Company Name" id="company_name" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Industry *</label>
                                    <select name="industry_id" class="form-control custom-select d-block" id="industry_id" required>
                                        @foreach($industries as $industry)
                                        <option value="{{$industry->id}}">{{$industry->industry_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Website</label>
                                    <input class="form-control" type="url" name="company_website" placeholder="Company Website" id="company_website">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Speciality</label>
                                    <select name="speciality_id[]" id="speciality_id" class="multi-select form-control custom-select d-block" multiple>
                                        @foreach($specialities as $speciality)
                                        <option value="{{$speciality->id}}">{{$speciality->speciality_name}}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-guide">Write your keywords separated with commas</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Linkedin Profile</label>
                                    <input class="form-control" type="url" name="linkedin_url" placeholder="Linkedin URL" id="linkedin_url">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Company Type</label>
                                    <select name="company_type" id="company_type" class="form-control custom-select d-block">
                                        <option value="Sole Ownership">Sole Ownership</option>
                                        <option value="Limited Liability Company (LLC)">Limited Liability Company (LLC)</option>
                                        <option value="Free Zone Sole Ownership">Free Zone Sole Ownership</option>
                                        <option value="Free Zone LLC">Free Zone LLC</option>
                                        <option value="Public Joint-Stock Company (PJSC)">Public Joint-Stock Company (PJSC)</option>
                                        <option value="Private Joint-Stock Company (PrJSC)">Private Joint-Stock Company (PrJSC)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">What is your company main message? *</label>
                                    <textarea name="company_description" class="form-control" id="company_description"></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Company Size *</label>
                                    <select name="company_size" id="company_size" class="form-control custom-select d-block" required>
                                        <option value="0-1 Employees">0-1 Employees</option>
                                        <option value="2-10 Employees">2-10 Employees</option>
                                        <option value="11-50 Employees">11-50 Employees</option>
                                        <option value="51-200 Employees">51-200 Employees</option>
                                        <option value="201-500 Employees">201-500 Employees</option>
                                        <option value="501+ Employees">501+ Employees</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">City *</label>
                                    <select name="city" id="city" class="form-control custom-select d-block" required>
                                        <option value="Dubai">Dubai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Phone *</label>
                                    <input class="form-control" type="text" name="company_phone" placeholder="Company Phone" id="company_phone">
                                </div>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="btn-list text-center my-3">
                                    <button type="submit" name="save" value="save" class="btn btn-blue mr-3">Save & Exit</a> 
                                    <button type="submit" name="edit" value="edit" class="btn btn-blue">Continue Editing</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style type="text/css" media="screen">
    .select2-container {
        width: 100%!important;
    }
</style>
<script type="text/javascript">

jQuery(document).ready(function () {
    $('.multi-select').select2();
});

</script>