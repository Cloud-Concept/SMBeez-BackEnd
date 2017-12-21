<div class="filter">
    <form action="" class="form-group row">
        <div class="col-md-12">
            <select class="custom-select mb-2 mr-sm-2 mb-sm-0 w-100">
                <option>All Industries</option>
                @foreach($industries as $key => $getindustry)
                <option value="{{$getindustry->id}}" {{$getindustry->id == $industry->id ? 'selected' : ''}}>{{$getindustry->industry_name}}</option>
                @endforeach
            </select>
            <div class="search-filter">
                <h3>Select from specialities <i class="fa fa-filter pull-right" aria-hidden="true"></i></h3>
                <div class="form-group"><input type="text" class="form-control" placeholder="Search within companies"></div>
                <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Electrical Supplies</span></label></div>
                <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">CMS</span></label></div>
                <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Civil Engineering</span></label></div>
                <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Sales force</span></label></div>
                <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Finanacial Consultancy</span></label></div>
                <div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" required> <span class="custom-control-indicator"></span> <span class="custom-control-description">Tutoring</span></label></div>
            </div>
        </div>
    </form>
</div>