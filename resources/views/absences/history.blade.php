@extends('app')
@section('title', 'Absence history')

@section('content')
<div class="card">
  <h5 class="card-header">Absence History</h5>
  <div class="card-body">
    <div class="row align-items-center mb-4">
      <div class="col-lg">
        <a href="/users/{{ $user->id }}">
          <img src="{{ $user->profile_photo() }}" height="50" width="50" alt="Profile photo">{{ $user->name }}
        </a>
      </div>
    </div>
  </div>

  <table class="table table-responsive-lg">
    <thead>
      <tr>
        <th scope="col-lg">#</th>
        <th scope="col-lg">Leave date</th>
        <th scope="col-lg">Return date</th>
        <th scope="col-lg">Reason</th>
        <th scope="col-lg">Additional comment</th>
        <th scope="col-lg">Approved</th>
      </tr>
    </thead>
    @foreach($absences as $absence)
    <tr>
      <th scope="row">{{ $loop->index + 1 }}</th>
      <td>{{ date("d-m-Y", strtotime($absence->leave_date)) }}</td>
      <td>{{ date("d-m-Y", strtotime($absence->return_date)) }}</td>
      <td>{{ $absence->reason }}</td>
      <td>{{ $absence->comment }}</td>
      <td>{{ $absence->approved }}</td>
    </tr>
    @endforeach

  </tbody>
</table>
</div>
@endsection
