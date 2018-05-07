<div class="filter">
    <form action="{{route('filter.opportunities')}}" class="form-group row" role="search" method="get">
        <div class="col-md-12">
            <div class="search-filter">
                <h3>Search <i class="fa fa-search pull-right" aria-hidden="true"></i></h3>
                <div class="form-group">
                    <input type="search" name="s" class="form-control" value="{{request()->query('s')}}" placeholder="Search...">
                </div>
            </div>
            <br>
            @if(Auth::guest() || !$hasCompany)
            <select name="industry" class="custom-select mb-2 mr-sm-2 mb-sm-0 w-100 multi-select">
                <option value="">All Industries</option>

                <!-- @foreach($industries as $key => $getindustry)
                <option value="{{$getindustry->id}}" {{$getindustry->id == $industry->id ? 'selected' : ''}} {{ $getindustry->id == request()->query('industry') ? 'selected' : ''}}>{{$getindustry->industry_name}}</option>
                @endforeach -->
                <option value="1">IT and Communication</option>
            </select>
            @elseif(!Auth::guest() || $hasCompany)
                <div class="search-filter mb-4">
                    <span>{{Auth::user()->company->industry->industry_name}}</span>
                </div>
            @endif
            <div class="search-filter">
                <h3>Select from specialities <i class="fa fa-filter pull-right" aria-hidden="true"></i></h3>
                <div class="form-group">
                    <select name="specialities[]" class="form-control multi-select" multiple>
                        @foreach ($specialities as $speciality)
                            <option value="{{$speciality->id}}" @if(request()->query('specialities')) @foreach(request()->query('specialities') as $spec) {{ $speciality->id == $spec ? 'selected' : ''}} @endforeach @endif>{{$speciality->speciality_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-blue">Submit Filter</button>
        </div>
    </form>
</div>