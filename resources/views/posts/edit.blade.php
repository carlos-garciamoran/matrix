@extends('app')
@section('title', 'Edit post')

@section('content')
<div class="card">
  <h5 class="card-header">Edit post</h5>
  <div class="card-body">
    @include('common.form-errors')

    <form action="/posts/{{ $post->id }}" class="needs-validation" method="POST" novalidate>
    @method('PATCH')
    @include('posts.form', ['action' => 'edit'])
    </form>
  </div>
</div>
@endsection
