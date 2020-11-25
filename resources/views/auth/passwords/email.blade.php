@extends('app')
@section('title', 'Reset Password')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <form class="needs-validation" method="POST" action="/password/email" novalidate>
          @csrf
          <div class="form-group row">
            <label for="email" class="col-lg-4 col-form-label text-lg-right">Email Address</label>
            <div class="col-lg-6">
              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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

          <div class="form-group row mb-0">
            <div class="col-lg-6 offset-lg-4">
              <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
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
