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
                 <div class="sidebar-dashboard mb-5">
                    <ul class="dash-info">
                        <li>
                            <i class="fa fa-cubes fa-2x pull-left mr-3" aria-hidden="true"></i>
                            <div class="pull-right">
                                <p class="numb">{{$user->honeycombs ? $user->honeycombs : 0}}</p>
                                <p><i><b>Honeycombs</b></i> Earned</p>
                                <a href="">My Achievements</a>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-pie-chart fa-2x pull-left mr-3" aria-hidden="true"></i>
                            <div class="pull-right">
                                <p class="numb">87%</p>
                                <p><i><b>Profile</b></i> Completion</p>
                                <a href="">Edit Profile</a>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-folder-open-o fa-2x pull-left mr-3" aria-hidden="true"></i>
                            <div class="pull-right">
                                <p class="numb">{{count($user->projects)}}</p>
                                <p>Published <i><b>Projects</b></i></p>
                                <a href="">My Projects</a>
                            </div>
                        </li>
                    </ul>
                    @if(\Laratrust::hasRole('company|superadmin'))    
                        <button class="btn-dash btn-blue btn-yellow mt-3" data-toggle="modal" data-target="#add-project"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Publish New Project</button>
                    @endif
                 </div>
              </div>
              <div class="col-md-6">
                 <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                       <li class="breadcrumb-item"><a href="#">My Dashboard</a></li>
                       <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ol>
                 </nav>
                 <div class="dashboard-company-block">
                    <div class="d-flex justify-content-between">
                       <div><a href="" class="edit-thumb"><i class="fa fa-pencil-square-o align-self-center" aria-hidden="true"></i></a></div>
                       <div class="media-body px-3">
                          <h5 class="mt-1">{{$user->name}}</h5>
                          <p class="tags"><b>Account Manager</b></p>
                       </div>
                       <div><a href="{{route('front.user.editprofile', $user->username)}}" class="btn btn-sm btn-blue btn-yellow-2">Settings</a></div>
                    </div>
                 </div>
                 <div class="dashboard-company-block my-3">
                    <table class="table table-striped">
                       <thead class="thead-blue">
                          <tr>
                             <th scope="col">Basic information</th>
                             <th scope="col" class="text-right"><a href="{{route('front.user.editprofile', $user->username)}}">Edit my Details</a></th>
                          </tr>
                       </thead>
                       <tbody>
                          <tr>
                             <td scope="row"><b>Username</b></td>
                             <td>{{$user->username}}</td>
                          </tr>
                          <tr>
                             <td scope="row"><b>City</b></td>
                             <td>{{$user->user_city}}</td>
                          </tr>
                          <tr>
                             <td scope="row"><b>Email</b></td>
                             <td>{{$user->email}} <b>(Verified)</b></td>
                          </tr>
                          <tr>
                             <td scope="row"><b>Phone</b></td>
                             <td>{{$user->phone}}</td>
                          </tr>
                       </tbody>
                    </table>
                 </div>
              </div>
              <div class="col-md-3">
                  <div class="sidebar-subscription mb-4">
                    <h4 class="border-b">My subscription</h4>
                    <p>All SMBeez features are open for 6 months. You are on the highest subscription tier now, but you ll be downgraded to the free tier at 23/3/2018</p>
                  </div>
                  @forelse(auth()->user()->getReferrals() as $referral)
                   <div class="sidebar-subscription mb-4">             
                       
                        <h4 class="border-b">{{ $referral->program->name }}</h4>
                        <code>
                            {{ $referral->link }}
                        </code>
                        <p>
                            Number of referred users: {{ $referral->relationships()->count() }}
                        </p>
                        @empty
                        <p>No referrals</p>    
                        
                    </div>
                  @endforelse
                 @if($user->company)
                 <div class="sidebar-mycompany mb-4">
                    <h4 class="border-b">My Company</h4>
                    <div class="media-body">
                       <a href=""><i class="fa fa-2x fa-pencil-square-o pull-right" aria-hidden="true"></i></a>
                       <h5 class="mt-1 mb-2"><a href="{{route('front.company.show', $user->company->slug)}}">{{$user->company->company_name}}</a></h5>
                       <p class="tags"><b>Industry</b>:<a href="{{route('front.industry.show', $user->company->industry->slug)}}">{{$user->company->industry->industry_name}}</a></p>
                       <p class="tags"><b>Specialities:</b> 
                        <span>
                            @foreach($user->company->specialities as $speciality)
                                {{$speciality->speciality_name}},
                            @endforeach
                        </span>
                        </p>
                    </div>
                 </div>
                 
                 <div class="sidebar-review-rating mt-4">
                    <div class="rating-sidebar-block">
                       <h5 class="mb-3">My reviews</h5>
                       <div class="star-rating mb-3">
                          <ul class="list-inline">
                              @if($customer_reviews->count() > 0)
                              <li class="list-inline-item">
                                  @if($user->company->reviews->count() > 0)
                                  <select class="star-rating-ro">
                                      @for($i = 1; $i <= 5; $i++)
                                      <option value="{{$i}}" {{$i == $user->company->customer_rating($user->company->id, $customer_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                      @endfor
                                  </select>
                                  @endif
                              </li>
                              @endif
                          </ul>
                          <a href="">({{$customer_reviews->count()}}) Reviews from customers</a>
                      </div>
                      <div class="star-rating">
                          <ul class="list-inline">
                              @if($suppliers_reviews->count() > 0)
                              <li class="list-inline-item">
                                  @if($user->company->reviews->count() > 0)
                                  <select class="star-rating-ro">
                                      @for($i = 1; $i <= 5; $i++)
                                      <option value="{{$i}}" {{$i == $user->company->suppliers_rating($user->company->id, $suppliers_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                      @endfor
                                  </select>
                                  @endif
                              </li>
                              @endif
                          </ul>
                          <a href="">({{$suppliers_reviews->count()}}) Reviews from suppliers</a>
                      </div>
                    </div>
                 </div>
                 @endif
                 <div class="sidebar-updates mt-5">
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
                      <li class="list-group-item"><a href="{{route('front.messages.index')}}">All Messages</a></li>
                    </ul>
                 </div>
              </div>
           </div>
        </div>
    </section>
</main>

@if(\Laratrust::hasRole('company|superadmin'))
    @include ('layouts.create-project-modal')
@endif

@endsection