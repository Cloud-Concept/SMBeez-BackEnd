<div class="modal fade modal-fullscreen" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">Write A Review</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="write-review">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label for="recipient-name" class="col-form-label">What is your relation to <span class="company-name-here"></span>?</label></div>
                                <div class="form-group form-bg">
                                    <ul class="nav radio-tabs" role="tablist">
                                        <li><a class="active radio-link" id="form1-tab" data-toggle="tab" href="#form1" role="tab" aria-controls="form1" aria-selected="true"><label class="custom-control custom-radio"><input id="radio1-test" name="radioselect" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">I am a Customer</span></label></a></li>
                                        <li><a class="radio-link" id="form2-tab" data-toggle="tab" href="#form2" role="tab" aria-controls="form2" aria-selected="false"><label class="custom-control custom-radio"><input id="radio2-test" name="radioselect" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">I am a Supplier</span></label></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="formTabs">
                            <div class="tab-pane fade show active" id="form1" role="tabpanel" aria-labelledby="form1-tab">
                                <form action="{{route('add.review.customer')}}" method="post" class="write-review">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><label for="company_name" class="col-form-label">What is the company name you want to review? *</label>
                                                <input id="company_name" class="form-control" placeholder="Company Name *" name="company_name" required>
                                            </div>
                                            <div class="form-group"><label for="recipient-name" class="col-form-label">Did your company hire <span class="company-name-here"></span> to do some work?</label></div>
                                            <div class="radio-cases" id="first-level">
                                                <div class="form-group case-01 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="is_hired1" value="1" name="is_hired" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="is_hired2" name="is_hired" value="0" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                            </div>
                                            <div id="second-level">
                                                <div class="yes-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Did <span class="company-name-here"></span> complete the work successfully?</label></div>
                                                    <div class="form-group case-02 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="completness1" value="1" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="completness2" value="0" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                                </div>
                                            </div>
                                            <div id="third-level">
                                                <div class="no-case-info">                                                
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Why not?</label></div>
                                                    <div class="form-group case-03 form-bg">
                                                        <select name="why_not" class="form-control">
                                                            <option value="">Select Reason</option>
                                                            <option value="time"><span class="company-name-here"></span> failed to deliver work on time</option>
                                                            <option value="quality"><span class="company-name-here"></span> failed to provide the expected level of quality</option>
                                                            <option value="cost"><span class="company-name-here"></span> requested additional cost</option>
                                                            <option value="they-out"><span class="company-name-here"></span> went out of business</option>
                                                            <option value="we-out">My company went out of business</option>
                                                            <option class="radio-no-case" value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="four-level">
                                                <div class="no-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Please elaborate</label></div>
                                                    <div class="form-group case-04 form-bg">
                                                        <textarea class="form-control" id="why_not_msg" name="why_not_msg" placeholder="Write your text here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">Please give your overall assessment of <span class="company-name-here"></span></label><textarea class="form-control" id="feedback" name="feedback" placeholder="Write your text here..." required></textarea></div>
                                        </div>
                                        <div class="col-md-6 casepushup">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">How would you rate "<span class="company-name-here"></span>"</label>
                                                <div class="d-flex mt-4">
                                                    <h5>Quality</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="quality" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Cost</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="cost" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Time</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="time" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Repeat Business</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="business_repeat" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="overall_rate" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">How would you like the public to preview your review</label><label class="custom-control custom-radio"><input id="privacy1" name="privacy" value="public" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Display my Name & Company to Public</span></label><br><label class="custom-control custom-radio"><input id="privacy2" name="privacy" value="private" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Stay Anonymous</span></label></div>
                                            <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Submit Review</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="form2" role="tabpanel" aria-labelledby="form2-tab">
                                <form action="{{route('add.review.supplier')}}" method="post" class="write-review">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><label for="company_name" class="col-form-label">What is the company name you want to review? *</label>
                                                <input id="company_name" class="form-control" placeholder="Company Name *" name="company_name" required>
                                            </div>
                                            <div class="form-group"><label for="recipient-name" class="col-form-label">Was your company hired by <span class="company-name-here"></span> to do some work?</label></div>
                                            <div class="radio-cases" id="first-level">
                                                <div class="form-group case-01 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="is_hired3" name="is_hired" value="1" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="is_hired4" value="0" name="is_hired" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                            </div>
                                            <div id="second-level">
                                                <div class="yes-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Did you complete the work successfully?</label></div>
                                                    <div class="form-group case-02 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="completness3" value="1" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Yes</span></label><label class="custom-control custom-radio radio-no-case"><input id="completness4" name="completness" value="0" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">No</span></label></div>
                                                </div>
                                            </div>
                                            <div id="third-level">
                                                <div class="no-case-info">                                                
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Why not?</label></div>
                                                    <div class="form-group case-03 form-bg">
                                                        <select name="why_not" class="form-control">
                                                            <option value="">Select Reason</option>
                                                            <option value="cancelled">Client canceled the project</option>
                                                            <option value="nopay">Client did not pay</option>
                                                            <option value="expectations">Client expectations were unreasonable</option>
                                                            <option value="they-out">Client went out of business</option>
                                                            <option value="we-out">My company went out of business</option>
                                                            <option class="radio-no-case" value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="four-level">
                                                <div class="no-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">Please elaborate</label></div>
                                                    <div class="form-group case-04 form-bg">
                                                        <textarea class="form-control" id="why_not_msg1" name="why_not_msg" placeholder="Write your text here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">Please give your overall assessment of <span class="company-name-here"></span></label><textarea class="form-control" id="feedback1" name="feedback" placeholder="Write your text here..." required></textarea></div>
                                        </div>
                                        <div class="col-md-6 casepushup">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">How would you rate "<span class="company-name-here"></span>"</label>
                                                <div class="d-flex mt-4">
                                                    <h5>Procurement</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="procurement" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Expectations</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="expectations" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Payments</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="payments" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Repeat Business</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="business_repeat" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <h5>Overall Rating</h5>
                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <select name="overall_rate" class="star-rating-fn">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">How would you like the public to preview your review</label><label class="custom-control custom-radio"><input id="privacy3" name="privacy" value="public" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Display my Name & Company to Public</span></label><br><label class="custom-control custom-radio"><input id="privacy4" name="privacy" value="private" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Stay Anonymous</span></label></div>
                                            <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Submit Review</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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

$( "#company_name" ).keyup(function() {
    setTimeout(
    function() {
        var company_name = jQuery("#company_name").val();
        jQuery(".company-name-here").text(company_name);
    }, 5000);   
});



</script>