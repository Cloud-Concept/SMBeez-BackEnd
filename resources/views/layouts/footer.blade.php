<footer class="footer">
    <div class="container-fluid">
        <div class="row px-4">
            <div class="col-md-9">
                <h6 class="mb-3">{{__('footer.what_masharee3')}}</h6>
                <p>{{__('footer.what_masharee3_desc')}}</p>
            </div>
            <div class="col-md-3">
                @if(Auth::guest())
                <h6 class="mb-3">{{__('footer.stay_in_touch')}}</h6>
                <form action="" class="newsletter">
                    <div class="input-group"><input type="text" class="form-control" placeholder="E-mail" aria-label="E-mail"> <span class="input-group-btn"><button class="btn btn-blue btn-yellow" type="button"><i class="fa fa-check" aria-hidden="true"></i></button></span></div>
                </form>
                @endif
            </div>
            <div class="col-md-3">
                <h6>Links</h6>
                <ul>
                    <li><a href="{{route('about')}}">{{__('footer.about')}}</a></li>
                    <li><a href="{{route('login')}}">{{__('footer.sign_up')}}</a></li>
                    <li><a href="#">{{__('footer.terms')}}</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>{{__('footer.listing')}}</h6>
                <ul>
                    <li><a href="{{route('front.company.all')}}">{{__('footer.companies')}}</a></li>
                    <li><a href="{{route('front.industry.index')}}">{{__('footer.opportunities')}}</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>{{__('footer.opportunities')}}</h6>
                <ul>
                	@foreach($industries as $industry)
                    <li><a href="{{route('front.industry.show', $industry->slug)}}">
                        @if(app()->getLocale() == 'ar')
                        {{$industry->industry_name_ar}}
                        @else
                        {{$industry->industry_name}}
                        @endif
                    </a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h6>{{__('footer.locations')}}</h6>
                <ul>
                    <li class="no-effect"><a href="#">{{__('footer.cairo')}}</a></li>
                </ul>
            </div>
            <div class="col-md-12">
                <p>Made by Masharee3 © 2018 - All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>
@include('layouts.search-form')
<style>
.pagination span {
    padding: 5px 10px;
    border: 0;
    border-radius: 0;
    font-weight: 700;
    text-decoration: none;
    background: #40508e;
    color: #ffe100;
}
</style>