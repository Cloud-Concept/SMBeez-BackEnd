<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <h6>{{__('footer.links')}}</h6>
                <ul>
                    <li><a href="{{route('about')}}">{{__('footer.about')}}</a></li>
                    <li><a href="{{route('login')}}">{{__('footer.sign_up')}}</a></li>
                    <li><a href="{{route('privacy')}}">{{__('footer.terms')}}</a></li>
                    <li><a href="{{route('team')}}">{{__('footer.team')}}</a></li>
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
            <div class="col-md-3">
                @if (session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                @else
                    @if(Auth::guest())
                    <h6 class="mb-3">{{__('footer.stay_in_touch')}}</h6>
                    <form action="{{route('subscribe')}}" class="newsletter" method="post">
                        {{csrf_field()}}
                        <div class="input-group"><input type="text" class="form-control" name="email" placeholder="{{__('footer.email_newsletter')}}" aria-label="E-mail"> <span class="input-group-btn"><button class="btn btn-blue btn-yellow" type="submit"><i class="fa fa-check" aria-hidden="true"></i></button></span></div>
                    </form>
                    @else
                    <h6 class="mb-3">{{__('footer.stay_in_touch')}}</h6>
                    <form action="{{route('subscribe')}}" class="newsletter" method="post">
                        {{csrf_field()}}
                        <div class="input-group"><input type="text" class="form-control" name="email" placeholder="{{__('footer.email_newsletter')}}" aria-label="E-mail" value="{{Auth::user()->email}}"> <span class="input-group-btn"><button class="btn btn-blue btn-yellow" type="submit"><i class="fa fa-check" aria-hidden="true"></i></button></span></div>
                    </form>
                    @endif
                @endif
                <ul class="footer-social">
                  <li><a href="https://www.linkedin.com/company/masharee3/" target="_blank"><i class="fa fa-2x fa-linkedin-square" aria-hidden="true"></i></a></li>
                  <li><a href="https://www.facebook.com/Masharee3.EG" target="_blank"><i class="fa fa-2x fa-facebook-square" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="col-md-12">
                <p>{{__('footer.copyrights')}}</p>
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