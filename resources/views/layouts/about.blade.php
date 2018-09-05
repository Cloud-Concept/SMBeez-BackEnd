@extends('layouts.inner')

@section('content')

<main class="cd-main-content">
        
  <section class="featured-block text-center pt-5 gray-bg">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row justify-content-md-center">
            <div class="col-md-9 align-self-center mb-5">
              <h2>ماهو مشاريع.كوم</h2>
              <p class="pt-5">مشاريع هو بوابتك التي تساعدك أن توسع حجم أعمالك وتقدم على فرص المشاريع التي تناسب شركتك بكل سهولة. لو أنت تبحث عن فرص لمشاريع فالموقع يقدم لك مشاريع عديدة في مجالات مختلفة. ولو أنت عندك مشروع وتبحث عن موردين موثوق فيهم فالموقع يقدم لك أكثر من ٩٠٠٠ مورد يمكنك التحقق من مستوى خدماتهم والإتصال بهم بكل سهولة.</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xs-12 mb-5 offset-md-3 text-center">
          <a href="{{route('front.industry.index')}}" class="btn btn-blue">تصفح المشاريع</a>
          <a href="{{route('front.company.all')}}" class="btn btn-blue">تصفح الشركات</a>
        </div>
      </div>
    </div>
  </section>
  <section class="mt-5 mb-5 featured-block text-center mt-5 pt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 d-flex">
          <div class="box-block-into box-gray mb-5 p-5">
            <img src="images/media/block-01.svg" alt="" class="img-height img-responsive mb-3">
            <h3>أضف مشاريعك</h3>
            <p class="mt-3">تصفح آلاف الموردين الموثوق فيهم في مجالات مختلفة. تواصل مع الموردين عن طريق الموقع أو مباشرة معهم. تصفح آراء العملاء في الموردين وتعامل معهم بثقة.</p>
          </div>
        </div>
        <div class="col-md-4 d-flex">
          <div class="box-block-into box-gray mb-5 p-5">
            <img src="images/media/block-02.svg" alt="" class="img-height img-responsive mb-3">
            <h3>إبحث عن موردين</h3>
            <p class="mt-3">إخلق بروفايل لشركتك وتواصل مع آلاف الموردين الموثوق بهم في مجالات عديدة. إتصل بالموردين عن طريق الموقع أو مباشرةً. تصفح رأي عملاء مثلك في الموردين وتعاقد مع أفضلهم بثقة وشفافية.</p>
          </div>
        </div>
        <div class="col-md-4 d-flex">
          <div class="box-block-into box-gray mb-5 p-5">
            <img src="images/media/block-03.svg" alt="" class="img-height img-responsive mb-3">
            <h3>سجل شركتك</h3>
            <p class="mt-3">ولو أنت عندك مشروع وتبحث عن موردين موثوق فيهم فالموقع يقدم لك أكثر من ٩٠٠٠ مورد يمكنك التحقق من مستوى خدماتهم والإتصال بهم بكل سهولة</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>


@endsection