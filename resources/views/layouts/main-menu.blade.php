<ul class="cd-main-nav">
    <li><a href="{{route('front.company.all')}}" class="{{ Request::is('companies/all') ? 'active' : 'no' }}">Companies</a></li>
    <li class="nav-item dropdown">
        <a class="nav-link {{ Request::is('industries/*') ? 'active' : 'no' }}" href="{{route('front.industry.index')}}">Opportunities</a>
    </li>
    <li class="no-effect">
        <a href="#"><span class="flag-icon flag-icon-ae"></span> Dubai</a>
    </li>
    @if (Auth::guest())
    <li class="btn-menu"><a href="{{ route('login') }}">Sign in</a></li>
    @else
    <li class="nav-item dropdown usernav">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(Auth::user()->profile_pic_url)
                <img src="{{asset(Auth::user()->profile_pic_url)}}">
            @else
                <img width="48" height="48" src="{{asset('images/common/user.svg')}}">
            @endif 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @if(\Laratrust::hasRole('admin|superadmin'))
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
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