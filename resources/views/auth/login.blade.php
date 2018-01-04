@extends('layouts.inner')

@section('content')

<main class="cd-main-content">
    <section class="sign-section">
        <div class="container-fluid">
            <div class="row">
                <div class="sign-col mrt-auto">
                    <div class="sign-block">
                        <ul class="nav nav-tabs nav-fill" id="tabs-signup" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="signup-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="Sign In" aria-selected="true">Sign In</a></li>
                            <li class="nav-item"><a class="nav-link" id="create-account-tab" data-toggle="tab" href="#create-account" role="tab" aria-controls="Create Account" aria-selected="false">Create new account <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        </ul>
                        <div class="tab-content py-5 px-4" id="tabs-content-signup">
                            <div class="tab-pane fade show active" id="signup" role="tabpanel" aria-labelledby="singup-tab">
                                <p class="text-center mb-3">MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-list text-center mt-2"><a class="btn btn-lk" href=""><i class="fa fa-linkedin" aria-hidden="true"></i> Sign Up With Linkedin</a> <a class="btn btn-fb mt-2" href=""><i class="fa fa-facebook" aria-hidden="true"></i> Sign Up With Facebook</a></div>
                                    </div>
                                    <div class="col-md-6">
                                        <form class="form-signin my-4" method="POST" action="{{ route('login') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <input id="email" type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

                                                @if ($errors->has('email'))
                                                    <div class="text-left invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <input id="password" type="password" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="password" placeholder="Password" required>

                                                @if ($errors->has('password'))
                                                    <div class="text-left invalid-feedback">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col"><label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="remember" {{ old('remember') ? 'checked' : '' }}> <span class="custom-control-indicator"></span> <span class="custom-control-description">Remember me</span></label>
                                                </div>
                                                <div class="col"><a href="{{ route('password.request') }}">Forgot password?</a></div>
                                            </div>
                                            <button type="submit" class="btn btn-yellow-2 mt-2 pull-right">sign in</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="create-account" role="tabpanel" aria-labelledby="create-account-tab">
                                <h2 class="py-2 text-center">
                                    Create your new SMBeez account
                                </h2>
                                <div class="btn-list mt-3 mb-4 text-center"><a class="btn btn-lk mr-3" href=""><i class="fa fa-linkedin" aria-hidden="true"></i> Sign Up With Linkedin</a> <a class="btn btn-fb mr-3" href=""><i class="fa fa-facebook" aria-hidden="true"></i> Sign Up With Facebook</a></div>
                                <p class="text-center my-3">MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can</p>
                                <form class="form-signin my-4" method="POST" action="{{ route('register') }}">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col">
                                            <div class="{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <input id="name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <div class="text-left invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
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
                                            <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
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
                                            <div class="{{ $errors->has('username') ? ' has-error' : '' }}">
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
                                        <div class="col"><input type="file" class="form-control {{$errors->has('profile_pic_url') ? 'is-invalid' : ''}}" name="profile_pic_url"></div>
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
