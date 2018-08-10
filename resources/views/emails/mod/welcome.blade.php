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
							<h1 {{$rtl}}>مرحباً {{$company->company_name}}, اهلا بك في مشاريع.</h1>

							<p {{$rtl}}>هذا هو رابط شركتك: ({{route('front.company.show', $company->slug)}})</p>

							<p {{$rtl}}>بداية الطريق هنا! </p>

							<h3 {{$rtl}}>بعض الطرق التي تمكنك من الإستفادة القصوى من حسابك على مشاريع:</h3>
							<ol {{$rtl}}>
								<li {{$rtl}}>قم بالتسجيل لتحصل علي شركتك و توثقها لدينا.</li>
								<li {{$rtl}}>استكمل بيانات شركتك.</li>
								<li {{$rtl}}>تصفح فرص المشاريع في مجال عملك.</li>
								<li {{$rtl}}>قم بانشاء مشاريع جديدة و احصل علي موردين.</li>
							</ol>

							<p {{$rtl}}>
							شكراً,
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
        	<a href="https://www.masharee3.com/" title="">https://www.masharee3.com</a><br>
            &copy; {{ date('Y') }} Cloud Concept DMCC. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
