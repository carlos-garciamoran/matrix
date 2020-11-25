@extends('app')
@section('title', 'Register advisor')

@section('content')
<div class="row justify-content-center">
  <div class="col">
    <div class="card">
      <h5 class="card-header">Register advisor</h5>
      <div class="card-body">
        <form method="POST" action="/advisors">
        @include('advisors.form', ['action' => 'registration'])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="/js/bootstrap-form.js"></script>
@endsection
