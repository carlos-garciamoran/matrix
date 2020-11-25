@extends('app')
@section('title', 'Reset Password')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <form class="needs-validation" method="POST" action="/password/reset" novalidate>
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="form-group row">
            <label for="email" class="col-lg-4 col-form-label text-lg-right">Email Address</label>
            <div class="col-lg-6">
              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
              @if ($errors->has('email'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
              <div class="invalid-feedback">
                Make sure you enter your email.
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
                Make sure your password meets the minimum requirements.
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="password-confirm" class="col-lg-4 col-form-label text-lg-right">Confirm Password</label>
            <div class="col-lg-6">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
              <div class="invalid-feedback">
                Make sure your passwords match.
              </div>
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-lg-6 offset-lg-4">
              <button type="submit" class="btn btn-primary">Reset Password</button>
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
