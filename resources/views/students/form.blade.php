@csrf
<div class="form-group row">
  <label for="advisors" class="col-lg-4 col-form-label text-lg-right{{ $errors->has('advisors.*') ? ' text-danger' : '' }}">Advisor(s) *</label>
  <div class="col-lg-5">
    <select id="advisors" class="form-control chosen-select" id="advisors" name="advisors[]" data-placeholder="Choose 1 or 2 advisors..." multiple required>
      {{-- TODO: preselect advisors when editing: check "chosen" docs to predefine options --}}
      @foreach($advisors as $advisor)
      <option value="{{ $advisor->id }}">{{ $advisor->name }}</option>                
      @endforeach
    </select>
  </div>
</div>

<div class="form-group row">
  <label for="nickname" class="col-lg-4 col-form-label text-lg-right">Nickname</label>
  <div class="col-lg-5">
    <input id="nickname" type="text" class="form-control{{ $errors->has('nickname') ? ' is-invalid' : '' }}" name="nickname" maxlength="50" value="{{ old('nickname', $student->nickname) }}" autofocus>
    @includeWhen($errors->has('nickname'), 'common.input-error', ['error' => $errors->first('nickname')])
    <div class="invalid-feedback">Make sure the nickname is less than 50 characters long.</div>
  </div>
</div>

{{-- TODO: predefine list of countries; use `chosen` select; max = 3 --}}
<div class="form-group row">
  <label for="country" class="col-lg-4 col-form-label text-lg-right">Country *</label>
  <div class="col-lg-5">
    <input id="country" type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" maxlength="50" value="{{ old('country', $student->country) }}" required>
    @includeWhen($errors->has('country'), 'common.input-error', ['error' => $errors->first('country')])
    <div class="invalid-feedback">Make sure a country is included.</div>
  </div>
</div>

<div class="form-group row">
  <label for="birthdate" class="col-lg-4 col-form-label text-lg-right">Birthdate</label>
  <div class="col-lg-5">
    <input id="birthdate" type="date" class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}" name="birthdate" value="{{ old('birthdate', $student->birthdate) }}">
    @includeWhen($errors->has('birthdate'), 'common.input-error', ['error' => $errors->first('birthdate')])
    <div class="invalid-feedback">Make sure a birthdate is included.</div>
  </div>
</div>

<div class="form-group row">
  <label for="phone" class="col-lg-4 col-form-label text-lg-right">Phone</label>
  <div class="col-lg-5">
    <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" maxlength="30" value="{{ old('phone', $student->phone) }}">
    @includeWhen($errors->has('phone'), 'common.input-error', ['error' => $errors->first('phone')])
  </div>
</div>

<div class="form-group row">
  <label for="grade" class="col-lg-4 col-form-label text-lg-right">Grade *</label>
  <div class="col-lg-5">
    <select id="grade" class="form-control" id="grade" name="grade" required>
      @foreach(range(10, 12) as $grade)
      <option value="{{ $grade }}"{{ $grade==$student->grade ?  ' selected' : '' }}>G{{ $grade }}</option>
      @endforeach
    </select>
    @includeWhen($errors->has('grade'), 'common.input-error', ['input' => $errors->first('grade')])
  </div>
</div>

<div class="form-group row">
  <label for="residence" class="col-lg-4 col-form-label text-lg-right">Residence *</label>
  <div class="col-lg-5">
    <select id="residence" class="form-control" id="residence" name="residence" required>
      @foreach(range(1, 4) as $residence)
      <option{{ $residence==$student->residence ?  ' selected' : '' }}>{{ $residence }}</option>
      @endforeach
    </select>
    @includeWhen($errors->has('residence'), 'common.input-error', ['error' => $errors->first('residence')])
  </div>
</div>

<div class="form-group row">
  <label for="house" class="col-lg-4 col-form-label text-lg-right">House *</label>
  <div class="col-lg-5">
    <select id="house" class="form-control" id="house" name="house" required>
      @foreach([10, 11, 12, 14, 15, 20] as $house)
      <option{{ $house==$student->house ?  ' selected' : '' }}>{{ $house }}</option>
      @endforeach
    </select>
    @includeWhen($errors->has('house'), 'common.input-error', ['error' => $errors->first('house')])
  </div>
</div>

<div class="form-group row">
  <label for="room" class="col-lg-4 col-form-label text-lg-right">Room *</label>
  <div class="col-lg-5">
    <select id="room" class="form-control" id="room" name="room" required>
      @foreach(['A', 'B', 'C', 'D', 'E', 'F', 'G'] as $room)
      <option{{ $room==$student->room ?  ' selected' : '' }}>{{ $room }}</option>
      @endforeach
    </select>
    @includeWhen($errors->has('room'), 'common.input-error', ['error' => $errors->first('room')])
  </div>
</div>

<div class="form-group row pt-4">
  <div class="col-lg-5 offset-md-4">
    <button type="submit" class="btn btn-primary">Finish {{ $action }}</button>
  </div>
</div>
