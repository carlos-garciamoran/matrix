@extends('app')
@section('title', 'New post')

@section('content')
<div class="card">
  <h5 class="card-header">New post</h5>
  <div class="card-body">
    @include('common.form-errors')

    <form action="/posts" class="needs-validation" method="POST" novalidate>
    @include('posts.form', ['action' => 'create'])
    </form>
  </div>
</div>
@endsection
