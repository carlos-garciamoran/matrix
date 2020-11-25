@extends('app')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <h5 class="card-header">Login</h5>
      <div class="card-body">
        <form class="needs-validation" method="POST" novalidate>
          @csrf
          <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label text-lg-right">Email Address</label>
            <div class="col-lg-6">
              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
              @if ($errors->has('email'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
              <div class="invalid-feedback">
                Make sure you enter your email address.
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-lg-4 col-form-label text-lg-right">Password</label>
            <div class="col-lg-6">
              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
              @if ($errors->has('password'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
              <div class="invalid-feedback">
                Make sure you enter your password.
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-lg-6 offset-lg-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" checked>
                <label class="form-check-label" for="remember">Remember Me</label>
                </div>
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-lg-8 offset-lg-4">
              <button type="submit" class="btn btn-primary">Login</button>
              <a class="btn btn-link" href="/password/reset">Forgot Your Password?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="/js/bootstrap-form.js"></script>
@endsection
