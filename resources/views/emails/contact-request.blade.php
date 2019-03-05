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


	                        Company Name: {{$company->company_name}}
	                        <br>
	                        @if($company->location)
	                        Company Location: {{$company->location}}
	                        @endif
	                        <br>
	                        @if($company->company_phone)
	                        Company Phone: {{$company->company_phone}}
	                        @endif
	                        <br>
	                        @if($company->company_website)
	                        Company Website: {{$company->company_website}}
	                        @endif
	                        <br>
	                        @if($company->company_email)
	                        Company Email: {{$company->company_email}}
	                        @endif
	                        <br>
	                        @if($company->linkedin_url)
	                        Company Linkedin: {{$company->linkedin_url}}
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
