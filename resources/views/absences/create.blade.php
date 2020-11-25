@extends('app')
@section('title', 'Absence')

@section('content')
  <div class="card">
    <div class="card-header h5">Request an absence</div>
    <div class="card-body">
      @include('common.form-errors')
      <form class="needs-validation" method="POST" action="/absences" novalidate>
        @csrf
        <div class="row form-group">
          <div class="col">
            <label for="leave-date">Leave date</label>
            <small class="text-muted pl-1">DD/MM/YYYY</small>
            <input class="form-control" type="date" name="leave_date" id="leave-date" value="{{ date('Y-m-d')}}" required autofocus>
            <div class="invalid-feedback">Make sure your leave date is valid.</div>
          </div>
          <div class="col">
            <label for="return-date">Return date</label>
            <small class="text-muted pl-1">DD/MM/YYYY</small>
            <input class="form-control" type="date" name="return_date" id="return-date" value="{{ date('Y-m-d')}}" required autofocus>
            <div class="invalid-feedback">Make sure your return date is valid.</div>
          </div>
          <div class="col">
            <label for="reason">Reason</label>
            <select class="form-control" name="reason" id="reason" required>
              @foreach(['Medical', 'Personal', 'Professional development', 'School-related'] as $reason)
              <option>{{ $reason }}</option>
              @endforeach
              <option value="other">Other (specify in additional comment)</option>
            </select>
          </div>
        </div>
        <div>
          <label for="comment">Additional comment</label>
          <textarea class="form-control" name="comment" id="comment" columns="6"></textarea>
        </div>
        <button class="btn btn-primary btn-block mt-2" type="submit">Request</button>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
<script src="/js/bootstrap-form.js"></script>

<script>
  $('#reason').change(function() {
    if ($('#reason option:selected').val() == 'other') {
      $('#comment').prop('required', true);
    }
    else {
      $('#comment').removeAttr('required');
    }
  });
</script>
@endsection
