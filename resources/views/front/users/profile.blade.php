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
                        <!-- <li>
                            <i class="fa fa-cubes fa-2x pull-left mr-3" aria-hidden="true"></i>
                            <div class="pull-right">
                                <p class="numb">{{$user->honeycombs ? $user->honeycombs : 0}}</p>
                                <p><i><b>Honeycombs</b></i> Earned</p>
                                <a href="">My Achievements</a>
                            </div>
                        </li> -->
                        <li>
                            <i class="fa fa-pie-chart fa-2x pull-left mr-3" aria-hidden="true"></i>
                            <div class="pull-right">
                                <p class="numb">87%</p>
                                <p><i><b>Profile</b></i> Completion</p>
                                <a href="{{route('front.user.editprofile', $user->username)}}">Edit Profile</a>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-folder-open-o fa-2x pull-left mr-3" aria-hidden="true"></i>
                            <div class="pull-right">
                                <p class="numb">{{count($user->projects)}}</p>
                                <p>Published <i><b>Projects</b></i></p>
                                <a href="{{route('front.user.myprojects', $user->username)}}">My Projects</a>
                            </div>
                        </li>
                    </ul>
                    @if($user->company)    
                        <button class="btn-dash btn-blue btn-yellow mt-3" data-toggle="modal" data-target="#add-project"><i class="fa fa-folder-open-o" aria-hidden="true"></i> {{__('general.publish_project')}}</button>
                    @endif
                 </div>
              </div>
              <div class="col-md-6">
                 <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{route('front.user.dashboard', $user->username)}}">My Dashboard</a></li>
                       <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                    </ol>
                 </nav>
                 <div class="dashboard-company-block">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="edit-thumb-upload">
                                <form id="update_logo" action="{{route('front.user.update_logo', $user->username)}}" method="POST" role="form" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    @if($user->profile_pic_url && file_exists(public_path('/') . $user->profile_pic_url))
                                        <img src="{{asset($user->profile_pic_url)}}">
                                    @else
                                        <img src="{{asset('images/common/user.svg')}}">
                                    @endif
                                    <span class="edit-thumb-icon"><i class="fa fa-pencil-square-o align-self-center" aria-hidden="true"></i></span> 
                                    <input type="file" id="profile_pic_url" name="profile_pic_url" class="custom-file-input" accept=".png, .jpg, .jpeg, .bmp">
                                </form>
                            </div>
                        </div>
                        <div class="media-body px-3">
                          <h5 class="mt-1">{{$user->first_name . " " . $user->last_name}}</h5>
                          @if($user->company)
                          <p class="tags"><b>{{$user->company->role}}</b></p>
                          @endif
                        </div>
                        <div><a href="{{route('front.user.editprofile', $user->username)}}" class="btn btn-sm btn-blue btn-yellow-2">Edit Settings</a></div>
                    </div>
                 </div>
                 <div class="dashboard-company-block my-3">
                    <table class="table table-striped">
                       <thead class="thead-blue">
                          <tr>
                             <th scope="col">Basic information</th>
                             <th scope="col" class="text-right"></th>
                          </tr>
                       </thead>
                       <tbody>
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
                        <p>All Masharee3 features are open for 6 months. You are on the highest subscription tier now, but you will be downgraded to the free tier at 23/9/2018</p>
                    </div>
                    <!-- @forelse(auth()->user()->getReferrals() as $referral)
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
                    @endforelse -->
                    @if($user->company)
                    <div class="sidebar-mycompany mb-4">
                        <h4 class="border-b">My Company</h4>
                        <div class="media-body">
                           <a href="{{route('front.company.edit', $user->company->slug)}}"><i class="fa fa-pencil-square-o pull-right" aria-hidden="true"></i></a>
                           <h5 class="mt-1 mb-2"><a href="{{route('front.company.show', $user->company->slug)}}">{{$user->company->company_name}}</a></h5>
                           <p class="tags"><b>Industry</b>:<a href="{{route('front.industry.show', $user->company->industry->slug)}}">
                            @if(app()->getLocale() == 'ar')
                            {{$user->company->industry->industry_name_ar}}
                            @else
                            {{$user->company->industry->industry_name}}
                            @endif
                          </a></p>
                           @if($user->company->specialities->count() > 0)
                           <p class="tags"><b>{{__('general.specs_tag_title')}}</b> 
                            <span>
                                @foreach($user->company->specialities as $speciality)
                                    {{ $loop->first ? '' : ', ' }}
                                    {{$speciality->speciality_name}}
                                @endforeach
                            </span>
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="sidebar-review-rating mt-4">
                        <div class="rating-sidebar-block">
                           <h5 class="mb-3">My reviews</h5>
                           <div class="star-rating mb-3">
                              <ul class="list-inline">
                                  <li class="list-inline-item">
                                      <select class="star-rating-ro">
                                          @for($i = 0; $i <= 5; $i++)
                                          <option value="{{$i}}" {{$i == $user->company->customer_rating($user->company->id, $customer_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                          @endfor
                                      </select>
                                  </li>
                              </ul>
                              <a href="{{route('front.company.show', $user->company->slug)}}/?tab=customers">({{$customer_reviews->count()}}) Reviews from customers</a>
                          </div>
                          <div class="star-rating">
                              <ul class="list-inline">
                                  <li class="list-inline-item">
                                      <select class="star-rating-ro">
                                          @for($i = 0; $i <= 5; $i++)
                                          <option value="{{$i}}" {{$i == $user->company->suppliers_rating($user->company->id, $suppliers_reviews) ? 'selected' : ''}}>{{$i}}</option>
                                          @endfor
                                      </select>
                                  </li>
                              </ul>
                              <a href="{{route('front.company.show', $user->company->slug)}}/?tab=suppliers">({{$suppliers_reviews->count()}}) Reviews from suppliers</a>
                          </div>
                        </div>
                    </div>
                    @endif
                </div>
           </div>
        </div>
    </section>
</main>

<script>
document.getElementById("profile_pic_url").onchange = function() {
    document.getElementById("update_logo").submit();
};
</script>
@if($hascompany)
    @include ('layouts.create-project-modal')
@else
    @include ('layouts.add-company-modal')
@endif

@endsection