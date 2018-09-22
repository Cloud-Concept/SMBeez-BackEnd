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
	                        <h1 {{$rtl}}>مرحباً في مشاريع.</h1>

	                        <p {{$rtl}}>البريد الالكتروني: {{$user->email}}</p>
							<p {{$rtl}}>كلمة السر: {{$unique_password}}</p>
							<p {{$rtl}}>رابط تسجيل الدخول: <a href="http://www.masharee3.com/login?utm_source=newsletter&utm_medium=email&utm_campaign=call_center">http://www.masharee3.com/login</a></p>
							<p {{$rtl}}>رابط شركتك: ({{route('front.company.show', $user->company->slug)}})</p>
							
							<p {{$rtl}}>ماذا بعد؟ </p>

							<h3 {{$rtl}}>بعض الطرق التي تمكنك من الإستفادة القصوى من حسابك على مشاريع:</h3>
							<ol {{$rtl}}>
								<li {{$rtl}}>اكمل بروفايل شركتك</li>
								<li {{$rtl}}>تصفح فرص المشاريع في مجال عملك</li>
								<li {{$rtl}}>أنشر مشروع جديد واحصل على ١٠٠ نقطة</li>
							</ol>

							<p {{$rtl}}>
							شكراً
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
