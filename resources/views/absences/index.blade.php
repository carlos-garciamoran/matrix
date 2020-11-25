@extends('app')
@section('title', 'Absence List')

@section('content')
<div class="card">
  <h5 class="card-header">Absence List</h5>
  <div class="card-body">
    @foreach($absences as $absence)
    <div class="row align-items-center mb-4">
      <div class="col">
        <a href="/users/{{ $absence->user->id }}">
          <img class="rounded-circle" src="{{ $absence->user->profile_photo() }}" height="50" width="50" alt="Profile photo">{{ $absence->user->name }}
        </a>
      </div>
      <div class="col">
        <a href="/absences/user/{{ $absence->user->id }}" class="btn btn-light" role="button" aria-pressed="true">Absence History</a>
      </div>
      <div class="col">
        <div class="row">
          <form action="/absences/{{ $absence->id }}/reject" method="POST">
            @csrf  {{-- TODO: popup confirmation modal --}}
            <button type="submit" class="btn btn-outline-danger">&#10005;</button>
          </form>
          <form action="/absences/{{ $absence->id }}/approve" method="POST">
            @csrf  {{-- TODO: popup confirmation modal --}}
            <button type="submit" class="btn btn-outline-success">&#10003;</button>
          </form>
        </div>
      </div>
    </div>
  @endforeach
  </div>
</div>
@endsection
