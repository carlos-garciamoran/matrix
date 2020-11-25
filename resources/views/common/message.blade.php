@extends('app')
@section('title', $message)

@section('content')
<div class="row">
  <div class="col">
    <div class="alert alert-{{ $type=='error' ? 'danger' : 'success' }} d-flex justify-content-center mt-3">{{ $message }}</div>
  </div>
</div>
@endsection
