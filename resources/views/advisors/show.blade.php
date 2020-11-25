<div class="row">
  <div class="col-lg">
    <h5>Advisees</h5>
    <hr>
    @php($advisees=$advisor->students('as_user'))
    <ul>
      @foreach($advisees as $advisee)
      <li>{{ $advisee->name }}</li>
      @endforeach
    </ul>
  </div>
</div>
