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
                        <h5 class="title-blue">{{__('company.updates')}} ({{$user->messages->count()}})</h5>
                        <ul class="list-group">
                            @if($user->messages->count() > 0)
                                @foreach($user_messages as $message)
                                    <li class="list-group-item">
                                        @if($message->interest_id)
                                            @if($message->message_company_exists($message->sender_id))
                                            <a href="{{route('front.messages.show', $message->id)}}">
                                                {{$message->created_at->diffForHumans()}} :
                                                {{strip_tags($message->subject, '')}}
                                            </a>
                                            @else
                                            <p>{{__('company.sender_no_exist')}}</p>
                                            @endif
                                        @else
                                            {{strip_tags($message->subject, '')}}
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">{{__('company.no_msgs')}}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">{{__('general.my_dashboard')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('company.msgs')}}</li>
                        </ol>
                    </nav>
                    <div class="row equal infinite-scroll">
                    @if($user->messages->count() > 0)
                        @foreach($user_messages as $message)
                            @if($message->message_company_exists($message->sender_id))
                                <div id="message-{{$message->interest_id}}" class="message-block">
                                    <div class="message-intro my-3">
                                        <p class="tags"><b><i>{{__('company.subject')}}</i>:</b> {!!$message->subject!!}</p>
                                        <p class="tags"><b><i>{{__('company.date')}}</i>:</b> <span>{{$message->created_at->diffForHumans()}}</span></p>
                                        @if(!is_null($message->interest_id))
                                            <div class="btn-list mt-3 mb-4">
                                                @if($message->interest_status($message->interest_id) === 1)
                                                    <p>{{__('company.accepted')}}</p>
                                                @elseif($message->interest_status($message->interest_id) === 0)
                                                    <p>{{__('company.declined')}}</p>
                                                @elseif($message->interest_status($message->interest_id) === false)
                                                    <p>{{__('company.interest_withdrawn')}}</p>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('accept-interest-{{$message->interest_id}}').submit();">{{__('company.accept')}}</button>
                                                    <!-- <button type="submit" class="btn btn-sm btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('decline-interest-{{$message->interest_id}}').submit();">{{__('company.decline')}}</button> -->
                                                    {{__('home.or_title')}}
                                                    <br>
                                                    <br>
                                                    <form id="decline-interest-{{$message->interest_id}}" action="{{route('decline.interest', $message->interest_id)}}" method="post" class="write-review compnay-edit">
                                                        {{csrf_field()}}
                                                        <select id="decline-select" class="form-control custom-select d-block" name="decline_reason" onchange="event.preventDefault(); document.getElementById('decline-interest-{{$message->interest_id}}').submit();">
                                                            <option>{{__('company.choose_rej_reason')}}</option>
                                                            @foreach($rejection_reasons as $reason)
                                                                <option value="{{$reason}}">{{$reason}}</option>
                                                            @endforeach
                                                        </select>
                                                    </form>
                                                    <form id="accept-interest-{{$message->interest_id}}" action="{{route('accept.interest', $message->interest_id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form> 
                                                    <!-- <form id="decline-interest-{{$message->interest_id}}" action="{{route('decline.interest', $message->interest_id)}}" method="post" class="write-review">
                                                        {{csrf_field()}}
                                                    </form> -->
                                                @endif
                                            </div>
                                        @endif
                                        
                                    </div>
                                    <div class="message-interest mb-5">
                                        {!!$message->message!!}
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                        {{$user_messages->links()}}
                    @else
                        <p>{{__('company.no_msgs')}}</p>
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