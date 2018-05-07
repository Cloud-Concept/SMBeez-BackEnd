@extends('layouts.admin')

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
                        <h5 class="title-blue">Reviews</h5>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="{{route('front.user.customerreviews', $user->username)}}" class="{{ Request::is('user/profile/'.$user->username.'/customerreviews') ? 'active' : 'no' }}">Reviews from Customers</a></li>
                            <li class="list-group-item"><a href="{{route('front.user.supplierreviews', $user->username)}}" class="{{ Request::is('user/profile/'.$user->username.'/supplierreviews') ? 'active' : 'no' }}">Reviews from Suppliers</a></li>
                            <li class="list-group-item"><a href="{{route('front.user.reviews', $user->username)}}" class="{{ Request::is('user/profile/'.$user->username.'/reviews') ? 'active' : 'no' }}">My Reviews</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Reviews</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-12">
                        	@if (session('success'))
		                        <div class="alert alert-success">
		                            {{ session('success') }}
		                        </div>
		                    @endif
		                    @if (session('error'))
		                        <div class="alert alert-danger">
		                            {{ session('error') }}
		                        </div>
		                    @endif
                            <table class="table table-striped my-4">
                                <thead class="thead-blue">
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th colspan="2">Feedback <i class="fa fa-caret-down" aria-hidden="true"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach($user_reviews as $review)
                                    <tr>
                                        <td scope="row">{{$review->company->company_name}}</td>
                                        <td>{{substr($review->feedback, 0, 60)}}
                                        	<br>
                                        	{{$review->created_at->toFormattedDateString()}}
                                        </td>
                                        <td width="10%">
                                            <div class="d-flex"><a href="" data-toggle="modal" data-target="#edit-review-{{$review->id}}" class="px-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="#" onclick="event.preventDefault(); document.getElementById('delete-{{$review->id}}').submit();" class="px-2"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>
                                        	<form id="delete-{{$review->id}}" action="{{route('front.user.review_delete', [$user->username, $review->id])}}" method="post">
                								{{csrf_field()}}
                								{{ method_field('DELETE') }}
                							</form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$user_reviews->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@foreach($user_reviews as $review)
<div class="modal fade modal-fullscreen" id="edit-review-{{$review->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">Edit Review</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{route('front.user.review_update', [$user->username, $review->id])}}" method="post" class="write-review claim-company-request">
                    {{csrf_field()}}
                    <div class="container">
                        <div class="row">
                            <div class="col-md-7 mrt-auto">
                                <div class="media br-btm mb-4 my-3 d-flex">
                                    <div class="col-md-2"><a href="#" class="pull-right"><i class="fa fa-circle fa-5x" aria-hidden="true"></i></a></div>
                                    <div class="col-lg-10 col-md-10 mb-4">
                                        <h6 class="pt-2 mb-3">{{$review->company->company_name}}</h6>
                                        <textarea name="feedback" class="form-control"></textarea>
                                        <br>
                                        <p>{{$review->feedback}}</p>
                                        <div class="btn-list my-5"><button type="submit" class="btn btn-blue btn-yellow">Submit Edits</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection