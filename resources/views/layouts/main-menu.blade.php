<ul class="cd-main-nav">
    <li><a href="{{route('front.company.all')}}" class="{{ Request::is('companies/all') ? 'active' : 'no' }}">{{__('general.menu_companies')}}</a></li>
    <li class="nav-item dropdown">
        <a class="nav-link {{ Request::is('industries/*') ? 'active' : 'no' }}" href="{{route('front.industry.index')}}">{{__('general.menu_opportunities')}}</a>
    </li>
    @if(app()->getLocale() == 'en')
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{route('change.lang', 'ar')}}">Arabic</a>
        </li>
    @else
        <li class="nav-item dropdown">
            <a class="nav-link" href="{{route('change.lang', 'en')}}">English</a>
        </li>
    @endif
    <li class="no-effect">
        <a href="#"><span class="flag-icon flag-icon-eg"></span> {{__('footer.cairo')}}</a>
    </li>
    @if (Auth::guest())
    <li class="btn-menu"><a href="{{ route('login') }}">{{__('general.sign_in')}}</a></li>
    @else
    <li class="nav-item dropdown usernav">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Auth::user()->profile_pic_url && file_exists(public_path('/') . Auth::user()->profile_pic_url))
                <img src="{{asset(Auth::user()->profile_pic_url)}}">
            @else
                <img width="48" height="48" src="{{asset('images/common/user.svg')}}">
            @endif 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @if(\Laratrust::hasRole('administrator|superadmin'))
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
            @elseif(\Laratrust::hasRole('moderator'))
            <a class="dropdown-item" href="{{ route('moderator.companies.dashboard') }}">Dashboard</a>
            @else
            <a class="dropdown-item" href="{{ route('front.user.dashboard', Auth::user()->username) }}">Dashboard</a>
            @endif
            <a class="dropdown-item" href="{{ route('front.user.profile', Auth::user()->username) }}">Profile</a>
            @if($hascompany)
            <a class="dropdown-item" href="{{ route('front.company.show', $mycompany->slug) }}">My Company</a>
            @endif
            @if(Auth::user()->reviews->count() > 0)
            <a class="dropdown-item" href="{{route('front.user.reviews', Auth::user()->username)}}">My Reviews</a>
            @endif
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
    @endif
</ul>