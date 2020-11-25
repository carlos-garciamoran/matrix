@extends('app')
@section('title', 'Sign out history')

@section('content')
<div class="card">
  <h5 class="card-header">Sign out history</h5>
  <div class="card-body">
    <div class="row align-items-center mb-4">
      <div class="col-lg">
        <a href="/users/{{ $student->user_id }}">
          <img src="{{ $student->user->profile_photo() }}" height="50" width="50" alt="Profile photo">{{ $student->user->name }}
        </a>
        <span class="badge badge-pill badge-dark ml-3">G{{ $student->grade }}</span>
      </div>
    </div>

    <table class="table table-responsive-lg">
      <thead>
        <tr>
          <th scope="col-lg">#</th>
          <th scope="col-lg">Overnight</th>
          <th scope="col-lg">Signed out</th>
          <th scope="col-lg">Signed in</th>
          <th scope="col-lg">Return date</th>
          <th scope="col-lg">Destination</th>
          <th scope="col-lg">School phone</th>
        </tr>
      </thead>

      <tbody>
        {{-- TODO: use something different than tables in mobile --}}
        @foreach($trips as $trip)
        <tr>
          <th scope="row">{{ $trips->total() - $loop->index }}</th>
          <td>
            @if($trip->overnight) <span class="oi oi-check"></span>
            @else <span class="oi oi-x"></span>
            @endif
          </td>
          <td>{{ date("d-m-Y H:i", strtotime($trip->created_at)) }}</td>
          <td>
            @if($trip->signed_in) {{ date("d-m-Y H:i", strtotime($trip->updated_at)) }}
            @else <span class="oi oi-x"></span>
            @endif
          </td>
          <td>{{ date("d-m-Y H:i", strtotime($trip->return_date)) }}</td>
          <td>{{ $trip->destination }}</td>
          <td>
            @if($trip->school_phone) #{{ $trip->school_phone }} | Charger
              @if($trip->charger) <span class="oi oi-check ml-1"></span>
              @else <span class="oi oi-x ml-1"></span>
              @endif
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    @if($trips->links())
    <div class="row mt-5">
      <div class="col d-flex justify-content-center">{{ $trips->links() }}</div>
    </div>
    @endif
  </div>
</div>
@endsection
