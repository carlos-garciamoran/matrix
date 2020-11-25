@extends('app')
@section('title', 'Sign Out')

@section('content')
<div class="card">
  <div class="card-header">
    <span class="h5">Sign Out</span>
    @if($student->hasAuthorisation())
    <span class="badge badge-success">Authorised ({{ date("d-m-Y", strtotime($student->authorisation->leave_date)) }} | {{ date("d-m-Y", strtotime($student->authorisation->return_date)) }})</span>
    @else
    <span class="badge badge-warning">Not authorised</span>
    @endif
  </div>
  <div class="card-body">
    @include('common.form-errors')

    <form class="needs-validation" method="POST" novalidate>
      @csrf

      <div class="row">
        <div class="col-lg form-group">
          <label for="date">Return date and time</label>
          <small class="text-muted pl-1">DD/MM/YYYY HH:MM</small>
          <input class="form-control" type="datetime-local" name="return_date" id="date" value="{{ date('Y-m-d') . 'T' . date('H:i')}}" required autofocus>
          <div class="invalid-feedback">Make sure your return date and time are valid.</div>
        </div>

        <div class="col-lg form-group">
          <label for="destination">Destination</label>
          <select class="form-control" name="destination" id="destination" required>
            @foreach(['Convini', 'Saku', 'Outlet', 'Tsuruya', 'OEd Trip', 'Kazakoshi Park'] as $destination)
            <option>{{ $destination }}</option>
            @endforeach
            <option value="other">Other &darr;</option>
          </select>
          <input class="form-control mt-2" type="text" id="other-destination" placeholder="Please be specific" minlength="3" maxlength="50" hidden>
          <div class="invalid-feedback">Make sure your destination is valid.</div>
        </div>

        @if(count($phones) > 0)
        <div class="col-lg form-group">
          <label for="school-phone">Are you taking a school phone?</label>
          <select class="form-control" name="school_phone" id="school-phone">
            <option value>No</option>
            @foreach ($phones as $phone)
            <option value="{{ $phone->id }}">{{ $phone->id }} {{ $phone->name }}</option>
            @endforeach
          </select>
          <div id="charger" class="mt-3" hidden>
            <label for="charger-check">Are you taking a school phone charger?</label>
            <div class="custom-control custom-checkbox" id="charger-check">
              <input type="checkbox" class="custom-control-input" id="check" name="charger" value="1">
              <label class="custom-control-label" for="check">Yes</label>
            </div>
          </div>
        </div>
        @else
        <div class="col-lg d-flex align-items-center">
          <div class="alert alert-warning">There are no school phones available.</div>
        </div>
        @endif
      </div>

      <button class="btn btn-primary btn-block" type="submit">Sign Out</button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script src="/js/bootstrap-form.js"></script>

<script>
  $('#destination').change(function() {
    if ($('#destination option:selected').val() == 'other') {
      $('#destination').removeAttr('name');
      $('#other-destination').attr('name', 'destination').prop('required', true).removeAttr('hidden');
    }
    else {
      $('#destination').attr('name', 'destination');
      $('#other-destination').removeAttr('name required').prop('hidden', true);
    }
  });

  $('#school-phone').change(function() {
    $('#school-phone option:selected').text() !== 'No'
      ? $('#charger').removeAttr('hidden')
      : $('#charger').prop('hidden', true);
  });
</script>
@endsection
