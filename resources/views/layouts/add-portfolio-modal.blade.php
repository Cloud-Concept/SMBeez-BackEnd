<div class="modal fade modal-fullscreen modal-add-portfolio" id="add-portfolio" tabindex="-1" role="dialog" aria-labelledby="add-portfolio" aria-hidden="true">
    <div class="modal-cover" style="width: 100%; height: 800px; background: #3336; z-index: 9999; position: absolute; display:none;"></div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="modal-title">{{__('company.add_portfolio')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body text-center container">
                <form class="form-signin my-4" id="add-portfolio-form" enctype="multipart/form-data" action="{{route('front.portfolio.store', $user->company->slug)}}" method="post">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-success alert-green alert-dismissible fade assign-user-alert" role="alert">
                                <h3 class="assign-msg"></h3>
                            </div>
                            <div class="form-group">
                                <label for="">{{__('company.portfolio_title')}}</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="">{{__('company.portfolio_description')}}</label>
                                <textarea name="description" class="form-control" id="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="custom-file">
                                    <input type="file" id="portfolio-img" name="portfolio-img" class="custom-file-input" accept=".jpeg,.jpg,.png"> 
                                    <span class="custom-file-control" data-label="{{__('company.portfolio_img')}}"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="text-center mt-4"><button type="submit" class="btn btn-blue btn-yellow">{{__('company.add_portfolio')}}</button></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>