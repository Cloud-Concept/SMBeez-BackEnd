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
                                <div class="form-group"><label for="">Project Title *</label>
                                    <input class="form-control" type="text" name="project_title" id="project_title" required>
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
                                <div class="form-group"><label for="">Project Description *</label>
                                    <textarea name="project_description" class="form-control" id="project_description" required></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="speciality_id">Specialities</label>
                                    <input type="text" name="speciality_id" placeholder="Insert tags that best describe your project" class="typeahead tm-input form-control tm-input-info"/>
                                    <p class="form-guide">Write your keywords separated with commas</p>
                                </div>

                                <div class="form-group">
                                    <label for="">Estimated Budget *</label>
                                    <input class="form-control" type="number" min="1" name="budget" placeholder="Insert your budget in EGP" id="budget" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Supportive Documents</label><label class="custom-file">
                                        <input type="file" id="supportive_docs" name="supportive_docs[]" class="custom-file-input" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf, .zip, .rar" multiple> 
                                        <span class="custom-file-control" data-label="Upload Project Documents"></span>
                                    </label>
                                    <p class="form-guide">Hold the CTRL button to select multiple files.</p>
                                    <p class="form-guide">Accepts Excel, Word, PowerPoint, Text, PDF, Zip, .rar</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="form-guide">The project will be automatically closed within 60 days, you can set your project status to “Draft”, “Open”, “Closed” whenever you need.</p>
                                <div class="btn-list text-center my-3"><button type="submit" name="draft" value="draft" class="btn btn-blue mr-3">Save as Draft</button> <button type="submit" name="publish" value="publish" class="btn btn-blue">Publish Project</button></div>
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
