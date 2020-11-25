@extends('app')
@section('title', 'Sign In')

@section('content')
<div class="card">
  <div class="card-header h5">Sign In</div>
  <div class="card-body">
    <form method="POST">
      @csrf
      <div class="row form-group">
        <div class="col">
          <button class="btn btn-primary btn-block" type="submit">Sign In</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
