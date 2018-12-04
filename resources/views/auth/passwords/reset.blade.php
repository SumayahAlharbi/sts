@extends('layouts.auth')

@section('content')

  <div class="login-register" style="background-image:url({{ url('assets/images/background/login-register-2.jpg') }});">
      <div class="login-box card">
          <div class="card-body">
            <h3 class="box-title m-b-20">{{ __('Reset Password') }}</h3>

              <form method="POST" action="{{ route('password.update') }}" class="form-horizontal form-material">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <input placeholder="Email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                  <div class="form-group ">
                      <div class="col-xs-12">
                        <input placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                  </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                      </div>
                  </div>
                  <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                          <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">{{ __('Reset Password') }}</button>
                      </div>
                  </div>


              </form>

      </div>
  </div>
    </div>
@endsection
