@extends('layouts.inner')

@section('content')
<nav class="dashboard-nav navbar navbar-expand-lg">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars" aria-hidden="true"></i></button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent2">
        @include ('layouts.dashboard-menu')
    </div>
</nav>
<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar-updates">
                        <h5 class="title-blue">{{__('general.my_bookmarks')}}</h5>
                        @include('layouts.bookmarks-menu')
                    </div>
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', Auth::user()->username)}}">{{__('general.my_dashboard')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('general.my_bookmarks')}}</li>
                        </ol>
                    </nav>
                    <div class="bookmarks-block">
                        @if($bookmarked_projects->count() > 0)
                        <h4 id="bookmarked_projects">{{__('general.bookmarked_opportunities')}}</h4>
                        <div class="row equal mb-5">

                            @foreach($bookmarked_projects as $bookmark)
                            <div id="bookmark-box-{{$bookmark->id}}" class="col-md-6">
                                <div class="project-box box-block">
                                    <a href="#" id="unbookmark-b-{{$bookmark->id}}" onclick="event.preventDefault();"><i class="fa fa-bookmark" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Remove from your Favorites"></i></a>
                                    <p class="thumb-title mt-1 mb-1"><a href="{{route('front.project.show', $bookmark->bookmarked_projects($bookmark->bookmarked_id)->slug)}}">{{$bookmark->bookmarked_projects($bookmark->bookmarked_id)->project_title}}</a></p>
                                    <p>{{strip_tags(substr($bookmark->bookmarked_projects($bookmark->bookmarked_id)->project_description, 0, 100))}}</p>
                                    <p class="tags">{{__('general.more_in')}} <a href="{{route('front.industry.show', $bookmark->bookmarked_projects($bookmark->bookmarked_id)->industries[0]->slug)}}">{{$bookmark->bookmarked_projects($bookmark->bookmarked_id)->industries[0]->industry_name}}</a></p>
                                </div>
                            </div>
                            <form id="unbookmark-{{$bookmark->id}}" action="#">
                                <input id="token-unbookmark-{{$bookmark->id}}" value="{{csrf_token()}}" type="hidden">
                            </form>
                            <script>
                                $(document).ready(function(){
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    //unbookmark
                                    $('#unbookmark-b-{{$bookmark->id}}').on('click', function(e){
                                        e.preventDefault();
                                        var token = $('#token-unbookmark-{{$bookmark->id}}').val();
                                        $.ajax({
                                            type: "POST",
                                            data: "_token=" + token,
                                            url: "{{route('bookmark.remove', $bookmark->id)}}",
                                            success: function(data) {
                                                $('#bookmark-box-{{$bookmark->id}}').remove();
                                            }
                                        });
                                    });
                                });
                            </script>
                            <style>
                                .hidden {
                                    display: none!important;
                                }
                            </style>
                            @endforeach
                        </div>
                        @endif

                        @if($bookmarked_projects->count() == 0 && $bookmarked_companies->count() == 0)
                            <p>You didn't save any companies or opportunities to your favorites yet.</p>
                        @endif
                    </div>
                    <!-- <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <h3><i class="fa fa-thumb-tack fa-rotate-45" aria-hidden="true"></i> Tips</h3>
                        <p>As conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the host to your journey; without Her we could not find the unfolding adventures that attract and feed our souls</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</main>

@if($hascompany)
    @include ('layouts.create-project-modal')
@else
    @include ('layouts.add-company-modal')
@endif

@endsection