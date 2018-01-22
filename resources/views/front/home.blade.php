@extends('layouts.main')

@section('content')
<main class="cd-main-content">
    <section class="hero">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-md-12 offset-xl-3">
                    <h1 class="text-center">Matchmaking for Small Businesses</h1>
                    <p class="text-center">Find work and source suppliers in your local marketplace...</p>
                    <div class="btn-hero text-center"><a href="{{route('front.company.all')}}" class="btn btn-blue"><i class="fa fa-clone" aria-hidden="true"></i> Add your company</a> <span>or </span><a href="#" class="btn btn-blue"><i class="fa fa-folder-open-o" aria-hidden="true"></i> publish your project</a></div>
                </div>
            </div>
        </div>
    </section>
    <section class="hero-slider align-items-center d-none d-md-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="d-flex justify-content-around">
                        <li class="align-self-center"><a href=""><img src="images/media/img-01.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-02.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-03.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-04.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-05.jpg" alt="title here"></a></li>
                        <li class="align-self-center"><a href=""><img src="images/media/img-06.jpg" alt="title here"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="featured-companies bg-gray">
        <div class="container-fluid">
            <div class="row px-4">
                <div class="col-md-4">
                    <div class="sidebar sidebar-01">
                        <h2>Find Suppliers</h2>
                        <p class="mt-5 mb-5">Browse thousands of reliable suppliers in different industries. Contact suppliers through SMBeez or directly. Check out the suppliers’ reviews by other clients like you and engage confidently in business relationships based on mutual trust.</p>
                        <a href="" class="btn btn-blue btn-yellow"><i class="fa fa-angle-right" aria-hidden="true"></i> Browse Companies</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="mb-5">Featured companies <a href="" class="btn btn-trans pull-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> Discover more</a></h3>
                        </div>
                        <div class="col-md-6">
                            <div class="company-box box-block mb-5">
                                <img class="img-responsive" src="images/media/media-01.jpg" alt="tile here">
                                <div class="company-box-header media mt-4">
                                    <a href="#" class="mr-3"><i class="fa fa-circle fa-4x" aria-hidden="true"></i></a>
                                    <div class="media-body">
                                        <p class="thumb-title mt-1 mb-1">A Good Autoresponder</p>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item thumb-review"><a href="">(35 Reviews)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p>With easy access to Broadband and DSL the number of people using the Internet has skyrocket in recent years. Email, instant messaging and file</p>
                                <p class="tags">More in: <a href="">Trade, Wholesale and Retail</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="company-box box-block mb-5">
                                <img class="img-responsive" src="images/media/media-01.jpg" alt="tile here">
                                <div class="company-box-header media mt-4">
                                    <a href="#" class="mr-3"><i class="fa fa-circle fa-4x" aria-hidden="true"></i></a>
                                    <div class="media-body">
                                        <p class="thumb-title mt-1 mb-1">A Good Autoresponder</p>
                                        <div class="star-rating">
                                            <ul class="list-inline">
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="active list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item"><a href=""><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li class="list-inline-item thumb-review"><a href="">(35 Reviews)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <p>With easy access to Broadband and DSL the number of people using the Internet has skyrocket in recent years. Email, instant messaging and file</p>
                                <p class="tags">More in: <a href="">Trade, Wholesale and Retail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="featured-projects box-block">
        <div class="container-fluid">
            <div class="row px-4">
                <div class="col-md-8">
                    <div class="row equal">
                        <div class="col-md-12">
                            <h3 class="mb-5">Featured Projects <a href="" class="btn btn-trans pull-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> Discover more</a></h3>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="project-box box-block">
                                <p class="thumb-title mt-1 mb-1">Enlightenment Is Not Just</p>
                                <p>Over time, even the most sophisticated, memory packed computer can begin to run slow if we don’t do something to prevent it.</p>
                                <p class="tags">More in: <a href="">Construction and Real Estate</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="project-box box-block">
                                <p class="thumb-title mt-1 mb-1">Low Cost Advertising</p>
                                <p>There are many ways chocolate makes people happy and one of the worthiest is a tour that has been described a</p>
                                <p class="tags">More in: <a href="">Trade, Wholesale and Retail</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="project-box box-block">
                                <p class="thumb-title mt-1 mb-1">Promotional Advertising</p>
                                <p>According to the research firm Frost & Sullivan, the estimated size of the North American used test and measurement...</p>
                                <p class="tags">More in: <a href="">Finance and Insurance</a></p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="project-box box-block border-0">
                                <p class="thumb-title mt-1 mb-1">Promotional Advertising</p>
                                <p>Audio player software is used to play back sound recordings in one of the many formats available for computers today...</p>
                                <p class="tags">More in: <a href="">Oil, Gas and Mining</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row equal">
                        <div class="col-md-12">
                            <h3 class="mb-5">Featured Projects</h3>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="project-box project-box-side box-block">
                                <p class="thumb-title mt-1 mb-1">Direct Mail Advertising</p>
                                <p>Over time, even the most sophisticated, memory packed computer can begin to run slow if we don’t do something to prevent it.</p>
                                <p class="tags">More in: <a href="">Finance and Insurance</a></p>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="project-box project-box-side box-block border-0">
                                <p class="thumb-title mt-1 mb-1">Promotional Advertising</p>
                                <p>Audio player software is used to play back sound recordings in one of the many formats available for computers today...</p>
                                <p class="tags">More in: <a href="">Oil, Gas and Mining</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="create-intro-sidebar py-5 bg-gray">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-12 offset-md-3 text-center">
                    <h2><i class="fa fa-folder-o fa-3x mb-3" aria-hidden="true"></i><br>Find Work</h2>
                    <p class="mt-5 mb-5">Browse thousands of reliable suppliers in different industries. Contact suppliers through SMBeez or directly. Check out the suppliers’ reviews by other clients like you and engage confidently in business relationships based on mutual trust.</p>
                    <a href="" class="btn btn-blue btn-yellow"><i class="fa fa-angle-right" aria-hidden="true"></i> Browse Projects</a>
                </div>
            </div>
        </div>
    </section>
    <section class="create-intro bg-blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-12 offset-md-3 text-center">
                    <h2><i class="fa fa-files-o fa-2x mb-3" aria-hidden="true"></i><br>Be Found</h2>
                    <p class="mt-5 mb-5">Create your company profile and sar thousands of reliable suppliers in different industries. Contact suppliers through SMBeez or directly. Check out the suppliers’ reviews by other clients like you and engage confidently in business relationships based on mutual trust.</p>
                    <a href="" class="btn btn-blue btn-yellow-2">Browse Projects</a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection