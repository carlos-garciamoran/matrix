@if ($errors->any())
  <div class="row">
    <div class="col">
      <div class="alert alert-danger d-flex justify-content-center">
        @foreach ($errors->all() as $error){{ $error }}<br>@endforeach
      </div>
    </div>
  </div>
@endif
