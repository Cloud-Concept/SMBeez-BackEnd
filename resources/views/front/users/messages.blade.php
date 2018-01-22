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
                            @foreach($user->messages as $message)
                                <li class="list-group-item">
                                    @if($message->interest_id)
                                        {{$message->created_at->diffForHumans()}} :
                                        New Express Interest
                                    @else
                                        {{$message->subject}}
                                    @endif
                                </li>
                            @endforeach
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

                    @foreach($user->messages as $message)
                        <div class="message-block">
                            <div class="message-intro my-3">
                                <p class="tags"><b><i>Subject</i>:</b> {!!$message->subject!!}</p>
                                <p class="tags"><b><i>Date</i>:</b> <span>{{$message->created_at->diffForHumans()}}</span></p>
                                @if(!is_null($message->interest_id))
                                    <div class="btn-list mt-3 mb-4">
                                        @if($message->interest_status($message->interest_id) === 1)
                                            <p>Accepted</p>
                                        @elseif($message->interest_status($message->interest_id) === 0)
                                            <p>Declined</p>
                                        @elseif($message->interest_status($message->interest_id) === false)
                                            <p>Interest withdrawn by the supplier.</p>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('accept-interest-{{$message->interest_id}}').submit();">Accept</button>
                                            <button type="submit" class="btn btn-sm btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('decline-interest-{{$message->interest_id}}').submit();">Decline</button>
                                            <form id="accept-interest-{{$message->interest_id}}" action="{{route('accept.interest', $message->interest_id)}}" method="post" class="write-review">
                                                {{csrf_field()}}
                                            </form> 
                                            <form id="decline-interest-{{$message->interest_id}}" action="{{route('decline.interest', $message->interest_id)}}" method="post" class="write-review">
                                                {{csrf_field()}}
                                            </form>
                                        @endif
                                    </div>
                                @endif
                                
                            </div>
                            <div class="message-interest mb-5">
                                {!!$message->message!!}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <h3><i class="fa fa-thumb-tack fa-rotate-45" aria-hidden="true"></i> Tips</h3>
                        <p>As conscious traveling Paupers we must always be concerned about our dear Mother Earth. If you think about it, you travel across her face, and She is the host to your journey; without Her we could not find the unfolding adventures that attract and feed our souls</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection