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
	                        <h1 {{$rtl}}>رحباً</h1>

							<p {{$rtl}}>شكراً على مطالبتك بشركة <a href="{{route('front.company.show', $company->slug)}}">"{{$company->company_name}}"</a>.  لم نتمكن من التحقق من دورك في هذه الشركة. قبل أن نوافق على مطالبتك فنحن نحتاج إلى بيانات إضافية.</p>

							<p {{$rtl}}>من فضلك أرسل ما يعزز مطالبتك من الإختيارات التالية:</p>
							
							<p {{$rtl}}>
							إختيار ١: رسالة إلكترونية من صاحب أو مدير الشركة. يجب أن يكون عنوان البريد الإلكتروني من نفس نطاق الشركة ويحتوي على الآتي:
							<ul {{$rtl}}>
								<li {{$rtl}}> إسم وظيفة المدير ورقم هاتفه</li>
								<li {{$rtl}}> اسمك ووظيفتك وعنوان بريدك الإلكتروني الرسمي</li>
								<li {{$rtl}}> عبارة تنص على الموافقة على أن تكون مندوب الشركة على موقع مشاريع </li>
							</ul>
							</p>
							<p {{$rtl}}>
								إختيار ٢: صورة من السجل التجاري والبطاقة الضريبية تحتوي على إسمك كمدير مسؤول أو مندوب عن الشركة.
							</p>
							<p {{$rtl}}>
								من فضلك أرسل هذه المعلومات على عنوان <b>verification@masharee3.com</b>
							</p>
							<p {{$rtl}}>نتطلع للترحيب بك في مشاريع!</p>
							<p {{$rtl}}>أصدقاءك في مشاريع.</p>
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
