@extends('app')
@section('title', 'Edit advisor')

@section('content')
<div class="row justify-content-center">
  <div class="col">
    <div class="card">
      <h5 class="card-header">Edit advisor</h5>
      <div class="card-body">
        <form action="/advisors/{{ $advisor->user_id }}" class="needs-validation" method="POST" novalidate>
        @method('PATCH')
        @include('advisors.form', ['action' => 'edit'])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="/js/bootstrap-form.js"></script>
@endsection
