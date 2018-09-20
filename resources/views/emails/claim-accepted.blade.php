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
	                    	<?php $rtl = 'style=text-align:right!important;'; ?>
	                        <h1 {{$rtl}}>مرحباً</h1>

							<p {{$rtl}}>شكراً على مطالبتك بشركة <a href="{{route('front.company.show', $company->slug)}}?utm_source=newsletter&utm_medium=email&utm_campaign=call_center">"{{$company->company_name}}"</a>. يسعدنا أن نعلمك بأنه تم الموافقة على طلبك. أدخل على رابط شركتك لإكمال البروفايل: <a href="{{route('front.company.show', $company->slug)}}?utm_source=newsletter&utm_medium=email&utm_campaign=call_center">"{{$company->company_name}}"</a></p>

							<p {{$rtl}}>مرحباً في مشاريع!</p>
							
							<p {{$rtl}}>
							لقد ربحت ١٠٠ نقطة في حسابك! أنشر مشروع جديد وأحصل على ١٠٠ نقطة أخرى!
							</p>

							<p {{$rtl}}>
							أصدقاءك في مشاريع
							</p>
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
            &copy; {{ date('Y') }} Cloud Concept DMCC. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
