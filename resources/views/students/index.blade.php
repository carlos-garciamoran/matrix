@extends('app')
@section('title', $title)

@section('content')
<div class="card">
  <h5 class="card-header">{{ $title }}</h5>
  <div class="card-body">
    {{-- TODO: make mobile friendly --}}
    @foreach($students as $student)
      @php($onCampus=$student->isOnCampus())
      <div class="row align-items-center{{ $loop->last ? '' : ' mb-4' }}">
        <div class="col-lg-3">
          <a href="/users/{{ $student->user_id }}">
            <img src="{{ $student->user->profile_photo() }}" alt="Profile photo" class="mr-2 rounded" height="50" width="40">{{ $student->nickname ? '[' . $student->nickname . '] ' : '' }}{{ $student->user->name }}</a>
        </div>
        <div class="col-lg-1">
          <span class="badge badge-pill badge-dark">G{{ $student->grade }}</span>
        </div>
        <div class="col-lg-4">
          @if($onCampus)
            @if($student->hasAuthorisation())
            <span class="badge badge-pill badge-success">On campus | Authorised ({{ date("d-m-Y", strtotime($student->authorisation->leave_date)) }} | {{ date("d-m-Y", strtotime($student->authorisation->return_date)) }})</span>
            @else <span class="badge badge-pill badge-success">On campus | Not authorised</span>
            @endif
          @else
            @if($student->isLate()) <span class="badge badge-pill badge-danger">Off campus | LATE</span>
            @else <span class="badge badge-pill badge-info">Off campus | OK</span>
            @endif

            @if($student->openTrips->first()->overnight) <span class="oi oi-moon"></span>
            @endif
          @endif
        </div>

        <div class="col-lg">
          <a class="btn btn-outline-info" href="/history/{{ $student->user_id }}">History</a>
        </div>

        @if($onCampus)
        <div class="col-lg">
          @if($student->hasAuthorisation())
          <form method="POST" action="/revoke-overnight/{{ $student->user_id }}">
            {{-- TODO: @click pop up modal with confirmation --}}
            @csrf
            <button class="btn btn-danger" type="submit">Revoke</button>
          </form>
          @else
          <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-{{ $loop->index }}">Authorise</button>

          <div class="modal fade" id="modal-{{ $loop->index }}" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Authorisation form</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                {{-- TODO: refactorise into fetch/AJAX request to avoid page reload --}}
                  <form method="POST" action="/authorise-overnight/{{ $student->user_id }}">
                    @csrf
                    <div class="form-group mt-1">
                      <label for="leave-{{ $loop->index }}">Leave date</label>
                      <input class="form-control" type="date" id="leave-{{ $loop->index }}" name="leave_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group mt-1">
                      <label for="return-{{ $loop->index }}">Return date</label>
                      <input class="form-control" type="date" id="return-{{ $loop->index }}" name="return_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-block btn-success mt-3">Authorise {{ $student->user->first_name }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>
        @endif
      </div>
    @endforeach

    @if(method_exists($students, 'links') && $students->links())
    <div class="row mt-5">
      <div class="col d-flex justify-content-center">{{ $students->links() }}</div>
    </div>
    @endif
  </div>
</div>
@endsection
