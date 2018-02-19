@extends('layouts.admin')

@section('content')

<main class="cd-main-content">
    <section class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('layouts.superadmin-sidebar')
                </div>
                <div class="col-md-9">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">SuperAdmin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Import/Export Companies</li>
                        </ol>
                    </nav>
                    <div class="alert alert-yellow alert-dismissible fade show my-4 text-center" role="alert">
                    	
                    	<a href="{{ route('export.file',['type'=>'xls']) }}">Download Excel xls</a> |

				        <a href="{{ route('export.file',['type'=>'xlsx']) }}">Download Excel xlsx</a> |

				        <a href="{{ route('export.file',['type'=>'csv']) }}">Download CSV</a>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        	@if (session('success'))
		                        <div class="alert alert-success">
		                            {{ session('success') }}
		                        </div>
		                    @endif
		                    @if (session('error'))
		                        <div class="alert alert-danger">
		                            {{ session('error') }}
		                        </div>
		                    @endif
                            <div class="alert alert-danger">
                                TAKE CARE WHEN USING THIS, NEVER USE IT WITHOUT APPROVAL
                            </div>
                        	<form action="{{route('import.file')}}" method="post" enctype="multipart/form-data">
                        		{{csrf_field()}}
                                <div class="form-group">
                                    <label class="custom-file">
                                        <input type="file" id="sample_file" name="sample_file" class="custom-file-input" accept=".xls, .xlsx, .csv"> 
                                        <span class="custom-file-control" data-label="Select File to Import"></span>
                                    </label>
                                </div>
                                <div class="form-group"><button type="submit" class="btn btn-blue btn-yellow text-capitalize">Import</button></div>
                        	</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection