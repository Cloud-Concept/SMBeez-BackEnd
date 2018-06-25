@extends('layouts.inner')

@section('content')
<main class="cd-main-content">
    <section class="hero-company">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Browse hundreds of Masharee3</h1>
                    <p class="text-center">In your local marketplace</p>
                    @if (!Auth::guest() && !$hasCompany && !count(Auth::user()->claims) > 0)
                    <div class="btn-hero text-center"><a href="#" data-toggle="modal" data-target="#add-company" class="btn btn-blue">Add your company</a></div>
                    @elseif(Auth::guest())
                    <div class="btn-hero text-center"><a href="{{route('login')}}?action=add-company" class="btn btn-blue">Add your company</a></div>
                    @elseif (!Auth::guest() && $hasCompany || count(Auth::user()->claims) > 0)
                    <div class="btn-hero text-center"><a href="{{route('front.user.dashboard', Auth::user()->username)}}" class="btn btn-blue">Go to my dashboard</a></div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="list-project">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include ('layouts.filter-sidebar-companies')
                </div>
                <div class="col-md-8">
                    <div class="row equal">
                        @foreach($featured_companies as $company)
                        <div class="col-md-6">
                            <div class="company-box box-block mb-5">
                                @if($company->cover_url && file_exists(public_path('/') . $company->cover_url))
                                <div>
                                <img class="img-responsive" src="{{asset($company->cover_url)}}" alt="{{$company->company_name}}">
                                </div>
                                @endif
                                <div class="company-box-header media mt-4">
                                    <a href="{{route('front.company.show', $company->slug)}}" class="mr-3 thumb-int"> {{substr($company->company_name, 0, 1)}} </a>
                                    <div class="media-body">
                                        <a href="{{route('front.company.show', $company->slug)}}"><p class="thumb-title mt-1 mb-1">{{$company->company_name}}</p></a>
                                        @if($company->reviews->count() > 0)
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <select class="star-rating-ro">
                                                        @for($i = 0; $i <= 5; $i++)
                                                        <option value="{{$i}}" {{$i == $company->company_overall_rating($company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </li>
                                                <li class="list-inline-item thumb-review"><p>({{$company->reviews->count()}} Reviews)</p></li>
                                            </ul>
                                        </div>
                                        @else
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <select class="star-rating-ro">
                                                        @for($i = 0; $i <= 5; $i++)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </li>
                                                <li class="list-inline-item thumb-review"><a href="{{route('front.company.show', $company->slug)}}">({{$company->reviews->count()}} Reviews)</a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                    @if(!Auth::guest() && $company->user_id != 0 && !$company->is_owner(Auth::user()->id))
                                        @if(!$company->bookmarked($company->id))
                                            <a href="#" id="bookmark-b-{{$company->id}}" class="more-inf" onclick="event.preventDefault();"><i class="fa fa-bookmark-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Add to your Favorites"></i></a>
                                            <a href="#" id="unbookmark-b-{{$company->id}}" class="more-inf" style="display:none" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                                        @else
                                            <a href="#" id="unbookmark-b-{{$company->id}}" class="more-inf" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                                            <a href="#" id="bookmark-b-{{$company->id}}" class="more-inf" style="display:none" onclick="event.preventDefault();"><i class="fa fa-bookmark-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Add to your Favorites"></i></a>
                                        @endif
                                    @endif
                                </div>
                                <p>{{strip_tags(substr($company->company_description, 0, 180))}}...</p>
                                <p class="tags">More in: 
                                    <a href="{{route('front.company.showindustry', $company->industry->slug)}}">{{$company->industry->industry_name}}</a>
                                </p>
                                @if($company->specialities->count() > 0)
                                <p class="tags"><b>Specialities:</b>
                                    @foreach($company->specialities as $speciality)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{$speciality->speciality_name}} 
                                    @endforeach
                                </p>
                                @endif
                            </div>
                            @if(!Auth::guest() && $company->user_id != 0 && !$company->is_owner(Auth::user()->id))
                            <form id="bookmark-{{$company->id}}" action="#">
                                <input id="token-bookmark-{{$company->id}}" value="{{csrf_token()}}" type="hidden">
                                <input type="hidden" id="bookmarked_id-{{$company->id}}" name="bookmarked_id" value="{{$company->id}}"/>
                                <input type="hidden" id="bookmark_type-{{$company->id}}" name="bookmark_type" value="App\Company"/>
                            </form>
                            <form id="unbookmark-{{$company->id}}" action="#">
                                <input id="token-unbookmark-{{$company->id}}" value="{{csrf_token()}}" type="hidden">
                                <input type="hidden" id="unbookmarked_id-{{$company->id}}" name="bookmarked_id" value="{{$company->id}}"/>
                                <input type="hidden" id="unbookmark_type-{{$company->id}}" name="bookmark_type" value="App\Company"/>
                            </form>
                            <script>
                                $(document).ready(function(){
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    var new_bookmarkid = '{{$company->bookmark($company->id)}}';
                                    //bookmark company
                                    $('#bookmark-b-{{$company->id}}').on('click', function(e){
                                        e.preventDefault();
                                        var token = $('#token-bookmark-{{$company->id}}').val();
                                        var bookmark_type = $('#bookmark_type-{{$company->id}}').val();
                                        var bookmark_id = $('#bookmarked_id-{{$company->id}}').val();
                                        $.ajax({
                                            type: "POST",
                                            data: "bookmarked_id=" + bookmark_id + "&bookmark_type=" + bookmark_type + "&_token=" + token,
                                            dataType: 'json',
                                            url: "{{route('bookmark.add')}}",
                                            success: function(data) {
                                                $('#unbookmark-b-{{$company->id}}').show();
                                                $('#bookmark-b-{{$company->id}}').hide();
                                                new_bookmarkid = data.id;
                                            }
                                        });
                                    });
                                    
                                    $('#unbookmark-b-{{$company->id}}').on('click', function(e){
                                        e.preventDefault();
                                        var token = $('#token-unbookmark-{{$company->id}}').val();
                                        var url = '{{ route("bookmark.remove", ":new_bookmarkid") }}';
                                        $.ajax({
                                            type: "POST",
                                            data: "_token=" + token,
                                            url: url.replace(':new_bookmarkid', new_bookmarkid),
                                            success: function(data) {
                                                $('#unbookmark-b-{{$company->id}}').hide();
                                                $('#bookmark-b-{{$company->id}}').show();
                                            }
                                        });
                                    });
                                });
                            </script>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="row equal infinite-scroll">
                        @if($companies->count() == 0)
                        <div class="col-md-12 mt-5">
                            <p>No companies found.</p>
                        </div>
                        @endif
                        @foreach($companies as $company)
                        <div class="col-md-12 mt-2">
                            <div class="company-box company-box-side box-block mb-5">
                                <div class="company-box-header media">
                                    <a href="{{route('front.company.show', $company->slug)}}" class="mr-3 thumb-int"> {{substr($company->company_name, 0, 1)}} </a>
                                    <div class="media-body">
                                        <a href="{{route('front.company.show', $company->slug)}}"><p class="thumb-title mt-1 mb-1">{{$company->company_name}}</p></a>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <select class="star-rating-ro">
                                                        @for($i = 0; $i <= 5; $i++)
                                                        <option value="{{$i}}" {{$i == $company->company_overall_rating($company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                        @endfor
                                                    </select>
                                                </li>
                                                <li class="list-inline-item thumb-review"><p>({{$company->reviews->count()}} Reviews)</p></li>
                                            </ul>
                                        </div>
                                    </div>
                                    @if(!Auth::guest() && $company->user_id != 0 && !$company->is_owner(Auth::user()->id))
                                        @if(!$company->bookmarked($company->id))
                                            <a href="#" id="bookmark-b-{{$company->id}}" class="more-inf" onclick="event.preventDefault();"><i class="fa fa-bookmark-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Add to your Favorites"></i></a>
                                            <a href="#" id="unbookmark-b-{{$company->id}}" class="more-inf" style="display:none" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                                        @else
                                            <a href="#" id="unbookmark-b-{{$company->id}}" class="more-inf" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                                            <a href="#" id="bookmark-b-{{$company->id}}" class="more-inf" style="display:none" onclick="event.preventDefault();"><i class="fa fa-bookmark-o" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Add to your Favorites"></i></a>
                                        @endif
                                    @endif
                                </div>
                                <p>
                                @if($company->company_description)
                                {{strip_tags(substr($company->company_description, 0, 250))}}...
                                <br>
                                @endif
                                {{strip_tags(substr($company->location, 0, 55))}}
                                </p>
                                <p class="tags">More in:
                                    <a href="{{route('front.company.showindustry', $company->industry->slug)}}">{{$company->industry->industry_name}}</a>
                                </p>
                                @if($company->specialities->count() > 0)
                                <p class="tags"><b>Specialities:</b> 
                                    @foreach($company->specialities as $speciality)
                                        {{ $loop->first ? '' : ', ' }}
                                        {{$speciality->speciality_name}} 
                                    @endforeach
                                </p>
                                @endif
                            </div>
                            @if(!Auth::guest() && $company->user_id != 0 && !$company->is_owner(Auth::user()->id))
                            <form id="bookmark-{{$company->id}}" action="#">
                                <input id="token-bookmark-{{$company->id}}" value="{{csrf_token()}}" type="hidden">
                                <input type="hidden" id="bookmarked_id-{{$company->id}}" name="bookmarked_id" value="{{$company->id}}"/>
                                <input type="hidden" id="bookmark_type-{{$company->id}}" name="bookmark_type" value="App\Company"/>
                            </form>
                            <form id="unbookmark-{{$company->id}}" action="#">
                                <input id="token-unbookmark-{{$company->id}}" value="{{csrf_token()}}" type="hidden">
                                <input type="hidden" id="unbookmarked_id-{{$company->id}}" name="bookmarked_id" value="{{$company->id}}"/>
                                <input type="hidden" id="unbookmark_type-{{$company->id}}" name="bookmark_type" value="App\Company"/>
                            </form>
                            <script>
                                $(document).ready(function(){
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    var new_bookmarkid = '{{$company->bookmark($company->id)}}';
                                    //bookmark company
                                    $('#bookmark-b-{{$company->id}}').on('click', function(e){
                                        e.preventDefault();
                                        var token = $('#token-bookmark-{{$company->id}}').val();
                                        var bookmark_type = $('#bookmark_type-{{$company->id}}').val();
                                        var bookmark_id = $('#bookmarked_id-{{$company->id}}').val();
                                        $.ajax({
                                            type: "POST",
                                            data: "bookmarked_id=" + bookmark_id + "&bookmark_type=" + bookmark_type + "&_token=" + token,
                                            dataType: 'json',
                                            url: "{{route('bookmark.add')}}",
                                            success: function(data) {
                                                $('#unbookmark-b-{{$company->id}}').show();
                                                $('#bookmark-b-{{$company->id}}').hide();
                                                new_bookmarkid = data.id;
                                            }
                                        });
                                    });
                                    
                                    $('#unbookmark-b-{{$company->id}}').on('click', function(e){
                                        e.preventDefault();
                                        var token = $('#token-unbookmark-{{$company->id}}').val();
                                        var url = '{{ route("bookmark.remove", ":new_bookmarkid") }}';
                                        $.ajax({
                                            type: "POST",
                                            data: "_token=" + token,
                                            url: url.replace(':new_bookmarkid', new_bookmarkid),
                                            success: function(data) {
                                                $('#unbookmark-b-{{$company->id}}').hide();
                                                $('#bookmark-b-{{$company->id}}').show();
                                            }
                                        });
                                    });
                                });
                            </script>
                            @endif
                        </div>
                        @endforeach

                        {{$companies->appends(['specialities' => request()->input('specialities'), 'industry' => request()->input('industry')])->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include ('layouts.add-company-modal')

@endsection