<div class="filter">
    <form action="" class="form-group row" role="search" method="get">
        <div class="col-md-12">
            <select name="industry" class="custom-select mb-2 mr-sm-2 mb-sm-0 w-100 multi-select">
                <option>All Industries</option>

                @foreach($industries as $key => $getindustry)
                <option value="{{$getindustry->id}}" {{$getindustry->id == $industry->id ? 'selected' : ''}}>{{$getindustry->industry_name}}</option>
                @endforeach
            </select>
            <div class="search-filter">
                <h3>Select from specialities <i class="fa fa-filter pull-right" aria-hidden="true"></i></h3>
                <div class="form-group">
                    <select name="specialities[]" class="form-control multi-select" multiple>
                        @foreach ($specialities as $speciality)
                            <option value="{{$speciality->id}}">{{$speciality->speciality_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-blue">Submit Filter</button>
        </div>
    </form>
</div>