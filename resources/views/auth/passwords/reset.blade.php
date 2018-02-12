@extends('layouts.inner')

@section('content')

<main class="cd-main-content signup">
    <section class="sign-section">
        <div class="container-fluid">
            <div class="row">
                <div class="sign-col mrt-auto">
                    <div class="sign-block">
                        <ul class="nav nav-tabs nav-fill" id="tabs-signup" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="Reset Password" aria-selected="true"><i class="fa fa-sign-in" aria-hidden="true"></i> Reset Password</a></li>
                            <li class="nav-item"><a class="nav-link" id="create-account-tab" data-toggle="tab" href="#create-account" role="tab" aria-controls="Create Account" aria-selected="false"><i class="fa fa-user-o" aria-hidden="true"></i> Create new account</a></li>
                        </ul>
                        <div class="tab-content py-5 px-4" id="tabs-content-signup">
                            <div class="tab-pane fade show active" id="signup" role="tabpanel" aria-labelledby="singup-tab">
                                <p class="text-center mb-3">Please enter your new password.</p>
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-list text-center mt-2"><a class="btn btn-lk" href=""><i class="fa fa-linkedin" aria-hidden="true"></i> Sign Up With Linkedin</a> <a class="btn btn-fb mt-2" href=""><i class="fa fa-facebook" aria-hidden="true"></i> Sign Up With Facebook</a></div>
                                    </div>
                                    <div class="col-md-6">
                                        <form class="form-signin my-4" method="POST" action="{{ route('password.request') }}">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="token" value="{{ $token }}">

                                            <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">

                                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="E-Mail Address" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">

                                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>

                                                @if ($errors->has('password_confirmation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-blue btn-yellow">
                                                    Reset Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="create-account" role="tabpanel" aria-labelledby="create-account-tab">
                                <h2 class="py-2 text-center">
                                    Create your new SMBeez account
                                </h2>
                                <div class="btn-list mt-3 mb-4 text-center"><a class="btn btn-lk mr-3" href=""><i class="fa fa-linkedin" aria-hidden="true"></i> Sign Up With Linkedin</a> <a class="btn btn-fb mr-3" href=""><i class="fa fa-facebook" aria-hidden="true"></i> Sign Up With Facebook</a></div>
                                <p class="text-center my-3">Sign in with social media or your email and password. If you don't already have an account, click "Create new account".</p>
                                <form class="form-signin my-4" method="POST" action="{{ route('register') }}" role="form" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col">
                                            <div class="{{ $errors->has('name') ? ' is-invalid' : '' }}">
                                            <input id="name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <div class="text-left invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                            <input id="email" type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="email" placeholder="Email Address" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <div class="text-left invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                            <input id="password" type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" name="password" placeholder="Password" required>

                                            @if ($errors->has('password'))
                                                <div class="text-left invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="">
                                            <input id="password-confirm" type="password" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}" name="password_confirmation" placeholder="Confirm Password" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="{{ $errors->has('username') ? ' is-invalid' : '' }}">
                                            <input id="username" type="text" class="form-control {{$errors->has('username') ? 'is-invalid' : ''}}" name="username" placeholder="Username" value="{{ old('username') }}" required>

                                            @if ($errors->has('username'))
                                                <div class="text-left invalid-feedback">
                                                    {{ $errors->first('username') }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col">
                                            <input id="phone" type="text" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" name="phone" placeholder="Phone No." value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="custom-file">
                                                <input type="file" id="profile_pic_url" name="profile_pic_url" class="custom-file-input  {{$errors->has('profile_pic_url') ? 'is-invalid' : ''}}" accept=".png, .jpg, .jpeg, .bmp"> 
                                                <span class="custom-file-control" data-label="Profile Picture"></span>
                                            </label>
                                        </div>
                                        <div class="col">
                                            <select name="user_city" class="form-control custom-select d-block" required>
                                                <option value="">Select your City</option>
                                                <option value="Dubai">Dubai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4"><button type="submit" class="btn btn-blue btn-yellow">Create your account</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
