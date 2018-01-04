<div class="modal fade modal-fullscreen modal-add-project" id="add-project" tabindex="-1" role="dialog" aria-labelledby="add-project" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">Publish New Project</h5>
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
                                <div class="form-group"><label for="">Project Title</label>
                                    <input class="form-control" type="text" name="project_title" placeholder="Project Title" id="project_title" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Industry</label>
                                    <select name="industry_id" class="form-control" id="industry_id" required>
                                        @foreach($industries as $industry)
                                        <option value="{{$industry->id}}">{{$industry->industry_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group"><label for="">Project Description</label>
                                    <textarea name="project_description" id="project_description"></textarea>
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

                                <div class="form-group">
                                    <label for="">Estimated Budget</label>
                                    <input class="form-control" type="number" min="1" name="budget" placeholder="Estimated Budget" id="budget" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Supportive Documents</label><label class="custom-file">
                                        <input type="file" name="supportive_docs" id="supportive_docs" accept=".doc, .docx, .xlsx, .xls, application/vnd.ms-powerpoint,text/plain, application/pdf">
                                        <span class="custom-file-control"></span>
                                    </label>
                                    <p class="form-guide">Accepts Excel, Word, PowerPoint, Text, PDF</p>
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

jQuery(document).ready(function () {
    tinymce.init({
        selector: '#project_description',
        plugins: [
          'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
          'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
          'save table contextmenu directionality emoticons template paste textcolor'
        ],
        height: 100,
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview media fullpage | forecolor backcolor emoticons'
    });

    $('.multi-select').select2();
});

</script>