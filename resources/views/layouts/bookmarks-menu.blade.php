<ul class="list-group">
    <li class="list-group-item"><a href="{{route('front.bookmarks.listcompanies')}}" class="{{ Request::is('user/bookmarks/companies') ? 'active' : 'no' }}">{{__('general.menu_companies')}}</a></li>
    <li class="list-group-item"><a href="{{route('front.bookmarks.listopportunities')}}" class="{{ Request::is('user/bookmarks/opportunities') ? 'active' : 'no' }}">{{__('general.menu_opportunities')}}</a></li>
</ul>