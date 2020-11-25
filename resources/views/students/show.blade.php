{{-- TODO: make pretty --}}

@if($student->nickname)
<div class="row">
  <div class="col-lg">
    Nickname: {{ $student->nickname }}
  </div>
</div>
@endif

@if($student->phone)
<div class="row">
  <div class="col-lg">
    Phone: {{ $student->phone }}
  </div>
</div>
@endif

<div class="row">
  <div class="col-lg">
    Country: {{ $student->country }}
  </div>
</div>

<hr>

<div class="row">
  <div class="col-lg">
    <h5>Academic</h5>
  </div>
</div>

<hr>

<div class="row">
  <div class="col-lg">
    Grade: {{ $student->grade }}
  </div>
</div>

<hr>

<div class="row">
  <div class="col-lg">
    <h5>Advisor(s)</h5>
    <hr>
    @php($advisors=$student->advisors('as_user'))
    <ul>
      @foreach($advisors as $advisor)
      <li>{{ $advisor->name }}</li>
      @endforeach
    </ul>
  </div>
</div>

<hr>

<div class="row">
  <div class="col-lg">
    <h5>Residential</h5>
  </div>
</div>

<hr>

<div class="row">
  <div class="col-lg">
    Residence: {{ $student->residence }} <br>
    House: {{ $student->house }} <br>
    Room: {{ $student->room }}
  </div>
</div>
