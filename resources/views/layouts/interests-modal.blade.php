@foreach($user->projects as $project)
    @if(count($project->interests) > 0)
        <div class="modal fade modal-fullscreen modal-bg-white" id="expressInterestModal-{{$project->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-header">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="modal-title">Expressed interests on your project “{{$project->project_title}}”</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row gray-title mb-4">
                                <div class="col-md-4">
                                    <h3>Supplier</h3>
                                </div>
                                <div class="col-md-8">
                                    <h3>Company Information</h3>
                                </div>
                            </div>
                            @foreach($project->interests as $interest)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="modal-sidebar">
                                        <div class="media-body">
                                            <h5 class="mt-1 mb-2"><a href="{{route('front.company.show', $interest->user->company->slug)}}">{{$interest->user->company->company_name}}</a></h5>
                                            <p class="tags"><b>Industry</b>:<a href="{{route('front.industry.show', $interest->user->company->industry->slug)}}">{{$interest->user->company->industry->industry_name}}</a></p>
                                            <p class="tags"><b>Specialities:</b> <span>
                                                @foreach($interest->user->company->specialities as $speciality)
                                                    {{$speciality->speciality_name}},
                                                @endforeach
                                            </span></p>
                                        </div>
                                        <div class="star-rating mb-3">
                                            <ul class="list-inline">
                                                @if($interest->user->company->reviews->count() > 0)
                                                <div class="star-rating">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <select class="star-rating-ro">
                                                                @for($i = 0; $i <= 5; $i++)
                                                                <option value="{{$i}}" {{$i == $interest->user->company->company_overall_rating($interest->user->company->id) ? 'selected' : ''}}>{{$i}}</option>
                                                                @endfor
                                                            </select>
                                                        </li>
                                                        <li class="list-inline-item thumb-review"><a href="">({{$interest->user->company->reviews->count()}} Reviews)</a></li>
                                                    </ul>
                                                </div>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="modal-company">
                                        <p class="tags"><b>Company Size:</b> {{$interest->user->company->company_size}}</p>
                                        <p class="tags"><b>About:</b></p>
                                        {!! substr($interest->user->company->company_description, 0, 400) !!}
                                        <div class="btn-list mt-3 mb-4">
                                            @if($interest->is_accepted === 1)
                                                <p>Accepted</p>
                                            @elseif($interest->is_accepted === 0)
                                                <p>Declined</p>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-yellow-2 mr-3" onclick="event.preventDefault(); document.getElementById('accept-interest-{{$interest->id}}').submit();">Accept</button>                  
                                                <button type="submit" class="btn btn-sm btn-blue btn-yellow" onclick="event.preventDefault(); document.getElementById('decline-interest-{{$interest->id}}').submit();">Decline</button>
                                            @endif
                                            <form id="accept-interest-{{$interest->id}}" action="{{route('accept.interest', $interest->id)}}" method="post" class="write-review">
                                                {{csrf_field()}}
                                            </form>  
                                            <form id="decline-interest-{{$interest->id}}" action="{{route('decline.interest', $interest->id)}}" method="post" class="write-review">
                                                {{csrf_field()}}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach