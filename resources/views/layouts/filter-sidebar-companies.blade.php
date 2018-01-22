<div class="filter">
    <form action="" class="form-group row">
        <div class="col-md-12">
            <select class="custom-select mb-2 mr-sm-2 mb-sm-0 w-100">
                <option>All Industries</option>

                @foreach($industries as $key => $getindustry)
                <option value="{{$getindustry->id}}">{{$getindustry->industry_name}}</option>
                @endforeach
            </select>
            <div class="search-filter">
                <h3>Select from specialities <i class="fa fa-filter pull-right" aria-hidden="true"></i></h3>
                <div class="form-group">
                    <select name="specialities" class="form-control multi-select" multiple>
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