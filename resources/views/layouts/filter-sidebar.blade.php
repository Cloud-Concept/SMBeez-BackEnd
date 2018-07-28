<div class="filter">
    <form action="" class="form-group row">
        <div class="col-md-12">
            <select class="custom-select mb-2 mr-sm-2 mb-sm-0 w-100">
                <option>{{__('general.all_industries_title')}}</option>

                @foreach($industries as $key => $getindustry)
                <option value="{{$getindustry->id}}" {{$getindustry->id == $industry->id ? 'selected' : ''}}>{{$getindustry->industry_name}}</option>
                @endforeach
            </select>
            <div class="search-filter">
                <h3>{{__('general.specialities_tags_choose')}} <i class="fa fa-filter pull-right" aria-hidden="true"></i></h3>
                <div class="form-group"><input type="text" class="form-control" placeholder="Search within companies"></div>
            </div>
            <br>
            <button type="submit" class="btn btn-blue">{{__('general.submit_filter_button')}}</button>
        </div>
    </form>
</div>