@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        
    @endslot

    <table class="panel" width="100%" cellpadding="0" cellspacing="0" style="direction:rtl" direction="rtl">
	    <tr>
    		<td><img src="https://www.masharee3.com/images/common/email-header.png" style="width:100%;height:auto;"/></td>
    	</tr>
	    <tr>
	        <td class="panel-content">
	            <table width="100%" cellpadding="0" cellspacing="0">
	                <tr>
	                    <td class="panel-item">
	                        <h1>Hello,</h1>


	                        Company Name: {{$company_name}}
	                        <br>
	                        @if($location)
	                        Company Location: {{$location}}
	                        @endif
	                        <br>
	                        @if($company_phone)
	                        Company Phone: {{$company_phone}}
	                        @endif
	                        <br>
	                        @if($company_website)
	                        Company Website: {{$company_website}}
	                        @endif
	                        <br>
	                        @if($company_email)
	                        Company Email: {{$company_email}}
	                        @endif
	                        <br>
	                        @if($linkedin_url)
	                        Company Linkedin: {{$linkedin_url}}
	                        @endif
	                        <br>
	                    </td>
	                </tr>
	            </table>
	        </td>
	    </tr>
	</table>

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
        	<a href="https://www.masharee3.com?utm_source=newsletter&utm_medium=email&utm_campaign=call_center" title="">https://www.masharee3.com</a><br>
            &copy; {{ date('Y') }} masharee3.com. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
