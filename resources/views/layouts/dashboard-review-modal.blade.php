<div class="modal fade modal-fullscreen" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">{{__('company.write_review')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="write-review">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"><label for="recipient-name" class="col-form-label">ما هي علاقتك ب <span class="company-name-here"></span>؟</label></div>
                                <div class="form-group form-bg">
                                    <ul class="nav radio-tabs" role="tablist">
                                        <li><a class="active radio-link" id="form1-tab" data-toggle="tab" href="#form1" role="tab" aria-controls="form1" aria-selected="true"><label class="custom-control custom-radio"><input id="radio1-test" name="radioselect" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">أنا عميل</span></label></a></li>
                                        <li><a class="radio-link" id="form2-tab" data-toggle="tab" href="#form2" role="tab" aria-controls="form2" aria-selected="false"><label class="custom-control custom-radio"><input id="radio2-test" name="radioselect" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">أنا مورد</span></label></a></li>
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
                                            <div class="form-group"><label for="company_name" class="col-form-label">ما أسم الشركة التي تريد يقييمها؟ *</label>
                                                <input id="company_name" class="form-control" placeholder="أسم الشركة *" name="company_name" required>
                                            </div>
                                            <div class="form-group"><label for="recipient-name" class="col-form-label">هل قامت شركتك بالتعاقد مع شركة <span class="company-name-here"></span> tللقيام بأعمال معينة؟</label></div>
                                            <div class="radio-cases" id="first-level">
                                                <div class="form-group case-01 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="is_hired1" value="1" name="is_hired" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">نعم</span></label><label class="custom-control custom-radio radio-no-case"><input id="is_hired2" name="is_hired" value="0" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">لا</span></label></div>
                                            </div>
                                            <div id="second-level">
                                                <div class="yes-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">هل قامت شركة <span class="company-name-here"></span> بإكمال الأعمال بنجاح؟</label></div>
                                                    <div class="form-group case-02 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="completness1" value="1" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">نعم</span></label><label class="custom-control custom-radio radio-no-case"><input id="completness2" value="0" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">لا</span></label></div>
                                                </div>
                                            </div>
                                            <div id="third-level">
                                                <div class="no-case-info">                                                
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">{{__('company.why_not')}}</label></div>
                                                    <div class="form-group case-03 form-bg">
                                                        <select name="why_not" class="form-control">
                                                            <option value="">{{__('company.select_reason')}}</option>
                                                            <option value="time"><span class="company-name-here"></span> لم ينفذ المشروع في الوقت المحدد</option>
                                                            <option value="quality"><span class="company-name-here"></span> لم ينفذ المشروع في مستوى الجودة المتوقع</option>
                                                            <option value="cost"><span class="company-name-here"></span> طالب بمصاريف إضافية</option>
                                                            <option value="they-out"><span class="company-name-here"></span>  تم إغلاق الشركة الموردة</option>
                                                            <option value="we-out">تم إغلاق شركتي</option>
                                                            <option class="radio-no-case" value="other">{{__('company.other')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="four-level">
                                                <div class="no-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">{{__('company.please_elaborate')}}</label></div>
                                                    <div class="form-group case-04 form-bg">
                                                        <textarea class="form-control" id="why_not_msg" name="why_not_msg" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">ما هو تققيمك العام في شركة <span class="company-name-here"></span></label><textarea class="form-control" id="feedback" name="feedback" placeholder="" required></textarea></div>
                                        </div>
                                        <div class="col-md-6 casepushup">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">ما هو تقييمك ل "<span class="company-name-here"></span>"</label>
                                                <div class="d-flex mt-4">
                                                    <h5>{{__('company.quality')}}</h5>
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
                                                    <h5>{{__('company.cost')}}</h5>
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
                                                    <h5>{{__('company.time')}}</h5>
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
                                                    <h5>{{__('company.business_repeat')}}</h5>
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
                                                    <h5>{{__('company.overall_rating')}}</h5>
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
                                            <div class="form-group"><label for="message-text" class="col-form-label">{{__('company.display_review_author')}}</label><label class="custom-control custom-radio"><input id="privacy1" name="privacy" value="public" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">{{__('company.display_name')}}</span></label><br><label class="custom-control custom-radio"><input id="privacy2" name="privacy" value="private" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">{{__('company.anonymous')}}</span></label></div>
                                            <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{__('company.submit_review')}}</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="form2" role="tabpanel" aria-labelledby="form2-tab">
                                <form action="{{route('add.review.supplier')}}" method="post" class="write-review">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"><label for="company_name" class="col-form-label">ما أسم الشركة التي تريد يقييمها؟ *</label>
                                                <input id="company_name" class="form-control" placeholder="أسم الشركة *" name="company_name" required>
                                            </div>
                                            <div class="form-group"><label for="recipient-name" class="col-form-label">هل قامت شركة <span class="company-name-here"></span> بالتعاقد مع شركتك لتنفيذ مشروع؟</label></div>
                                            <div class="radio-cases" id="first-level">
                                                <div class="form-group case-01 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="is_hired3" name="is_hired" value="1" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">نعم</span></label><label class="custom-control custom-radio radio-no-case"><input id="is_hired4" value="0" name="is_hired" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">لا</span></label></div>
                                            </div>
                                            <div id="second-level">
                                                <div class="yes-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">هل قمت بإنجاز المشروع بنجاح؟</label></div>
                                                    <div class="form-group case-02 form-bg"><label class="custom-control custom-radio radio-yes-case"><input id="completness3" value="1" name="completness" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">نعم</span></label><label class="custom-control custom-radio radio-no-case"><input id="completness4" name="completness" value="0" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">لا</span></label></div>
                                                </div>
                                            </div>
                                            <div id="third-level">
                                                <div class="no-case-info">                                                
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">{{__('company.why_not')}}</label></div>
                                                    <div class="form-group case-03 form-bg">
                                                        <select name="why_not" class="form-control">
                                                            <option value="">{{__('company.select_reason')}}</option>
                                                            <option value="cancelled">{{__('company.sup_cancelled')}}</option>
                                                            <option value="nopay">{{__('company.sup_nopay')}}</option>
                                                            <option value="expectations">{{__('company.sup_expectations')}}</option>
                                                            <option value="they-out">{{__('company.sup_theyout')}}</option>
                                                            <option value="we-out">{{__('company.sup_weout')}}</option>
                                                            <option class="radio-no-case" value="other">{{__('company.other')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="four-level">
                                                <div class="no-case-info">
                                                    <div class="form-group"><label for="recipient-name" class="col-form-label">{{__('company.please_elaborate')}}</label></div>
                                                    <div class="form-group case-04 form-bg">
                                                        <textarea class="form-control" id="why_not_msg1" name="why_not_msg" placeholder=""></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label for="message-text" class="col-form-label">ما هو تقييمك العام في شركة <span class="company-name-here"></span></label><textarea class="form-control" id="feedback1" name="feedback" placeholder="" required></textarea></div>
                                        </div>
                                        <div class="col-md-6 casepushup">
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">ما هو تقييمك ل "<span class="company-name-here"></span>"</label>
                                                <div class="d-flex mt-4">
                                                    <h5>{{__('company.procurement')}}</h5>
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
                                                    <h5>{{__('company.expectations')}}</h5>
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
                                                    <h5>{{__('company.payment')}}</h5>
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
                                                    <h5>{{__('company.business_repeat')}}</h5>
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
                                                    <h5>{{__('company.overall_rating')}}</h5>
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
                                            <div class="form-group"><label for="message-text" class="col-form-label">{{__('company.display_review_author')}}</label><label class="custom-control custom-radio"><input id="privacy3" name="privacy" value="public" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">{{__('company.display_name')}}</span></label><br><label class="custom-control custom-radio"><input id="privacy4" name="privacy" value="private" type="radio" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">{{__('company.anonymous')}}</span></label></div>
                                            <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{__('company.submit_review')}}</button></div>
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