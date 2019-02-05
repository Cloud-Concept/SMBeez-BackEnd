<div class="modal fade modal-fullscreen modal-add-project" id="add-project" tabindex="-1" role="dialog" aria-labelledby="add-project" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">{{__('general.publish_project')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{route('front.project.store')}}" method="post" class="form-signup mt-2" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="form-group"><label for="">{{__('project.title_label')}} *</label>
                                    <input class="form-control" type="text" name="project_title" id="project_title" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">{{__('project.industry')}} *</label>
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
                                <div class="form-group"><label for="">{{__('project.desc_label')}} *</label>
                                    <textarea name="project_description" class="form-control" id="project_description" required></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <!-- <div class="form-group">
                                    <label for="speciality_id">{{__('general.speciality_title')}}</label>
                                    <input type="text" name="speciality_id" placeholder="{{__('project.spec_hint_2')}}" class="typeahead tm-input form-control tm-input-info"/>
                                    <p class="form-guide">{{__('company.specs_hint')}}</p>
                                </div> -->

                                <div class="form-group">
                                    <label for="">{{__('project.estimated_budget')}} *</label>
                                    <input class="form-control" type="number" min="1" name="budget" placeholder="{{__('project.currency')}}" id="budget" required>
                                </div>

                                <div class="form-group">
                                    <label for="">{{__('project.supportive_docs')}}</label><label class="custom-file">
                                        <input type="file" id="supportive_docs" name="supportive_docs[]" class="custom-file-input" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf, .zip, .rar, .jpg, .jpeg, .png, .gif" multiple> 
                                        <span class="custom-file-control" data-label="Upload Project Documents"></span>
                                    </label>
                                    <p class="form-guide">{{__('project.file_hint')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="btn-list text-center my-3"><button type="submit" name="publish" value="publish" class="btn btn-blue">{{__('project.publish')}}</button></div>
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
</script>
