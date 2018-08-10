<div class="modal fade modal-fullscreen modal-add-company" id="add-company" tabindex="-1" role="dialog" aria-labelledby="add-company" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">{{__('general.add_company_button')}}</h5>
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
                                <div class="form-group"><label for="">{{__('company.company_name')}}</label>
                                    <input class="form-control" type="text" name="company_name" placeholder="{{__('company.company_name')}}" id="company_name" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">{{__('general.industry_title')}} *</label>
                                    <select name="industry_id" class="form-control custom-select d-block" id="industry_id" required>
                                        @foreach($industries as $industry)
                                        <option value="{{$industry->id}}">
                                            @if(app()->getLocale() == 'ar')
                                            {{$industry->industry_name_ar}}
                                            @else
                                            {{$industry->industry_name}}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">{{__('company.website')}}</label>
                                    <input class="form-control" type="text" name="company_website" placeholder="{{__('company.website')}}" id="company_website">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="speciality_id">{{__('general.specs_tag_title')}}</label>
                                    <input type="text" name="speciality_id" placeholder="{{__('general.specs_tag_title')}}" class="typeahead tm-input form-control tm-input-info"/>
                                    <p class="form-guide">{{__('company.specs_hint')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">{{__('company.linked_in')}}</label>
                                    <input class="form-control" type="text" name="linkedin_url" placeholder="{{__('company.linked_in')}}" id="linkedin_url">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">{{__('company.company_type')}}</label>
                                    <select name="company_type" id="company_type" class="form-control custom-select d-block">
                                        <option value="Sole Ownership">{{__('company.company_type_1')}}</option>
                                        <option value="Limited Liability Company (LLC)">{{__('company.company_type_2')}}</option>
                                        <option value="Free Zone Sole Ownership">{{__('company.company_type_3')}}</option>
                                        <option value="Free Zone LLC">{{__('company.company_type_4')}}</option>
                                        <option value="Public Joint-Stock Company (PJSC)">{{__('company.company_type_5')}}</option>
                                        <option value="Private Joint-Stock Company (PrJSC)">{{__('company.company_type_6')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">{{__('company.company_brief')}}</label>
                                    <textarea name="company_description" class="form-control" id="company_description" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('company.company_role')}}</label>
                                    <select name="role" class="form-control custom-select d-block" required>
                                        <option value="Company Owner">{{__('company.company_owner')}}</option>
                                        <option value="General Manager">{{__('company.general_manager')}}</option>
                                        <option value="Sales and/or Marketing Director">{{__('company.sales')}}</option>
                                        <option value="Account Manager">{{__('company.other')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">{{__('company.company_size')}} *</label>
                                    <select name="company_size" id="company_size" class="form-control custom-select d-block" required>
                                        <option value="0-1 Employees">0-1 {{__('company.employees')}}</option>
                                        <option value="2-10 Employees">2-10 {{__('company.employees')}}</option>
                                        <option value="11-50 Employees">11-50 {{__('company.employees')}}</option>
                                        <option value="51-200 Employees">51-200 {{__('company.employees')}}</option>
                                        <option value="201-500 Employees">201-500 {{__('company.employees')}}</option>
                                        <option value="501+ Employees">501+ {{__('company.employees')}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('company.city_label')}} *</label>
                                    <select name="city" id="city" class="form-control custom-select d-block" required>
                                        <option value="Cairo">{{__('footer.cairo')}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('company.phone')}} *</label>
                                    <input class="form-control" type="text" name="company_phone" placeholder="{{__('company.phone')}}" id="company_phone" required>
                                </div>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="btn-list text-center my-3">
                                    <button type="submit" name="save" value="save" class="btn btn-blue mr-3">{{__('company.save_exit')}}</a> 
                                    <button type="submit" name="edit" value="edit" class="btn btn-blue">{{__('company.continue_editing')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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