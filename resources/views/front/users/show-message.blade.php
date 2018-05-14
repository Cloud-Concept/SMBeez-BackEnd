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
                        <h5 class="title-blue">Updates ({{$user->messages->count()}})</h5>
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
                                            <p>Sender doesn't exist anymore</p>
                                            @endif
                                        @else
                                            {{strip_tags($message->subject, '')}}
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">You don’t have any messages yet</li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">My Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Messages</li>
                        </ol>
                    </nav>
                    
                    <div id="message-{{$message->interest_id}}" class="message-block">
                        <div class="message-intro my-3">
                            <p class="tags"><b><i>Subject</i>:</b> {!!$id->subject!!}</p>
                            <p class="tags"><b><i>Date</i>:</b> <span>{{$id->created_at->diffForHumans()}}</span></p>
                            @if(!is_null($id->interest_id))
                                <div class="btn-list mt-3 mb-4">
                                    @if($id->interest_status($id->interest_id) === 1)
                                        <p>Accepted</p>
                                    @elseif($id->interest_status($id->interest_id) === 0)
                                        <p>Declined</p>
                                    @elseif($id->interest_status($id->interest_id) === false)
                                        <p>Interest withdrawn by the supplier.</p>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('accept-interest-{{$id->interest_id}}').submit();">Accept</button>
                                        <button type="submit" class="btn btn-sm btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('decline-interest-{{$id->interest_id}}').submit();">Decline</button>
                                        <form id="accept-interest-{{$id->interest_id}}" action="{{route('accept.interest', $id->interest_id)}}" method="post" class="write-review">
                                            {{csrf_field()}}
                                        </form> 
                                        <form id="decline-interest-{{$id->interest_id}}" action="{{route('decline.interest', $id->interest_id)}}" method="post" class="write-review">
                                            {{csrf_field()}}
                                        </form>
                                    @endif
                                </div>
                            @endif
                            
                        </div>
                        <div class="message-interest mb-5">
                            {!!$id->message!!}
                        </div>
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