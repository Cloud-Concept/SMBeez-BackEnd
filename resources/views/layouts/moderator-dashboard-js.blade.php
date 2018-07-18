<script type="text/javascript">
	$(".edit-company").click(function(e){
		e.preventDefault();

		//Hide notifications
		$('#assign-company-to-user').find('.verify').hide();
	    $('#verified-check').hide();
	    $('.assign-user-alert').removeClass('show').hide();
	    $('.company-update-alert').removeClass('show').hide();


		var company_id = $(this).closest('.company-info').find('.get-info').attr('company-id');
		var url = '{{ route("get-company-ajax", ":company_id") }}';

		$('.company-row.' + company_id).addClass('highlight');

	    $.get(url.replace(':company_id', company_id), function(data, status){
	        $('#edit-company').find('#company_name').val(data.company_name);
	        $('#edit-company').find('#company_email').val(data.company_email);
	        $('#edit-company').find('#company_phone').val(data.company_phone);
	        $('#edit-company').find('#location').val(data.location);
            $('#edit-company').find('#industry_id').val(data.industry_id).attr('selected', 'selected');
	        $('#edit-company').find('.company-name-span').text('(' + data.company_name + ')');
	        $('#edit-company').find('.com-city').text(data.city);
	        $('#edit-company').find('.get-info').val(data.slug);

	        if(data.user != null) {
	        	$('#edit-company').find('#user_email').val(data.user.email);
	    	}else{
	    		$('#edit-company').find('#user_email').val('');
	    	}
	    });
	});

	$(".report-company").click(function(e){
		e.preventDefault();

		//Hide notifications
	    $('.report-alert').removeClass('show').hide();


		var company_id = $(this).closest('.company-info').find('.get-info').attr('company-id');
		var company_name = $(this).closest('.company-info').find('.get-info').attr('company-name');
		var url = '{{ route("get-company-report-ajax", ":company_id") }}';

		$('.company-row.' + company_id).addClass('highlight');

	    $.get(url.replace(':company_id', company_id), function(data, status){
	    	if(data.status) {
	        	$('#report-company').find('#status').val(data.status);
	    	}else {
	    		$('#report-company').find('#status').val('In Queue');
	    	}
	        $('#report-company').find('#feedback').val(data.feedback);
	        $('#report-company').find('.company-name-span').text('(' + company_name + ')');
	        $('#report-company').find('.get-info').val(company_id);	        
	    });
	});

	$(".email-company").click(function(e){
		e.preventDefault();

		//Hide notifications
	    $('.email-alert').removeClass('show').hide();


		var company_id = $(this).closest('.company-info').find('.get-info').attr('company-id');
		var company_name = $(this).closest('.company-info').find('.get-info').attr('company-name');
		var url = '{{ route("get-company-ajax", ":company_id") }}';

		$('.company-row.' + company_id).addClass('highlight');

	    $.get(url.replace(':company_id', company_id), function(data, status){
	        $('#email-company').find('.company-name-span').text('(' + data.company_name + ')');
	        $('#email-company').find('.company-city').text(data.city);
	        $('#email-company').find('.get-info').val(company_id);		        
	    });
	});
</script>

