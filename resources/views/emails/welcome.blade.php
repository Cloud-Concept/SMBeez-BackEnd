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

							<p {{$rtl}}>مبروك! تم فتح حسابك على مشاريع. <!-- من فضلك إضغط على الرابط أدناه للتحقق من عنوان بريدك الإلكتروني. --> </p>

							<p {{$rtl}}>بداية الطريق هنا! </p>

							<h3 {{$rtl}}>بعض الطرق التي تمكنك من الإستفادة القصوى من حسابك على مشاريع:</h3>
							<ul {{$rtl}}>
								<li {{$rtl}}>تصفح فرص المشاريع في مجال عملك</li>
								<li {{$rtl}}>أنشر مشروع جديد واحصل على ١٠٠ نقطة</li>
								<li {{$rtl}}>عبر عن تقييمك لشركة وأحصل على ٢٥ نقطة</li>
								<li {{$rtl}}>طالب بشركة</li>
							</ul>

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
        	<a href="https://www.masharee3.com/" title="">https://www.masharee3.com</a><br>
            &copy; {{ date('Y') }} Cloud Concept DMCC. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
