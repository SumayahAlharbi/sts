@extends('layouts.auth')

@section('content')

  <div class="login-register" style="background-image:url({{ url('assets/images/background/login-register-2.jpg') }});">
      <div class="login-box card">
          <div class="card-body">
              <form method="POST" class="form-horizontal form-material" id="loginform" action="{{ route('login') }}">
                @csrf

                  <h3 class="box-title m-b-20">{{ __('Login') }}</h3>
                  <div class="form-group ">
                      <div class="col-xs-12">
                          {{-- <input class="form-control" type="text" required="" placeholder="Username"> --}}
                          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                          @if ($errors->has('email'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                         </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          {{-- <input class="form-control" type="password" required="" placeholder="Password"> --}}
                          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                          @if ($errors->has('password'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif

                         </div>
                  </div>
                  <div class="form-group">
                      <div class="col-md-12">
                          <div class="checkbox checkbox-primary pull-left p-t-0">
                              <input id="checkbox-signup" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                              <label for="checkbox-signup"> {{ __('Remember Me') }} </label>
                          </div> <a href="{{ route('password.request') }}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> {{ __('Forgot Your Password?') }}</a> </div>
                  </div>
                  <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                          <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">{{ __('Login') }}</button>
                      </div>
                  </div>

                  <div class="form-group m-b-0">
                      <div class="col-sm-12 text-center">
                          <p>Don't have an account? <a href="{{ route('register') }}" class="text-info m-l-5"><b>Sign Up</b></a></p>
                      </div>
                  </div>
              </form>
              {{-- <form class="form-horizontal" id="recoverform" action="index.html">
                  <div class="form-group ">
                      <div class="col-xs-12">
                          <h3>Recover Password</h3>
                          <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                      </div>
                  </div>
                  <div class="form-group ">
                      <div class="col-xs-12">
                          <input class="form-control" type="text" required="" placeholder="Email"> </div>
                  </div>
                  <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                          <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                      </div>
                  </div>
              </form> --}}
          </div>
      </div>
  </div>
@endsection
