@extends('app')
@section('title', 'User profile')

@section('content')
<div class="card">
  <h5 class="card-header">User profile</h5>
  <div class="card-body">
    {{-- TODO: layout horizontally (column-wise) + make responsive --}}
    <div class="row">
      <div class="col-lg">
        <h5>General</h5>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-lg">
        <img src="{{ $user->profile_photo() }}" height="50" width="50" class="rounded" alt="Profile photo">
        Name: {{ $user->name }}
      </div>
    </div>

    <div class="row mb-5">
      <div class="col-lg">
        Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
      </div>
    </div>

    @if($user->isStudent()) @include('students.show', ['student' => $user->student])
    @elseif($user->isAdvisor()) @include('advisors.show', ['advisor' => $user->advisor])
    @endif
  </div>
</div>
@endsection
