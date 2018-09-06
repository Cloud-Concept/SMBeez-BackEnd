<div id="search" class="cd-main-search">
    <form action="{{route('search.all')}}" role="search" method="get">
    	<input type="search" name="s" value="{{request()->query('s')}}" placeholder="{{__('general.search_placeholder')}}">
    </form>
    <a href="#" class="close cd-text-replace">Close Form</a>
</div>