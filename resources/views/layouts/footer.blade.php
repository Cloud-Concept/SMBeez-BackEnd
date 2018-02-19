<footer class="footer">
    <div class="container-fluid">
        <div class="row px-4">
            <div class="col-md-9">
                <h6 class="mb-3">What is SMBeez</h6>
                <p>SMBeez is your local online marketplace for small and medium companies keen to do business with you. Source project opportunities and find reliable suppliers easily from the comfort of your office. Confidently do business with trusted... <a href="">more</a></p>
            </div>
            <div class="col-md-3">
                @if(Auth::guest())
                <h6 class="mb-3">Stay in touch</h6>
                <form action="" class="newsletter">
                    <div class="input-group"><input type="text" class="form-control" placeholder="E-mail" aria-label="E-mail"> <span class="input-group-btn"><button class="btn btn-blue btn-yellow" type="button"><i class="fa fa-check" aria-hidden="true"></i></button></span></div>
                </form>
                @endif
            </div>
            <div class="col-md-3">
                <h6>Links</h6>
                <ul>
                    <li><a href="#">About</a></li>
                    <li><a href="{{route('login')}}">Sign Up</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Listing</h6>
                <ul>
                    <li><a href="{{route('front.company.all')}}">Companies</a></li>
                    <li><a href="{{route('front.industry.index')}}">Opportunities</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Opportunities</h6>
                <ul>
                	@foreach($industries as $industry)
                    <li><a href="{{route('front.industry.show', $industry->slug)}}">{{$industry->industry_name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Locations</h6>
                <ul>
                    <li><a href="{{route('front.industry.index')}}">Dubai</a></li>
                </ul>
            </div>
            <div class="col-md-12">
                <p>Made by Cloud Concept © 2018 - All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>
<div id="search" class="cd-main-search">
    <form><input type="search" placeholder="Search..."></form>
    <a href="#" class="close cd-text-replace">Close Form</a>
</div>
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