<div class="modal fade modal-fullscreen modal-add-company" id="edit-company" tabindex="-1" role="dialog" aria-labelledby="edit-company" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" aria-label="Close" onclick="event.preventDefault(); if(confirm('Do you really need to close?')){$('#edit-company').modal('hide');}"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Company <span class="company-name-span"></span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>1. Edit Company Details</h2>
                            <div class="alert alert-success alert-green alert-dismissible fade company-update-alert" role="alert">
                                <h3><i class="fa fa-check fa-2x" aria-hidden="true"></i> Saved Successfully</h3>
                            </div>
                            <form class="call-form" id="update-company-form">
                                {{csrf_field()}}
                                <div class="form-group"><input class="form-control" type="text" name="company_name" placeholder="Company Name *" id="company_name" required><label class="custom-control single-label com-city"></label></div>
                                <div class="form-group"><label class="custom-control">Specialities</label>
                                	<input type="text" name="speciality_id" placeholder="Specialities" class="typeahead tm-input form-control tm-input-info"/>
                                    <p class="form-guide">Write your keywords separated with commas</p>
                                </div>
                                <div class="form-group">
                                    <select name="industry_id" id="industry_id" class="form-control custom-select d-block" required>
                                        @foreach($industries as $industry)
                                        <option value="{{$industry->id}}" {{$industry->id == $company->industry->id ? 'selected' : ''}}>{{$industry->industry_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group"><label class="custom-control">Company email</label><input class="form-control" type="email" name="company_email" placeholder="Company Email *" id="company_email" required></div>
                                <div class="form-group"><label class="custom-control">Phone</label><input class="form-control" type="text" name="company_phone" placeholder="Company Phone *" id="company_phone" required></div>
                                <div class="form-group"><label class="custom-control">Company Address</label><input class="form-control" type="text" name="location" placeholder="Company Address *" id="location" required></div>
                                <input type="hidden" class="get-info"/>
                                <input type="hidden" name="mod_user" value="{{Auth()->user()->id}}"/>
                                <button class="btn btn-blue btn-yellow pull-right update-company-submit">Save Details</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h2>2. Assign Company to a User</h2>
                            <div class="alert alert-success alert-green alert-dismissible fade assign-user-alert" role="alert">
                                <h3 class="assign-msg"></h3>
                            </div>
                            <form class="call-form" id="assign-company-to-user" method="post">
                                {{csrf_field()}}
                                
                                <div class="form-group-verify">
                                    <div class="from-group">
                                        <label class="custom-control">Existing User</label>
                                        <div class="input-group"><input type="email" id="user_email" name="user_email" placeholder="User Email" class="form-control" aria-label="User Email" aria-describedby="basic-addon1" required/> <i class="fa fa-check" id="verified-check" style="display:none;" aria-hidden="true"></i></div>
                                    </div>
                                    <div class="from-group mt-3">
                                        <button id="assign-company" class="btn btn-sm btn-yellow-2 pull-left">Assign Company</button>
                                        <p class="verify pull-left ml-3" style="display:none;">( Verified )</p>
                                    </div>
                                </div>
                                <input type="hidden" class="get-info"/>
                                <input type="hidden" name="mod_user" value="{{Auth()->user()->id}}"/>
                            </form>
                            <form class="call-form" id="create-user-form" method="post">
                                {{csrf_field()}}
                                <div class="form-group"><label class="custom-control">New User</label><input type="text" name="first_name" id="first_name" placeholder="First Name *" class="form-control" required/></div>
                                <div class="form-group"><input type="text" name="last_name" id="last_name" placeholder="Last Name *" class="form-control" required/></div>
                                <div class="form-group"><input type="email" name="email" id="email" placeholder="Email Address *" class="form-control" required/></div>
                                <div class="form-group"><input type="text" name="phone" id="phone" placeholder="Phone" class="form-control"/></div>
                                <div class="form-group">
                                    <label class="custom-control">Company Role</label>
                                    <select name="role" class="form-control custom-select d-block" id="role" required>
                                        <option value="Company Owner">Company Owner</option>
                                        <option value="General Manager">General Manager</option>
                                        <option value="Sales and/or Marketing Director">Sales and/or Marketing Director</option>
                                        <option value="Account Manager">Other</option>
                                    </select>
                                </div>
                                <input type="hidden" class="get-info"/>
                                <input type="hidden" name="mod_user" value="{{Auth()->user()->id}}"/>
                                <button class="btn btn-blue btn-yellow pull-right" id="create-user">Create User</button>
                            </form>
                        </div>
                    </div>
                </div>
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

<script>

$(".update-company-submit").click(function(e){
	e.preventDefault();

	var company_id = $(this).closest('#update-company-form').find('.get-info').val();
	var url = '{{ route("update-company-ajax", ":company_id") }}';
	$.post(url.replace(':company_id', company_id),
	{
		company_name: $(this).closest('#update-company-form').find('#company_name').val(),
		company_email: $(this).closest('#update-company-form').find('#company_email').val(),
		company_phone: $(this).closest('#update-company-form').find('#company_phone').val(),
		location: $(this).closest('#update-company-form').find('#location').val(),
        industry_id: $(this).closest('#update-company-form').find('#industry_id').val(),
		specialities: $(this).closest('#update-company-form').find( "input[name='hidden-speciality_id']" ).val(),
        mod_user: $(this).closest('#update-company-form').find( "input[name='mod_user']" ).val(),

	}).done(function( data ) {
	    $('.company-update-alert').addClass('show').show();
	});

});

$("#assign-company").click(function(e){
	e.preventDefault();

	var company_id = $(this).closest('#assign-company-to-user').find('.get-info').val();
	var url = '{{ route("assign-company-ajax", ":company_id") }}';
	$.post(url.replace(':company_id', company_id),
	{
		user_email: $(this).closest('#assign-company-to-user').find('#user_email').val(),
        mod_user: $(this).closest('#assign-company-to-user').find( "input[name='mod_user']" ).val(),

	}).done(function( data ) {
	    $('#assign-company-to-user').find('.verify').show();
	    $('#verified-check').show();
	    $('.assign-msg').html('<i class="fa fa-check fa-2x" aria-hidden="true"></i>' + data.success);
	    $('.assign-user-alert').addClass('show').show();
	});

});

$("#create-user").click(function(e){
	e.preventDefault();

	var company_id = $(this).closest('#create-user-form').find('.get-info').val();
	var url = '{{ route("user-company-ajax", ":company_id") }}';
	$.post(url.replace(':company_id', company_id),
	{
		first_name: $(this).closest('#create-user-form').find('#first_name').val(),
		last_name: $(this).closest('#create-user-form').find('#last_name').val(),
		phone: $(this).closest('#create-user-form').find('#phone').val(),
		email: $(this).closest('#create-user-form').find('#email').val(),
		role: $(this).closest('#create-user-form').find('#role').val(),
        mod_user: $(this).closest('#create-user-form').find( "input[name='mod_user']" ).val(),

	}).done(function( data ) {
	    $('.assign-msg').html('<i class="fa fa-check fa-2x" aria-hidden="true"></i>' + data.msg);
	    $('.assign-msg').after('<p>' + data.data + '</p>');
	    $('.assign-user-alert').addClass('show').show();
	});

});
</script>


<!-- Report Modal -->

<div class="modal fade modal-fullscreen modal-call" id="report-company" tabindex="-1" role="dialog" aria-labelledby="report-company" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" aria-label="Close" onclick="event.preventDefault(); if(confirm('Do you really need to close?')){$('#report-company').modal('hide');}"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title"><i class="fa fa-list" aria-hidden="true"></i> Report <span class="company-name-span"></span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 mrt-auto">
                            <h2>Report Company Status</h2>
                            <div class="alert alert-success alert-green alert-dismissible fade report-alert" role="alert">
                                <h3></h3>
                            </div>
                            <form class="call-form" id="report-company-form">
                            	{{csrf_field()}}
                                <div class="form-group">
                                    <label class="custom-control">Status</label>
                                    <select name="status" id="status" class="custom-select mb-sm-0 w-100">
                                        <option value="In Queue">In Queue</option>
                                        <option value="Successful Call - Interested">Successful Call - Interested</option>
                                        <option value="Successful Call - Not Interested">Successful Call - Not Interested</option>
                                        <option value="Successful Call - Agreed to Call Back">Successful Call - Agreed to Call Back</option>
                                        <option value="Successful Call - Asked for more details via email">Successful Call - Asked for more details via email</option>
                                        <option value="Unsuccessful Call - Unreachable">Unsuccessful Call - Unreachable</option>
                                        <option value="Unsuccessful Call - Wrong number">Unsuccessful Call - Wrong number</option>
                                        <option value="Unsuccessful Call - No answer">Unsuccessful Call - No answer</option>
                                    </select>
                                </div>
                                <div class="form-group"><label class="custom-control">Additional Comments</label><textarea name="feedback" id="feedback" class="form-control" placeholder="Write down a feedback"></textarea></div>
                                <input type="hidden" class="get-info"/>
                                <input type="hidden" name="mod_user" value="{{Auth()->user()->id}}"/>
                                <button class="btn btn-blue btn-yellow pull-right" id="submit-report">Save Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$("#submit-report").click(function(e){
	e.preventDefault();

	var company_id = $(this).closest('#report-company-form').find('.get-info').val();
	var url = '{{ route("create-update-company-report-ajax", ":company_id") }}';
	$.post(url.replace(':company_id', company_id),
	{
		status: $(this).closest('#report-company-form').find('#status').val(),
		feedback: $(this).closest('#report-company-form').find('#feedback').val(),
		company_id: company_id,
        mod_user: $(this).closest('#report-company-form').find( "input[name='mod_user']" ).val(),

	}).done(function( data ) {
	    $('.report-alert h3').html('<i class="fa fa-check fa-2x" aria-hidden="true"></i>' + data.msg);
	    $('.report-alert').addClass('show').show();
	    $('.report-status.' + company_id).text(data.status);
	});

});
</script>

<div class="modal fade modal-fullscreen modal-call" id="email-company" tabindex="-1" role="dialog" aria-labelledby="email-company" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" aria-label="Close" onclick="event.preventDefault(); if(confirm('Do you really need to close?')){$('#email-company').modal('hide');}"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send Message <span class="company-name-span"></span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 mrt-auto">
                            <h2>Send Details Message</h2>
                            <div class="alert alert-success alert-green alert-dismissible fade email-alert" role="alert">
                                <h3></h3>
                            </div>
                            <form id="send-msg-form" class="call-form">
                                <div class="form-group">
                                    <p><b class="company-name-span">Company name</b><br><label class="custom-control single-label company-city"></label></p>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control">Subject</label>
                                    <select id="subject" name="subject" class="custom-select mb-sm-0 w-100" required>
                                        <option>Subject type</option>
                                        <option value="welcome">Welcome Message</option>
                                    </select>
                                </div>
                                <div class="form-group"><label class="custom-control">User Email *</label><input type="text" id="user_email" name="user_email" class="form-control" placeholder="User Email *" required></div>
                                <!-- <div class="form-group"><label class="custom-control">Message Body</label><textarea id="body" name="body" class="form-control" placeholder="Message Body"></textarea></div> -->
                                <input type="hidden" class="get-info"/>
                                <input type="hidden" name="mod_user" value="{{Auth()->user()->id}}"/>
                                <button id="send-message" class="btn btn-blue btn-yellow pull-right">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$("#send-message").click(function(e){
	e.preventDefault();

	var company_id = $(this).closest('#send-msg-form').find('.get-info').val();
	var url = '{{ route("send-mod-msg-ajax", ":company_id") }}';
	$.post(url.replace(':company_id', company_id),
	{
		subject: $(this).closest('#send-msg-form').find('#subject').val(),
		body: $(this).closest('#send-msg-form').find('#body').val(),
		user_email: $(this).closest('#send-msg-form').find('#user_email').val(),
        mod_user: $(this).closest('#send-msg-form').find( "input[name='mod_user']" ).val(),

	}).done(function( data ) {
	    $('.email-alert h3').html('<i class="fa fa-check fa-2x" aria-hidden="true"></i>' + data.msg);
	    $('.email-alert').addClass('show').show();
	});

});
</script>
<style>
	tr.highlight {
		font-weight: 900;
	}
</style>